<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlanCheck extends Model
{
    protected $table = 'user_subscription_checks';

    protected $guarded = [];

    /**
     * @return HasOne|UserPlanCheck
     */
    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
