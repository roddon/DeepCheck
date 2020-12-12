<?php

namespace App\Repositories;

use App\Services\ActivityLogService;

class ActivityLogRepository extends BaseRepository
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function dataTables()
    {
        return $this->activityLogService->dataTables();
    }
}