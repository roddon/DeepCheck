<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ActivityLogRepository;

class ActivityLogController extends Controller
{
    protected $repository;

    public function __construct(ActivityLogRepository $activityLogRepository)
    {
        $this->repository = $activityLogRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->repository->dataTables($request);
        }
        return view('manage.activityLog.index');
    }
}
