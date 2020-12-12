<?php

namespace App\Services;

use DataTables;
use App\Models\UserSubscription;
use Spatie\QueryBuilder\QueryBuilder;

class StripeLogService extends BaseService
{
    public function __construct(UserSubscription $userSubscription)
    {
        $this->model = $userSubscription;
    }

    /**
     * DataTable Query
     * return json
     */
    public function dataTable()
    {
        $query = QueryBuilder::for($this->newQuery())
            ->defaultSort('-id');

        return DataTables::of($query)            
            ->editColumn('name', function (UserSubscription $userSubscription) {
                return optional($userSubscription->user)->name;
            })
            ->editColumn('subscriptionPlan', function (UserSubscription $userSubscription) {
                return optional($userSubscription->subscriptionPlan)->name;
            })            
            ->editColumn('startDate', function (UserSubscription $userSubscription){
                return $userSubscription->start_date;
            })
            ->editColumn('endDate', function (UserSubscription $userSubscription) {
                return $userSubscription->end_date;
            })
            ->editColumn('price', function (UserSubscription $userSubscription) {
                return $userSubscription->paid_price;
            })
            ->editColumn('status', function (UserSubscription $userSubscription) {
                return $userSubscription->is_active ? 'Active' : 'Inactive';
            })
            ->setRowClass(function ($userSubscription) {
                if ($userSubscription->is_active) {
                    return 'bar_color_1';
                }
            })
            ->addIndexColumn()
            ->toJson();
    }
}