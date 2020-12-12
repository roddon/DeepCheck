<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LiveProtectRepository;

class LiveProtectController extends Controller
{
    protected $liveProtectRepository;

    public function __construct(LiveProtectRepository $liveProtectRepository)
    {
        $this->liveProtectRepository = $liveProtectRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->liveProtectRepository->dataTables($request);
        }
        return view('manage.liveProtect.index');
    }

    public function paymentRequest(Request $request)
    {
        return $this->liveProtectRepository->paymentRequest($request);
    }


    public function callback(Request $request)
    {
        return $this->liveProtectRepository->callback($request);
    }

    public function paymentResult(Request $request)
    {
        if ($request->ajax()) {
            return $this->liveProtectRepository->paymentResult($request);
        }
        $invoiceIds = $request->invoiceIds;
        return view('manage.liveProtect.payment-result', compact('invoiceIds'));
    }
}
