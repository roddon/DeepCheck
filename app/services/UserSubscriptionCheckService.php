<?php

namespace App\Services;

use DataTables;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\SubscriptionPlan;
use App\Models\UserPlanCheck;

class UserSubscriptionCheckService extends BaseService
{
    public function __construct(UserPlanCheck $userSubscriptionCheck)
    {
        $this->model = $userSubscriptionCheck;
    }

    public function datatable()
    {
        $query = QueryBuilder::for($this->newQuery())
            ->defaultSort('-id');

        return DataTables::of($query)            
            ->editColumn('name', function (UserPlanCheck $userPlanCheck) {
                return optional($userPlanCheck->user)->name;
            })
            ->editColumn('subscriptionPlan', function (UserPlanCheck $userPlanCheck) {
                $planIds = explode(',', $userPlanCheck->user_subscription_ids);
                return SubscriptionPlan::whereIn('id', $planIds)->pluck('name')->implode(',');
            })            
            ->editColumn('no_of_check_invoice', function (UserPlanCheck $userPlanCheck){
                return $userPlanCheck->no_of_check_invoice;
            })
            ->editColumn('no_of_supplier_check', function (UserPlanCheck $userPlanCheck) {
                return $userPlanCheck->no_of_supplier_check;
            })
            ->editColumn('no_of_safe_payout', function (UserPlanCheck $userPlanCheck) {
                return $userPlanCheck->no_of_safe_payout;
            })
            ->editColumn('no_of_detector_records', function (UserPlanCheck $userPlanCheck) {
                return $userPlanCheck->no_of_detector_records;
            })
            ->editColumn('no_of_onboarding', function (UserPlanCheck $userPlanCheck) {
                return $userPlanCheck->no_of_onboarding;
            })
            ->addIndexColumn()
            ->toJson();
    }
}
