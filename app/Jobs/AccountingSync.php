<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AccountingSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $command;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($command, User $user)
    {
        $this->command = $command;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $accountNumber = $this->user->company->account_number;
            exec($this->command . ' '  . $accountNumber);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
