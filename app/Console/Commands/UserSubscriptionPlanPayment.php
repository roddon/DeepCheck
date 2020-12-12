<?php

namespace App\Console\Commands;

use App\Models\SubscriptionPlanRecord;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserPlanCheck;
use Stripe\StripeClient;
use Illuminate\Console\Command;
use App\Models\UserSubscription;
use Stripe\Charge;
use Stripe\Stripe;

class UserSubscriptionPlanPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-subscription-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will create auto payment if user had selected auto top up';

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
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));

        $users = User::whereHas('userSubscription', function($userSub){
            return$userSub->where('automatic_top_up', 1)
                ->whereDate('end_date', '=', Carbon::now()->format("Y-m-d"));
        })->get();

        foreach ($users as $user) {
            $userSub = $user->userSubscription;
            $planRecordIds = $userSub->pluck('subscription_plan_record_id')->toArray();
            $userSubIds = $userSub->pluck('id')->toArray();

            $subPlanRecords = SubscriptionPlanRecord::whereIn('id', $planRecordIds)->get();
            $totalPrice = $subPlanRecords->sum('price');
            $stripeId = $user->stripe_id;

            // retrive payment method for customer
            $paymentMethod = $stripeClient->paymentMethods->all([
                'customer' => $stripeId,
                'type' => 'card',
            ]);

            $paymentMethodId = $paymentMethod->data[0]->id;
            
            $stripeCharge = $user->charge($totalPrice * 100, $paymentMethodId, [
                'customer' => $stripeId
            ]);

            $userSubData = [];
            $i = 0;
            foreach ($userSub as $usub) {
                $userSubData[$i]['user_id'] = $user->id;
                $userSubData[$i]['subscription_id'] = $usub->subscription_id;
                $userSubData[$i]['start_date'] = Carbon::now()->format("Y-m-d");
                $userSubData[$i]['end_date'] = Carbon::now()->addDays(30)->format("Y-m-d");
                $userSubData[$i]['next_due_date'] = Carbon::now()->addDays(30)->format("Y-m-d");
                $userSubData[$i]['automatic_top_up'] = 1;
                $userSubData[$i]['deleted_account'] = 0;
                $userSubData[$i]['is_active'] = 1;
                $userSubData[$i]['paid_price'] = $usub->paid_price;
                $userSubData[$i]['subscription_plan_record_id'] = $usub->subscription_plan_record_id;
                $i++;
            }
            UserSubscription::whereIn('id', $userSubIds)->update(['is_active' => 0]);
            UserSubscription::insert($userSubData);

            $userPlanCheck = UserPlanCheck::where('user_id', $user->id)->first();

            $noOfCheckInvoice = 0;
            $noOfSupplierCheck = 0;
            $noOfSafePayout = 0;
            $noOfDetectorRecords = 0;
            $noOfOnboarding = 0;

            foreach ($subPlanRecords as $planRecord) {
                if ($planRecord->subscriptionPlan->include_check_invoice) {
                    $noOfCheckInvoice += $planRecord->no_of_records_count;
                }

                if ($planRecord->subscriptionPlan->include_supplier_check) {
                    $noOfSupplierCheck += $planRecord->no_of_records_count;
                }

                if ($planRecord->subscriptionPlan->include_safe_payout) {
                    $noOfSafePayout += $planRecord->no_of_records_count;
                }

                if ($planRecord->subscriptionPlan->include_detector_records) {
                    $noOfDetectorRecords += $planRecord->no_of_records_count;
                }

                if ($planRecord->subscriptionPlan->include_onboarding) {
                    $noOfOnboarding += $planRecord->no_of_records_count;
                }
            }

            $userPlanCheck->no_of_check_invoice = $noOfCheckInvoice;
            $userPlanCheck->no_of_supplier_check = $noOfSupplierCheck;
            $userPlanCheck->no_of_safe_payout = $noOfSafePayout;
            $userPlanCheck->no_of_detector_records = $noOfDetectorRecords;
            $userPlanCheck->no_of_onboarding = $noOfOnboarding;
            $userPlanCheck->save();            
        }
    }
}