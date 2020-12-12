<?php

namespace App\Repositories\Admin;

use Exception;
use App\Services\StripeLogService;
use App\Repositories\BaseRepository;
use App\Services\UserSubscriptionCheckService;

class StripeLogRepository extends BaseRepository
{
    protected $service;

    public function __construct(StripeLogService $stripeLogService, UserSubscriptionCheckService $userSubscriptionCheckService)
    {
        $this->service = $stripeLogService;
        $this->userSubscriptionCheckService = $userSubscriptionCheckService;
    }

    public function datatable()
    {
        return $this->service->datatable();
    }

    public function counterLog()
    {
        return $this->userSubscriptionCheckService->datatable();
    }
}