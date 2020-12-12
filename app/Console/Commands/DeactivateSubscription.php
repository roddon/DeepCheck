<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\UserSubscription;
use App\Models\UserPlanCheck;

class DeactivateSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deactivate-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will deactivate user subscription';

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
        $userSubscription = UserSubscription::where('automatic_top_up', '!=', 1)
        ->whereDate('end_date', '=', Carbon::yesterday()->format("Y-m-d"))
        ->where('is_active', 1)
        ->get();
        $userIds = [];
        foreach ($userSubscription as $userSub) {
            $userSub->is_active = 0;
            $userSub->save();

            $userIds[] = $userSub->user_id;
        }

        if (count($userIds) > 0) {
            UserPlanCheck::whereIn('user_id', $userIds)->update(
                [
                    'no_of_onboarding' => 0,
                    'no_of_check_invoice' => 0,
                    'no_of_supplier_check' => 0,
                    'no_of_safe_payout' => 0,
                    'no_of_detector_records' => 0,
                ]
            );
        }
        
    }
}
