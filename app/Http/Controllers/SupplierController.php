<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckInviteSupplierRequest;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;

class SupplierController extends AppController
{

    public function __construct(SupplierRepository $supplier)
    {
        $this->supplier = $supplier;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->supplier->dataTables($request);
        }

        return view('manage.suppliers.index');
    }

    public function verification(Request $request)
    {
        return $this->supplier->verification($request);
    }


    public function inviteSupplier(Request $request)
    {
        return $this->supplier->inviteSupplier($request);
    }

    public function invite(CheckInviteSupplierRequest $request)
    {
        return $this->supplier->invite($request);
    }

    public function export()
    {
        return $this->supplier->exportCSV();
    }


    public function import(Request $request)
    {
        return $this->supplier->importCSV($request);
    }


    public function getInvoiceDetail(Request $request)
    {
        return $this->supplier->getInvoiceDetail($request->invoice_id);
    }


    public function verifyInfomation(Request $request)
    {
        return $this->supplier->verifySupplierInformation($request);
    }


    public function verifyPhoneOtp(Request $request)
    {
        return $this->supplier->verifyPhoneOtp($request);
    }

    public function checkSupplierVerification(Request $request)
    {
        return $this->supplier->checkSupplierVerification($request);
    }

    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadDocument(Request $request)
    {
        return $this->supplier->uploadDocument($request);
    }

    public function editInvoiceMedia(Request $request)
    {
        return $this->supplier->editInvoiceMedia($request);
    }

    public function updateInvoiceMedia(Request $request)
    {
        return $this->supplier->updateInvoiceMedia($request);
    }

    public function sendToAdminReview(Request $request)
    {
        return $this->supplier->sendToAdminReview($request);
    }

    public function updateInvoiceMediaItems(Request $request)
    {
        return $this->supplier->updateInvoiceMediaItems($request);
    }
}
