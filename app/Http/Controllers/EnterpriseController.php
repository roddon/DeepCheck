<?php

namespace App\Http\Controllers;

use App\Repositories\SettingRepository;
use App\Services\UserService;
use Illuminate\Http\Request;

class EnterpriseController extends AppController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $user = \Auth::user();
        // $stageId = null; config('config.mautic.stages.enterprise');
        $segmentId = config('config.mautic.segment.enterprise');
        $contactParam['firstname'] = $user->name;
        $contactParam['email'] = $user->email;
        $contactParam['ipaddress'] = request()->ip();
        $contactParam['last_active'] = date('Y-m-d H:m:i');
        
        $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);
        return view('manage.enterprise.index');
    }
}
