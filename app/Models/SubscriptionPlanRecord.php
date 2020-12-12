<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanRecord extends Model
{
    protected $table = "subscription_plan_records";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}
