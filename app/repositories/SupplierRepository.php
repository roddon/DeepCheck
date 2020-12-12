<?php

namespace App\Repositories;

use Auth;
use Carbon\Carbon;
use App\Models\Media;
use App\Models\Invoice;
use App\Helpers\Firebase;
use App\Helpers\ApiService;
use Illuminate\Http\Request;
use App\Helpers\VatValidation;
use App\Services\InvoiceService;
use App\Services\SupplierService;
use App\Notifications\InviteSuppliers;
use App\Services\UserService;
use Illuminate\Support\Facades\Notification;


class SupplierRepository extends BaseRepository
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService, InvoiceService $invoiceService, UserService $userService)
    {
        $this->supplierService = $supplierService;
        $this->invoiceService = $invoiceService;
        $this->userService = $userService;
    }


    public function dataTables(Request $request)
    {
        $user = \Auth::user();
        // $stageId = config('config.mautic.stages.supplier');
        $segmentId = config('config.mautic.segment.supplier');
        $contactParam['firstname'] = $user->name;
        $contactParam['email'] = $user->email;
        $contactParam['ipAddress'] = $request->ip();
        $contactParam['lastActive'] = date('Y-m-d H:m:i');
        $contactParam['overwriteWithBlank'] = true;
        
        $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);

        return $this->supplierService->dataTables();
    }


    public function verification(Request $request)
    {
        $invoiceVerification = $request->get('invoice-verification');

        $awaitingAnalysis = $request->get('awaiting-analysis');

        if ($awaitingAnalysis && $request->supplier_id == 0) {
            $invoiceId = $request->invoice_id;
            $invoiceData = $this->invoiceService->find($invoiceId);
            return view('manage.suppliers.awaiting-analysis', compact('invoiceData'));
        }

        $supplier = $this->supplierService->find($request->supplier_id);
        $suppliers = $this->supplierService->paginate();
        $invoices = $this->invoiceService->suppplierInvoice($request->supplier_id, false);
        $vatNumberValidate = false;
        if ($supplier->vat_number) {
            $vatValidation = new VatValidation();
            $vatValidation->validate($supplier->vat_number);
            if ($vatValidation->valid) {
                $vatNumberValidate = true;
            }
        }

        $invoiceDetail = null;
        if ($request->invoice_id) {
            $invoiceDetail = $invoices->find($request->invoice_id);
        }
        return view('manage.suppliers.verification', compact(
            'supplier',
            'suppliers',
            'invoices',
            'invoiceDetail',
            'vatNumberValidate',
            'invoiceVerification'
        ));
    }


    public function inviteSupplier(Request $request)
    {
        try {

            foreach ($request->supplierId as $supplierId) {
                $supplier = $this->supplierService->find($supplierId);
                $this->supplierService->updateById($supplier->id, [
                    'verification_token' => $this->supplierService->encrypt($supplier->email)
                ]);
                $supplier = $supplier->refresh();

                Notification::route('mail', $supplier->email)->notify(new InviteSuppliers($supplier, true));
            }

            return redirect()->back()->with('status', 'Send mail to customer successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send mail');
        }
    }


    public function invite(Request $request)
    {
        try {
            $user = \Auth::user();
            $email = $request->email;
            $name = $request->company_name;
            $supplier = $this->supplierService->findBy([
                'email' => $email,
                'user_id' => $user->id
            ]);
            $flag = false;
            $totalSupplierVerification = $user->subscriptionCheck($user, config('config.subscription.supplier_verification'));

            if (!$totalSupplierVerification) {
                return redirect()->back()->with('You have no supplier verification left');
            }

            if (!$supplier) {
                $supplier = $this->supplierService->createSupplier([
                    'email' => $email,
                    'user_id' => $user->id,
                    'account_number' => $user->company->account_number,
                    'company_name' => $name
                ]);

                $this->supplierService->activityLog($supplier, 'New Supplier created', 'success', 'Supplier Created');
                $user->useSubscription($user, 1, config('config.subscription.supplier_verification'));
            } else {
                return redirect()->back()->with('error', $email . ' email already verified');
            }

            Notification::route('mail', $email)->notify(new InviteSuppliers($supplier, $flag));

            $this->supplierService->activityLog($supplier, 'Verification mail send to the Supplier', 'success', 'Mail Sent');

            return redirect()->back()->with('status', 'Send mail to supplier successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send mail');
        }
    }


    public function exportCSV()
    {
        return $this->supplierService->exportCSV();
    }


    public function importCSV(Request $request)
    {
        try {
            if ($request->has('supplier_csv')) {

                if ($this->supplierService->importCSV($request->file('supplier_csv'))) {
                    return response()->json(['message' => 'CSV imported successfully'], 200);
                }
            }
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Sorry, we could not import your CSV file due to mismatch in format'], 422);
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function view($id)
    {
        return $this->supplierService->view($id);
    }


    public function getInvoiceDetail($invoiceId)
    {
        $invoice =  $this->invoiceService->find($invoiceId);

        return view('manage.suppliers.invoice', compact('invoice'));
    }

    public function checkSupplierVerification($request)
    {
        $supplier = $this->supplierService->find($request->supplierId);

        if ($supplier->is_address_verified) {
            return 1;
        }
        return 0;
    }

    public function uploadDocument(Request $request)
    {
        if ($request->has('customerDocument')) {

            if ($this->supplierService->addMultipleDocument($request->customerDocument, $request->supplier_id)) {
                return response()->json(['message' => 'Document uploaded successfully',], 200);
            }

            return response()->json(['message' => 'Document upload failed',], 422);
        }
    }

    public function editInvoiceMedia(Request $request)
    {
        $mediaId = $request->mediaId;
        $invoiceId = $request->invoiceId;

        $invoice =  $this->invoiceService->find($invoiceId);

        return view('manage.suppliers.edit-invoice-media', compact('invoice'));
    }

    public function updateInvoiceMedia(Request $request)
    {
        try {
            $mediaId = $request->mediaId;
            $updateData = $request->except('mediaId');
            $data = $this->invoiceService->updateInvoiceMedia($updateData, $mediaId);

            return response()->json([
                'message' => 'Invoice media Updated',
                'invoiceMedia' => $data
            ], 200);
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json(['message' => 'Something went wrong',], 422);
        }
    }

    public function sendToAdminReview(Request $request)
    {
        try {
            $mediaId = $request->mediaId;
            $this->invoiceService->sendToAdminReview($mediaId);

            return response()->json(['message' => 'Invoice send to the admin review'], 200);
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json(['message' => 'Something went wrong',], 422);
        }
    }

    public function updateInvoiceMediaItems(Request $request)
    {
        try {
            $items = $request->item;
            $this->invoiceService->updateInvoiceMediaItems($items);
            return response()->json(['message' => 'Invoice item list Updated'], 200);
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json(['message' => 'Something went wrong',], 422);
        }
    }
}
