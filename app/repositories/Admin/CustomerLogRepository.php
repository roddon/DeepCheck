<?php

namespace App\Repositories\Admin;

use Exception;
use App\Services\CustomerService;
use App\Repositories\BaseRepository;

class CustomerLogRepository extends BaseRepository
{
    protected $service;

    public function __construct(CustomerService $customerService)
    {
        $this->service = $customerService;
    }

    public function datatable()
    {
        return $this->service->customerLog();
    }
}