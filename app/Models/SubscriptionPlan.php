<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends BaseModel
{
    protected $guarded = ['id'];
    const CHECKINVOICE = '';
    const DETECTOR = 'silverBg';
    const SAFEPAY = 'yellwbg';
    const ONBOARDING = 'grd-gray';

    const PLAN_CHECKINVOICE = 1;
    const PLAN_DETECTOR = 2;
    const PLAN_SAFEPAY = 3;
    const PLAN_ONBOARDING = 4;
    const PLANS = [
        self::PLAN_CHECKINVOICE => "CheckInvoice",
        self::PLAN_DETECTOR => "Detector",
        self::PLAN_SAFEPAY => "Safepay",
        self::PLAN_ONBOARDING => "Onboarding",
    ];

    const ONE_MONTH_TRIAL_DAYS = 30;

    public function planRecords()
    {
        return $this->hasMany(SubscriptionPlanRecord::class);
    }

    public function purchasePlan()
    {
        return $this->hasMany(UserSubscription::class, 'subscription_id');
    }
}
