<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Services\ActivityLogService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvoiceRepository extends BaseRepository
{
    protected $invoiceService;

    public function __construct(
        InvoiceService $invoiceService,
        ActivityLogService $activityLogService,
        UserService $userService
    ) {

        $this->invoiceService = $invoiceService;
        $this->activityLogService = $activityLogService;
        $this->userService = $userService;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->invoiceService->paginate();
    }


    public function show($id)
    {
        try {
            $invoiceDetail = $this->invoiceService->find($id);
            if ($invoiceDetail) {
                $supplier = $invoiceDetail->supplier;
                $supplierInvoices = $this->invoiceService->getAllNewInvoices();

                return view('manage.invoices.supplier', compact('supplier', 'supplierInvoices', 'invoiceDetail'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to redirect');
        }
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addInvoice(array $data)
    {
        return $this->invoiceService->create($data);
    }

    /**
     * @param Invoice $invoice
     * @return \Illuminate\Support\Collection
     */
    public function uploadInvoices(Request $request, $data)
    {
        try {
            $user = Auth::user();
            $countInvoices = count($request->invoice_file);
            $totalInvoiceCheck = $user->subscriptionCheck($user, config('config.subscription.invoice_check'));

            if ($totalInvoiceCheck >= $countInvoices) {

                foreach ($request->invoice_file as $file) {

                    $invoice = $this->addInvoice($data);

                    $this->invoiceService->addInvoice($file, $invoice->id);
                }

                $user->useSubscription($user, $countInvoices, config('config.subscription.invoice_check'));
                return response()->json(['message' => 'invoice uploaded successfully'], 200);
            }
            if ($totalInvoiceCheck) {
                return response()->json(['errors' => ['message' => 'You only have ' . $totalInvoiceCheck . ' scan left']], 422);
            }
            return response()->json(['errors' => ['message' => 'You have no invoice scan left']], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invoice upload failed'], 422);
        }
    }

    public function supplierView($id)
    {
        return $this->invoiceService->supplierView($id);
    }

    public function varifyInvoice($request)
    {
        return $this->invoiceService->varifyInvoice($request);
    }

    public function supplierList()
    {
        return $this->invoiceService->supplierList();
    }

    public function dataTables($request)
    {
        $user = \Auth::user();
        // $stageId = config('config.mautic.stages.invoice');
        $segmentId = config('config.mautic.segment.invoice');
        $contactParam['firstname'] = $user->name;
        $contactParam['email'] = $user->email;
        $contactParam['ipAddress'] = request()->ip();
        $contactParam['lastActive'] = date('Y-m-d H:m:i');
        $contactParam['overwriteWithBlank'] = true;
        
        $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);

        return $this->invoiceService->dataTables();
    }

    public function suppplierInvoice($supplierId)
    {
        return $this->invoiceService->suppplierInvoice($supplierId);
    }

    public function changeRequestList()
    {
        return $this->invoiceService->changeRequestList();
    }

    public function editInvoiceMedia($request)
    {
        $invoiceId = $request->invoiceId;

        $invoice =  $this->invoiceService->find($invoiceId);

        return view('manage.admin.change-request.edit-invoice', compact('invoice'));
    }

    public function getInvoiceDetail($invoiceId)
    {
        $invoice =  $this->invoiceService->find($invoiceId);

        return view('manage.invoices.invoice-detail', compact('invoice'));
    }

    public function updateInvoiceMediaStatus(Request $request)
    {
        try {
            $mediaId = $request->mediaId;
            $reviewStatus = $request->reviewStatus;

            $this->invoiceService->updateInvoiceMediaStatus($reviewStatus, $mediaId);

            if ($reviewStatus == 1) {
                return response()->json([
                    'message' => 'Invoice media changes approved'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Invoice media changes rejected'
                ], 200);
            }
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json(['message' => 'Something went wrong',], 422);
        }
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
            return response()->json(['message' => 'Something went wrong'], 422);
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
            return response()->json(['message' => 'Something went wrong'], 422);
        }
    }
}
