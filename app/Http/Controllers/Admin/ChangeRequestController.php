<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\InvoiceRepository;

class ChangeRequestController extends Controller
{
    protected $repository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->repository = $invoiceRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->repository->changeRequestList($request);
        }
        return view('manage.admin.change-request.index');
    }

    public function editInvoiceMedia(Request $request)
    {
        return $this->repository->editInvoiceMedia($request);
    }

    public function updateInvoiceMediaStatus(Request $request)
    {
        return $this->repository->updateInvoiceMediaStatus($request);
    }

    public function updateInvoiceMedia(Request $request)
    {
        return $this->repository->updateInvoiceMedia($request);
    }

    public function updateInvoiceMediaItems(Request $request)
    {
        return $this->repository->updateInvoiceMediaItems($request);
    }
}
