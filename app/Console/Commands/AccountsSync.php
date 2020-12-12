<?php

namespace App\Console\Commands;

use App\Jobs\AccountingSync;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;


class AccountsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounts-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto account sync process';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::whereHas('company', function ($query) {
            return $query->where('accounting_sync', 1);
        })->get();

        $syncJobLists = \DB::table('sync_jobs_list')->where('table_name', 'synchronize_jobs')->get();
        $currentDate = Carbon::now()->subDays(7);
        foreach ($users as $user) {
            $subscriptionPlanCheck = $user->subscriptionPlanCheck;

            foreach ($syncJobLists as $job) {
                if ($subscriptionPlanCheck && $subscriptionPlanCheck->no_of_detector_records) {
                    $syncronizedJob = \DB::table('synchronize_jobs')
                        ->where('accounting_system', $job->jobname)
                        ->where('cust_no', optional($user->company)->account_number)
                        ->latest()->first();

                    $jobFlag = false;
                    if (!$syncronizedJob) {
                        $jobFlag = true;
                    } else {
                        if ($currentDate->gte(Carbon::parse($syncronizedJob->created_at))) {
                            $jobFlag = true;
                        }
                    }

                    if ($jobFlag) {
                        AccountingSync::dispatch($job->file_path, $user);
                    }
                }
            }
        }
    }
}
