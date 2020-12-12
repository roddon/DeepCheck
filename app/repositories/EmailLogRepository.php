<?php

namespace App\Repositories;

use App\Services\EmailLogService;

class EmailLogRepository extends BaseRepository
{
    protected $emailLogService;

    public function __construct(EmailLogService $emailLogService)
    {
        $this->emailLogService = $emailLogService;
    }

    public function dataTables()
    {
        return $this->emailLogService->dataTables();
    }

    public function read($request)
    {
        return $this->emailLogService->read($request);
    }
}