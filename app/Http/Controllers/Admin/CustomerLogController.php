<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\CustomerLogRepository;

class CustomerLogController extends Controller
{
    protected $repository;

    public function __construct(CustomerLogRepository $customerLogRepository)
    {
        $this->repository = $customerLogRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->repository->dataTable($request);
        }
        return view('manage.admin.customerLog.index');
    }
}
