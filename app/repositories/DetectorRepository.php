<?php

namespace App\Repositories;

use App\Services\DetectorService;
use App\Services\UserService;

class DetectorRepository extends BaseRepository
{
    protected $detectorService;
    protected $userService;

    public function __construct(DetectorService $detectorService, UserService $userService)
    {
        $this->detectorService = $detectorService;
        $this->userService = $userService;
    }

    public function accountingCheck()
    {
        $user = \Auth::user();
        // $stageId = config('config.mautic.stages.detector');
        $segmentId = config('config.mautic.segment.detector');
        $contactParam['firstname'] = $user->name;
        $contactParam['email'] = $user->email;
        $contactParam['ipAddress'] = request()->ip();
        $contactParam['lastActive'] = date('Y-m-d H:m:i');
        $contactParam['overwriteWithBlank'] = true;
        
        $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);
        
        return $this->detectorService->accountingCheck();
    }

    public function accountingSync($request)
    {
        return $this->detectorService->accountingSync($request);
    }

    public function checkAccountingForMautic($request)
    {
        $user = \Auth::user();
        // $stageId = config('config.mautic.stages.detector-check-accounting');
        $segmentId = config('config.mautic.segment.detector-check-accounting');
        $contactParam['firstname'] = $user->name;
        $contactParam['email'] = $user->email;
        $contactParam['ipAddress'] = request()->ip();
        $contactParam['lastActive'] = date('Y-m-d H:m:i');
        $contactParam['overwriteWithBlank'] = true;
        
        $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);
        return response()->json(['message' => 'Mautic updated details'], 200);
    }
}