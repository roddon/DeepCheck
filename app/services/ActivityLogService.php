<?php

namespace App\Services;

use DataTables;
use App\Models\ActivityLog;
use Auth;
use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;

class ActivityLogService extends BaseService
{
    public function __construct(ActivityLog $activityLog)
    {
        $this->model = $activityLog;
    }


    public function createLog($data)
    {
        return $this->model->create($data);
    }

    public function getDashboardLog($limit = 5)
    {
        return $this->model->limit($limit)->where('user_id', Auth::user()->id)->latest()->get();
    }

    public function dataTables()
    {
        $query = QueryBuilder::for($this->newQuery()
            ->where('model_type', 'App\Models\Customer'))
            ->defaultSort('-id');
        if (\Auth::user()->hasRole(User::ADMIN) == false) {
            $this->model->where('is_read', 0)->update(['is_read' => 1]);
            $query->where('user_id', \Auth::user()->id);
        }

        return DataTables::of($query)
            ->editColumn('name', function (ActivityLog $activityLog) {
                return optional($activityLog->model)->name ? optional($activityLog->model)->name : optional($activityLog->model)->company_name;
            })
            ->editColumn('log', function (ActivityLog $activityLog) {
                return $activityLog->log;
            })
            ->editColumn('dateTime', function (ActivityLog $activityLog) {
                return $activityLog->created_at;
            })
            ->addIndexColumn()
            ->toJson();
    }
}
