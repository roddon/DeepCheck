<?php

namespace App\Services;

use DataTables;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Media;
use App\Models\MediaTraining;
use App\Models\MediaTrainingItems;
use App\Models\Supplier;
use App\Models\TrueLayerPayment;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class InvoiceService extends BaseService
{
    public function __construct(Invoice $invoice)
    {
        $this->model = $invoice;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->model->with(['country', 'company'])->get()->sortByDesc('created_at');
    }


    public function addInvoice($file, $invoiceId)
    {
        $invoice = $this->model->find($invoiceId);

        $media =  $invoice->addMedia($file)
            ->preservingOriginal()
            ->toMediaCollection(Invoice::DOCUMENT);

        $media = $this->renameFile($media, $file);

        $this->activityLog($invoice, 'Supplier Verification Pending', 'success', $media->mime_type);
        return $media;
    }


    public function supplierView($id)
    {
        return Supplier::with(['invoices', 'user'])->find($id);
    }

    public function varifyInvoice($request)
    {
        $supplier = Supplier::find($request->supplierId);
        $supplier->name = $request->supplierName;
        $supplier->address_1 = $request->address1;
        $supplier->address_2 = $request->address2;
        $supplier->account_number = $request->accountNumber;
        $supplier->vat_number = $request->vatNumber;
        $supplier->save();

        $invoice = $this->model->find($request->invoiceId);
        $invoice->total = $request->total;
        $invoice->save();

        $invoiceMedia = $invoice->getMedia(Invoice::DOCUMENT);

        foreach ($invoiceMedia as $media) {
            $media->new_DRS = 0;
            $media->save();
        }
    }

    public function supplierList()
    {
        $userId = Auth::user()->id;
        return Company::where('user_id', $userId)->paginate();
    }

    public function dataTables()
    {
        $query = $this->newQuery()->where('user_id', Auth::user()->id);
        $query = QueryBuilder::for($query)->defaultSort('-id')->with(['country', 'supplier']);

        return DataTables::of($query)
            ->editColumn('supplier.name', function (Invoice $invoice) {
                $name = 'Awaiting Analysis';
                if ($invoice->supplier) {
                    $name = $invoice->supplier->present()->name;
                }



                return '
                    <a  invoiceId="' . $invoice->id . '"
                            name="aInvoiceImage[]"
                    class="micro d-flex align-items-center " href="javascript:void(0);">
                    <img src="' . asset('assets/images/micro_icon.png') . '" alt="">' . $name . '</a>';

                // return 'Awaiting Analysis';
            })
            ->editColumn('country.name', function (Invoice $invoice) {
                return optional($invoice->country)->name;
            })
            ->editColumn('scan_date', function (Invoice $invoice) {
                return $invoice->scan_date ? Carbon::parse($invoice->scan_date)->format('d/m/Y') : '';
            })
            ->editColumn('due_date', function (Invoice $invoice) {
                return $invoice->due_date ? Carbon::parse($invoice->due_date)->format('d/m/Y') : '';
            })
            ->editColumn('total', function (Invoice $invoice) {
                return $invoice->total > 0 ? $invoice->total : '';
            })
            ->editColumn('status', function (Invoice $invoice) {
                return $invoice->present()->invoiceStatus;
            })
            ->editColumn('statusColorClass', function (Invoice $invoice) {
                return $invoice->present()->invoiceStatusColor;
            })
            ->setRowClass(function ($invoice) {
                if ($invoice->status == INVOICE::CHECK_TEXT) {
                    return 'bar_color_2';
                } else if ($invoice->status == INVOICE::OK) {
                    return 'bar_color_1';
                }
            })
            ->editColumn('updatedAt', function (Invoice $invoice) {
                //return $invoice->present()->uploadedAt;
                return Carbon::parse($invoice->updated_at)->format('d/m/Y h:i:s');
            })
            ->rawColumns(['supplier.name', 'status'])
            ->addIndexColumn()
            ->toJson();
    }

    public function suppplierInvoice($supplierId, $paginate = true)
    {
        if ($paginate) {
            return $this->model->with('documentMedia')->where('supplier_id', $supplierId)->paginate();
        } else {
            return $this->model->with('documentMedia')->where('supplier_id', $supplierId)->get();
        }
    }


    public function getAllNewInvoices()
    {
        return $this->model->whereHas('supplier', function ($supplier) {
            return $supplier->where('user_id', Auth::user()->id);
        })
            ->whereHas('documentMedia', function ($query) {
                return $query->where('new_DRS', 1);
            })
            ->with(['country', 'supplier'])->paginate();
    }

    public function updateInvoiceMedia($updateData, $mediaId)
    {
        $media = Media::find($mediaId);

        $mediaTraining = MediaTraining::where('media_id', $mediaId)->latest()->first();

        $insertedData = [
            'model_type' => $media->model_type,
            'model_id' => $media->model_id,
            'name' => $media->name,
            'file_name' => $media->file_name,
            'name_entity' => $media->name_entity,
            'address1' => $media->address1,
            'address2' => $media->address2,
            'post_code' => $media->post_code,
            'city' => $media->city,
            'Country' => $media->Country,
            'Bank_account' => $media->Bank_account,
            'VAT_Number' => $media->VAT_Number,
            'VAT' => $media->VAT,
            'Email' => $media->Email,
            'Total_price' => $media->Total_price,
            'big_text' => $media->big_text,
            'corrected_name_entity' => isset($updateData['name_entity']) && $updateData['name_entity'] ? $updateData['name_entity'] : ($mediaTraining ? $mediaTraining->corrected_name_entity : $media->name_entity),
            'corrected_address1' => isset($updateData['address1']) && $updateData['address1'] ? $updateData['address1'] : ($mediaTraining ? $mediaTraining->corrected_address1 : $media->address1),
            'corrected_address2' => isset($updateData['address2']) && $updateData['address2'] ? $updateData['address2'] : ($mediaTraining ? $mediaTraining->corrected_address2 : $media->address2),
            'corrected_post_code' => isset($updateData['post_code']) && $updateData['post_code'] ? $updateData['post_code'] : ($mediaTraining ? $mediaTraining->corrected_post_code : $media->post_code),
            'corrected_city' => isset($updateData['city']) && $updateData['city'] ? $updateData['city'] : ($mediaTraining ? $mediaTraining->corrected_city : $media->city),
            'corrected_country' => isset($updateData['Country']) && $updateData['Country'] ? $updateData['Country'] : ($mediaTraining ? $mediaTraining->corrected_country : $media->Country),
            'corrected_bank_account' => isset($updateData['Bank_account']) && $updateData['Bank_account'] ? $updateData['Bank_account'] : ($mediaTraining ? $mediaTraining->corrected_bank_account : $media->Bank_account),
            'corrected_VAT_number' => isset($updateData['VAT_Number']) && $updateData['VAT_Number'] ? $updateData['VAT_Number'] : ($mediaTraining ? $mediaTraining->corrected_VAT_number : $media->VAT_Number),
            'corrected_VAT' => isset($updateData['VAT']) && $updateData['VAT'] ? $updateData['VAT'] : ($mediaTraining ? $mediaTraining->corrected_VAT : $media->VAT),
            'corrected_email' => isset($updateData['Email']) && $updateData['Email'] ? $updateData['Email'] : ($mediaTraining ? $mediaTraining->corrected_email : $media->Email),
            'corrected_total_price' => isset($updateData['Total_price']) && $updateData['Total_price'] ? $updateData['Total_price'] : ($mediaTraining ? $mediaTraining->corrected_total_price : $media->Total_price),
            'corrected_quantity' => isset($updateData['Quantity']) && $updateData['Quantity'] ? $updateData['Quantity'] : ($mediaTraining ? $mediaTraining->corrected_quantity : $media->Quantity),
            'corrected_big_text' => isset($updateData['big_text']) && $updateData['big_text'] ? $updateData['big_text'] : ($mediaTraining ? $mediaTraining->corrected_big_text : $media->big_text),
            'corrected_phone' => isset($updateData['phone']) && $updateData['phone'] ? $updateData['phone'] : ($mediaTraining ? $mediaTraining->corrected_phone : $media->phone),
            'corrected_web' => isset($updateData['web']) && $updateData['web'] ? $updateData['web'] : ($mediaTraining ? $mediaTraining->corrected_web : $media->web),
            'corrected_tax' => isset($updateData['tax']) && $updateData['tax'] ? $updateData['tax'] : ($mediaTraining ? $mediaTraining->corrected_tax : $media->tax),
            'media_id' => $mediaId
        ];
        return MediaTraining::create($insertedData);
    }

    public function sendToAdminReview($mediaId)
    {
        return Media::where('id', $mediaId)->update(
            [
                'review_status' => 0,
                'date_of_request' => Carbon::now()->format('Y-m-d')
            ]
        );
    }

    public function changeRequestList()
    {
        $query = Media::whereRaw('model_type = "App\\Models\\Invoice"')->whereNotNull('review_status')->get();

        return DataTables::of($query)
            ->editColumn('name', function (Media $media) {
                return optional(optional($media->model)->user)->name;
            })
            ->editColumn('country', function (Media $media) {
                return optional(optional($media->model)->country)->name;
            })
            ->editColumn('supplierVerification', function (Media $media) {
                return optional(optional($media->model)->supplier)->is_address_verified ? 'Yes' : 'No';
            })
            ->editColumn('fileName', function (Media $media) {
                return $media->file_name;
            })
            ->editColumn('invoiceNo', function (Media $media) {
                return optional($media->model)->invoice_number;
            })
            ->editColumn('status', function (Media $media) {
                return $media->present()->invoiceStatus;
            })
            ->editColumn('statusColorClass', function (Media $media) {
                return $media->present()->invoiceStatusColor;
            })
            ->editColumn('dateOfRequest', function (Media $media) {
                return $media->date_of_request;
            })
            ->editColumn('action', function (Media $media) {
                return '
                    <a class="micro d-flex align-items-center " href="' .
                    route('admin.change-request.editInvoiceMedia', ['invoiceId' => $media->model_id])
                    . '">review</a>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }

    public function updateInvoiceMediaStatus($reviewStatus, $mediaId)
    {
        $media = Media::find($mediaId);

        $media->review_status = $reviewStatus;
        $media->save();
    }

    public function updateInvoiceMediaItems($items)
    {
        foreach ($items as $itemId => $item) {
            MediaTrainingItems::create(
                [
                    'media_invoice_items_id' => $itemId,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['total_price'],
                ]
            );
        }
    }


    public function createPayment($invoiceIds, $response, $tracingId)
    {
        $user = \Auth::user();
        TrueLayerPayment::create([
            'invoices_id' => $invoiceIds,
            'payment_id' => $response->id,
            'tracing_id' => $tracingId,
            'payment_idempotency_id' => $response->paymentIdempotencyId,
            'payment_lifecycle_id' => $response->paymentLifecycleId,
            'institution_consent_id' => $response->institutionConsentId,
            'status' => $response->status,
            'payment_reference' => $response->reference,
            'amount' => $response->amount,
            'currency' => $response->currency,
            'user_id' => $user->id
        ]);


        $user->useSubscription($user, 1, config('config.subscription.safepay'));
    }


    public function createBulkPayment($invoiceIds, $response, $tracingId, $paymentRequest)
    {
        $user = \Auth::user();
        $paymentCount = count($invoiceIds);
        $payments = $paymentRequest['payments'];

        foreach ($invoiceIds as $invoiceId) {
            $paymentInfo = null;
            foreach ($payments as $payment) {
                $invoice = explode('-', $payment['paymentIdempotencyId']);
                if (isset($invoice[1]) && $invoice[1] == $invoiceId) {
                    $paymentInfo = $payment;
                    break;
                }
            }


            TrueLayerPayment::create([
                'invoices_id' => $invoiceId,
                'payment_id' => $response->id,
                'tracing_id' => $tracingId,
                'payment_idempotency_id' => $paymentInfo['paymentIdempotencyId'],
                'institution_consent_id' => $response->institutionConsentId,
                'status' => $response->status,
                'payment_reference' => $paymentInfo['reference'],
                'amount' => $response->amount,
                'currency' => $paymentInfo['amount']['currency'],
                'user_id' => \Auth::user()->id
            ]);
        }

        $user->useSubscription($user, $paymentCount, config('config.subscription.safepay'));
    }

    public function updatedPaymentStatus($id)
    {
        $this->updateById($id, [
            'status' => Invoice::PAID
        ]);
    }

    public function getDueDatePaymentInvoices()
    {
        return $this->model->whereDate('due_date', '<', Carbon::now())
            ->whereHas('supplier', function ($query) {
                return $query->where('status', Supplier::APPROVED);
            })
            ->where('status', Invoice::NOT_PAID)
            ->get()->pluck(['id'])->toArray();
    }
}
