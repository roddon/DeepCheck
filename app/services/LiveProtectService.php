<?php

namespace App\Services;

use DataTables;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Supplier;
use App\Models\TrueLayerPayment;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class LiveProtectService extends BaseService
{
    public function __construct(Invoice $invoice)
    {
        $this->model = $invoice;
    }

    public function index()
    {
        return $this->model->with('supplier')->paginate();
    }

    public function paymentRequest($request)
    {
        $invoiceIds = $request->invoiceIds;
        $forDueDateRequest = $request->forDueDateRequest;
        if ($this->varifyForDueDateInvoice($invoiceIds, $forDueDateRequest)) {
            return response()->json(['success' => true, 'message' => 'Inovices paymet request send successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Inovices are not properly selected for the due date']);
        }
    }

    public function varifyForDueDateInvoice($invoiceIds, $forDueDateRequest)
    {
        if ($forDueDateRequest != 'false') {
            $countDueDateInvoice = $this->model->whereDate('due_date', '<=', Carbon::now())->whereIn('id', $invoiceIds)->count();
            if ($countDueDateInvoice != count($invoiceIds)) {
                return false;
            }
        }
        return true;
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

    public function dataTables()
    {
        $query = QueryBuilder::for($this->newQuery()->whereHas('supplier', function ($supplier) {
            return $supplier->where('user_id', Auth::user()->id);
        }))
            // ->whereIn(
            //     'status',
            //     [
            //         Invoice::PAID,
            //         Invoice::NOT_PAID,
            //         Invoice::SUPPLIER_NOT_VERIFIED,
            //         Invoice::FALSE_INVOICE
            //     ]
            // )
            ->defaultSort('-id')->with(['supplier']);

        return DataTables::of($query)
            ->editColumn('id', function (Invoice $invoice) {
                $checkDisabled = '';
                // if ($invoice->status !== Invoice::NOT_PAID || $invoice->supplier->status != Supplier::APPROVED) {
                //     $checkDisabled = 'disabled';
                // }
                return '<label class="cont check-pad">
                            <input type="checkbox" name="chkSafePay[]" ' . $checkDisabled . ' data-id="' . $invoice->id . '">
                            <span class="checkmark"></span>
                        </label>';
            })
            ->editColumn('supplier.name', function (Invoice $invoice) {

                if (optional($invoice->documentMedia)->new_DRS) {
                    return '
                    <a class="micro d-flex align-items-center" href="' .
                        route('invoice.detail', ['id' => $invoice->id])
                        . '"><img src="' . asset('assets/images/micro_icon.png') . '" alt="">' .
                        optional($invoice->supplier)->name . '</a>';
                } else {
                    return '
                    <a class="micro d-flex align-items-center" href="' .
                        route('sVault.supplier.verification', ['supplier_id' => $invoice->supplier->id])
                        . '?invoice-verification=1"><img src="' . asset('assets/images/micro_icon.png') . '" alt="">' .
                        optional($invoice->supplier)->name . '</a>';
                }

                // return '
                //     <a class="micro" href="' . route('sVault.supplier.verification', ['supplier_id' => optional($invoice->supplier)->id]) . '"><img src="' . asset("assets/images/micro_icon.png") . '" alt="">' . optional($invoice->supplier)->name . '</a>
                // ';
            })
            ->editColumn('bank_reference', function ($invoice) {
                return optional(TrueLayerPayment::whereRaw('FIND_IN_SET(' . $invoice->id . ', invoices_id)')->first())->payment_reference;
            })
            ->editColumn('transfer_date', function ($invoice) {
                return optional(TrueLayerPayment::whereRaw('FIND_IN_SET(' . $invoice->id . ', invoices_id)')->first())->created_date ? \Carbon\Carbon::parse(optional(TrueLayerPayment::whereRaw('FIND_IN_SET(' . $invoice->id . ', invoices_id)')->first())->created_date)->format('Y-m-d') : '';
            })
            ->editColumn('supplier.account_number', function (Invoice $invoice) {
                return optional($invoice->supplier)->account_number;
            })
            ->editColumn('scan_date', function (Invoice $invoice) {
                return Carbon::parse($invoice->scan_date)->format('d/m/Y');
            })
            ->editColumn('due_date', function (Invoice $invoice) {
                return Carbon::parse($invoice->due_date)->format('d/m/Y');
            })
            ->editColumn('total', function (Invoice $invoice) {
                return $invoice->total;
            })
            ->editColumn('status', function (Invoice $invoice) {
                if ($invoice->supplier->status == Supplier::PENDING_APPROVAL) {
                    return Invoice::STATUS[Invoice::SUPPLIER_NOT_VERIFIED];
                } else {
                    return $invoice->present()->status;
                }
            })
            ->editColumn('statusColorClass', function (Invoice $invoice) {
                if ($invoice->supplier->status == Supplier::PENDING_APPROVAL) {
                    return Invoice::STATUS_COLOUR[Invoice::SUPPLIER_NOT_VERIFIED];
                } else {
                    return $invoice->present()->statusColor;
                }
            })
            ->rawColumns(['supplier.name', 'status', 'id'])
            ->addIndexColumn()
            ->toJson();
    }


    public function updatedPaymentStatus($id, $paymentId)
    {
        $this->updateById($id, [
            'payment_id' => $paymentId,
            'status' => Invoice::PAID
        ]);
    }

    public function paymentResult($request)
    {

        $invoiceIds = $request->invoiceIds;
        $paymentInvoiceIds = explode(',', $request->invoiceIds);
        $query = QueryBuilder::for($this->newQuery()->whereHas('supplier', function ($supplier) {
            return $supplier->where('user_id', Auth::user()->id);
        }))
            ->where('status', Invoice::PAID)
            ->defaultSort('-id')->with(['supplier']);

        return DataTables::of($query)
            ->editColumn('supplier.name', function ($invoice) {
                return '
                    <a class="micro d-flex align-items-center" href="' . route('invoice.supplier', ['id' => optional($invoice->supplier)->id]) . '">
                    <img src="' . asset('assets/images/micro_icon.png') . '" alt="">' . optional($invoice->supplier)->name . '</a>
                ';
            })
            ->editColumn('bank_reference', function ($invoice) {
                return optional(TrueLayerPayment::whereRaw('FIND_IN_SET(' . $invoice->id . ', invoices_id)')->first())->payment_reference;
            })
            ->editColumn('transfer_date', function ($invoice) {
                return optional(TrueLayerPayment::whereRaw('FIND_IN_SET(' . $invoice->id . ', invoices_id)')->first())->created_at ? \Carbon\Carbon::parse(optional(TrueLayerPayment::whereRaw('FIND_IN_SET(' . $invoice->id . ', invoices_id)')->first())->created_at)->format('Y-m-d') : '';
            })
            ->editColumn('total', function ($invoice) {
                return $invoice->total;
            })
            ->editColumn('paid_out', function ($invoice) {
                return $invoice->total;
            })
            ->editColumn('difference', function ($invoice) {
                return $invoice->total - $invoice->total;
            })
            ->editColumn('status', function ($invoice) {
                return $invoice->present()->status;
            })
            ->editColumn('statusColorClass', function (Invoice $invoice) {
                return $invoice->present()->statusColor;
            })
            ->rawColumns(['supplier.name', 'status'])
            ->setRowClass(function ($invoice) use ($paymentInvoiceIds) {
                return in_array($invoice->id, $paymentInvoiceIds) ? 'bar_color_1' : '';
            })
            ->addIndexColumn()
            ->toJson();
    }
}
