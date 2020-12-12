<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EmailLogRepository;

class EmailLogController extends Controller
{
    protected $emailLogRepository;
    
    public function __construct(EmailLogRepository $emailLogRepository)
    {
        $this->emailLogRepository = $emailLogRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->emailLogRepository->dataTables($request);
        }
        return view('manage.email.index');
    }

    public function read(Request $request)
    {
        return $this->emailLogRepository->read($request);
    }
}
