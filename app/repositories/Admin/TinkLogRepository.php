<?php

namespace App\Repositories\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\TinkLogService;
use App\Repositories\BaseRepository;
use App\Services\SubscriptionPlanService;

class TinkLogRepository extends BaseRepository
{
    protected $service;

    public function __construct(TinkLogService $tinkLogService)
    {
        $this->service = $tinkLogService;
    }

    public function datatable()
    {
        return $this->service->datatable();
    }
}