<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\StripeLogRepository;

class StripeLogController extends Controller
{
    protected $repository;

    public function __construct(StripeLogRepository $stripeLogRepository)
    {
        $this->repository = $stripeLogRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->repository->dataTable($request);
        }
        return view('manage.admin.stripeLog.index');
    }

    public function counterLog(Request $request)
    {
        if ($request->ajax()) {
            return $this->repository->counterLog($request);
        }
        return view('manage.admin.stripeLog.counter-log');
    }
}
