<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\InvoiceRepository;
use App\Http\Requests\AddInvoiceRequest;
use App\Http\Requests\VarifyInvoiceRequest;
use App\Repositories\SupplierRepository;

class InvoiceController extends Controller
{
    protected $repository;

    public function __construct(InvoiceRepository $invoiceRepository, SupplierRepository $supplierRepository)
    {
        $this->repository = $invoiceRepository;
        $this->supplierRepositroy = $supplierRepository;
    }

    /**
     * Display a listing of the invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->table == 'invoice')
                return $this->repository->dataTables($request);
            else
                return $this->supplierRepositroy->dataTables($request);
        }
        return view('manage.invoices.invoice-supplier');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AddInvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddInvoiceRequest $request)
    {

        $userId = \Auth::user()->id;
        $data = ['status' => 0, 'user_id' => $userId];

        return $this->repository->uploadInvoices($request, $data);
    }


    public function getInvoiceDetail(Request $request)
    {
        return $this->repository->getInvoiceDetail($request->invoice_id);
    }

    public function detail($id)
    {
        request()->session()->flash('HTTP_REFERER', request()->server('HTTP_REFERER'));
        return $this->repository->show($id);
    }


    public function supplierView($supplierId, $invoiceId = null)
    {
        $supplier = $this->supplierRepositroy->view($supplierId);
        $supplierInvoices = $this->repository->suppplierInvoice($supplierId);
        $invoiceDetail = null;
        if ($invoiceId) {
            $invoiceDetail = $supplier->invoices()->with('documentMedia')->find($invoiceId);
        }
        return view('manage.invoices.supplier', compact('supplier', 'supplierInvoices', 'invoiceDetail'));
    }

    public function varifyInvoice(VarifyInvoiceRequest $request)
    {
        $this->repository->varifyInvoice($request);
        return redirect()->to(request()->session()->get('HTTP_REFERER'))->with('status', 'Invoice successfully saved');
    }

    public function supplierVarification()
    {
        $suppliers = $this->repository->supplierList();
        return view('manage.invoices.supplierVarification', compact('suppliers'));
    }
}
