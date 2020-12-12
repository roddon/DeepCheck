<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\TrueLayerLogRepository;

class TrueLayerLogController extends Controller
{
    protected $repository;

    public function __construct(TrueLayerLogRepository $trueLayerLogRepository)
    {
        $this->repository = $trueLayerLogRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->repository->dataTable($request);
        }
        return view('manage.admin.trueLayerLog.index');
    }
}
