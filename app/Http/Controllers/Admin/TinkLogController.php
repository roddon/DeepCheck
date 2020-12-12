<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\TinkLogRepository;

class TinkLogController extends Controller
{
    protected $repository;

    public function __construct(TinkLogRepository $tinkLogRepository)
    {
        $this->repository = $tinkLogRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->repository->dataTable($request);
        }
        return view('manage.admin.tinkLog.index');
    }
}
