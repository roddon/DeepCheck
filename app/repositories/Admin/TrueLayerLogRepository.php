<?php

namespace App\Repositories\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Services\TrueLayerPaymentService;

class TrueLayerLogRepository extends BaseRepository
{
    protected $service;

    public function __construct(TrueLayerPaymentService $trueLayerPaymentService)
    {
        $this->service = $trueLayerPaymentService;
    }

    public function datatable()
    {
        return $this->service->datatable();
    }
}