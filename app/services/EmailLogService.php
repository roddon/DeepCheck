<?php

namespace App\Services;

use DataTables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\EmailLog;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\EmailLogResource;

class EmailLogService extends BaseService
{
    public function __construct(EmailLog $emailLog)
    {
        $this->model = $emailLog;
    }

    public function dataTables()
    {
        $this->model->where('is_read', 0)->update(['is_read' => 1]);
        $query = QueryBuilder::for($this->newQuery())
            ->defaultSort('-id');
        if (\Auth::user()->hasRole(User::ADMIN) == false) {
            $this->model->where('is_read', 0)->update(['is_read' => 1]);
            $query->where('user_id', \Auth::user()->id);
        }

        return DataTables::of($query)            
            ->editColumn('from', function (EmailLog $emailLog) {
                return $emailLog->from;
            })
            ->editColumn('to', function (EmailLog $emailLog) {
                return $emailLog->to;
            })            
            ->editColumn('subject', function (EmailLog $emailLog){
                return $emailLog->subject;
            })
            ->editColumn('emailBody', function (EmailLog $emailLog) {
                return \Str::limit($emailLog->body, 20);
            })
            ->editColumn('read', function (EmailLog $emailLog) {
                return $emailLog->is_read ? 'Read' : 'Unread';
            })
            ->editColumn('action', function (EmailLog $emailLog) {
                return '<a class="viewEmail" href="##" data-id="'.$emailLog->id.'">View</a>';
            })
            ->escapeColumns(['emailBody', 'action'])
            // ->rawColumns(['action', 'body'])
            ->addIndexColumn()
            ->toJson();
    }

    public function read($request)
    {
        $emailLog = $this->find($request->id);
        EmailLogResource::withoutWrapping();
        return new EmailLogResource($emailLog);
    }
}