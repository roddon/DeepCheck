<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use App\Models\Traits\Encryptable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Presenters\UserPresenter;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasRoles, Notifiable, Encryptable, PresentableTrait, HasApiTokens, Billable;

    protected $guarded = [];

    protected $presenter = UserPresenter::class;

    const ADMIN = 'admin';
    const MEMBER = 'member';

    const ACTIVE = true;
    const INACTIVE = false;

    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive',
    ];

    const STATUS_COLOR = [
        self::ACTIVE => 'success',
        self::INACTIVE => 'failed',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $encryptable = [
        // 'name', 'email', 'password', 'contact_numner', 'username', 'sftp_un', 'sftp_pw', 'sftp_server_ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @return HasMany|UserLoginLog
     */
    public function userLoginLogs()
    {
        return $this->hasMany(UserLoginLog::class);
    }


    /**
     * @return HasOne|Company
     */
    public function company()
    {
        return $this->hasOne(Company::class);
    }


    /**
     * @return HasMany|Company
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * @return HasMany|Supplier
     */
    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }


    /**
     * @return HasMany|Invoice
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * @return HasOne|TrueLayer
     */
    public function trueLayer()
    {
        return $this->hasOne(TrueLayer::class);
    }


    /**
     * @return HasOne|TrueLayerPayment
     */
    public function trueLayerPayment()
    {
        return $this->hasMany(TrueLayerPayment::class);
    }

    public function userSubscription()
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * @return HasOne|UserPlanCheck
     */
    public function subscriptionPlanCheck()
    {
        return $this->hasOne(UserPlanCheck::class)->latest();
    }


    public function subscriptionCheck(User $user, $check)
    {
        $counter = 0;

        if ($user->subscriptionPlanCheck) {
            $expiry = $user->userSubscription()->where('id',$user->subscriptionPlanCheck->user_subscription_ids)->first();
            if(!empty($expiry)){
                if($expiry->end_date >= date('Y-m-d')){
                    switch ($check) {
                        case config('config.subscription.invoice_check'):
                            $counter = $user->subscriptionPlanCheck->no_of_check_invoice;
                            break;
                        case config('config.subscription.onboarding'):
                            $counter = $user->subscriptionPlanCheck->no_of_onboarding;
                            break;

                        case config('config.subscription.supplier_verification'):
                            $counter = $user->subscriptionPlanCheck->no_of_supplier_check;
                            break;

                        case config('config.subscription.safepay'):
                            $counter = $user->subscriptionPlanCheck->no_of_safe_payout;
                            break;

                        case config('config.subscription.detector_records'):
                            $counter = $user->subscriptionPlanCheck->no_of_detector_records;
                            break;
                    }
                }
            }
        }

        return $counter;
    }

    public function useSubscription(User $user, $counter, $check)
    {
        $subscriptionCheck = $user->subscriptionPlanCheck;
        if ($subscriptionCheck) {

            switch ($check) {
                case config('config.subscription.invoice_check'):
                    $subscriptionCheck->no_of_check_invoice = $subscriptionCheck->no_of_check_invoice - $counter;
                    break;
                case config('config.subscription.onboarding'):
                    $subscriptionCheck->no_of_onboarding = $subscriptionCheck->no_of_onboarding - $counter;
                    break;

                case config('config.subscription.supplier_verification'):
                    $subscriptionCheck->no_of_supplier_check = $subscriptionCheck->no_of_supplier_check - $counter;
                    break;

                case config('config.subscription.safepay'):
                    $subscriptionCheck->no_of_safe_payout = $subscriptionCheck->no_of_safe_payout - $counter;
                    break;

                case config('config.subscription.detector_records'):
                    $subscriptionCheck->no_of_detector_records = $subscriptionCheck->no_of_detector_records - $counter;
                    break;
            }

            $subscriptionCheck->save();
        }
    }

    public function assignDefaultSubscription($user){
        $subscription = SubscriptionPlan::where('slug','checkinvoice')->get()->first();
        $subscriptionDetector= SubscriptionPlan::where('slug','detector')->get()->first();
        $subscriptionSafepay= SubscriptionPlan::where('slug','safepay')->get()->first();
        $subscriptionOnboarding= SubscriptionPlan::where('slug','onboarding')->get()->first();
        // dd($subscription);
        if(!empty($subscription)){
            $endDate = date('Y-m-d');
            if($subscription->trial_days>1){
                $endDate = date('Y-m-d', strtotime(($subscription->trial_days-1).' days'));
            }
            $userSubscription = UserSubscription::create(['user_id'=>$user->id,
                                      'subscription_id'=>$subscription->id,
                                      'start_date'=>date('Y-m-d'),
                                      'end_date'=>$endDate,
                                      'next_due_date'=>$endDate,
                                      'created_at'=>date('Y-m-d h:i:s'),
                                      'updated_at'=>date('Y-m-d h:i:s'),
                                      'is_active'=>1]);
            if(!empty($userSubscription)){
                // $userSubscription = UserPlanCheck::create(['user_id'=>$user->id,
                //                       'user_subscription_ids'=>$userSubscription->id,
                //                       'no_of_onboarding'=>$subscription->include_onboarding,
                //                       'no_of_check_invoice'=>$subscription->trial_days_doc_numbers,
                //                       'no_of_supplier_check'=>$subscription->include_supplier_check,
                //                       'no_of_safe_payout'=>$subscription->include_safe_payout,
                //                       "no_of_detector_records"=>$subscription->include_detector_records,
                //                       'created_at'=>date('Y-m-d h:i:s'),
                //                       'updated_at'=>date('Y-m-d h:i:s')]);
                $userSubscription = UserPlanCheck::create(['user_id'=>$user->id,
                                      'user_subscription_ids'=>$userSubscription->id,
                                      'no_of_onboarding'=>$subscriptionOnboarding->trial_days_doc_numbers,
                                      'no_of_check_invoice'=>$subscription->trial_days_doc_numbers,
                                      'no_of_supplier_check'=>$subscription->trial_days_doc_numbers,
                                      'no_of_safe_payout'=>$subscriptionSafepay->trial_days_doc_numbers,
                                      "no_of_detector_records"=>$subscriptionDetector->trial_days_doc_numbers,
                                      'created_at'=>date('Y-m-d h:i:s'),
                                      'updated_at'=>date('Y-m-d h:i:s')]);
            }
        }
    }
}
