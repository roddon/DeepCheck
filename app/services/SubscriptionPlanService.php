<?php

namespace App\Services;

use DataTables;
use App\Models\SubscriptionPlan;
use Spatie\QueryBuilder\QueryBuilder;

class SubscriptionPlanService extends BaseService
{
    public function __construct(SubscriptionPlan $subscriptionPlan)
    {
        if(isset($this->subforCorrects)){
            $subscriptionForcorrect= $this->doSubsciptionPlansForCorrect(Request $request);
            $this->model= $subscriptionForcorrect;
        }
        else {
            $isforSubplan= $subscriptionPlan;
        }

        $this->model = $isforSubplan;
    }

    /**
     * DataTable Query
     * return json
     */
    public function doSubsciptionPlansForCorrect(Request $request){
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'trial_days' => $request->trial_days,
                'trial_days_doc_numbers' => $request->trial_days_doc_numbers,
                'include_check_invoice' => $request->include_check_invoice ? 1 : 0,
                'include_supplier_check' => $request->include_supplier_check ? 1 : 0,
                'include_safe_payout' => $request->include_safe_payout ? 1 : 0,
                'include_detector_records' => $request->include_detector_records ? 1 : 0,
                'include_onboarding' => $request->include_onboarding ? 1 : 0,
                'bg_color' => $request->bg_color
            ];
            $updatedSubPlan =  $this->service->updateById($id, $data);
            
            SubscriptionPlanRecord::where('subscription_plan_id', $id)->delete();

            foreach ($request->planRecords as $record) {
                SubscriptionPlanRecord::create(
                    [
                        'no_of_records_count' => $record['no_of_records_count'],
                        'price' => $record['price'],
                        'subscription_plan_id' => $id
                    ]
                );
            }
            return $updatedSubPlan;

        } catch (\Exception $e) {
            \Log::error(
                'SubscriptionPlanRepository::update' . PHP_EOL .
                    'Error :' . $e->getMessage() . PHP_EOL .
                    'Line :' . $e->getLine() . PHP_EOL
            );
            return $e;
        }
    }
    public function dataTable()
    {
        $query = QueryBuilder::for($this->newQuery())->defaultSort('-id')
            ->get();

        return DataTables::of($query)
            ->editColumn('name', function (SubscriptionPlan $subscriptionPlan) {
                return $subscriptionPlan->name;
            })
            ->editColumn('description', function (SubscriptionPlan $subscriptionPlan) {
                return $subscriptionPlan->description;
            })
            ->editColumn('trial_days', function (SubscriptionPlan $subscriptionPlan) {
                return $subscriptionPlan->trial_days;
            })
            ->editColumn('trial_days_doc_numbers', function (SubscriptionPlan $subscriptionPlan) {
                return $subscriptionPlan->trial_days_doc_numbers;
            })
            ->editColumn('include_check_invoice', function (SubscriptionPlan $subscriptionPlan) {
                return $subscriptionPlan->include_check_invoice ? 'Yes': 'No';
            })
            ->editColumn('include_supplier_check', function (SubscriptionPlan $subscriptionPlan) {
                return $subscriptionPlan->include_supplier_check ? 'Yes' : 'No';
            })
            ->editColumn('include_safe_payout', function (SubscriptionPlan $subscriptionPlan) {
                return $subscriptionPlan->include_safe_payout ? 'Yes' : 'No';
            })
            ->editColumn('include_detector_records', function (SubscriptionPlan $subscriptionPlan) {
                return $subscriptionPlan->include_detector_records ? 'Yes' : 'No';
            })
            ->editColumn('include_onboarding', function (SubscriptionPlan $subscriptionPlan) {
                return $subscriptionPlan->include_onboarding ? 'Yes' : 'No';
            })
            ->addIndexColumn()
            ->addColumn('action', 'manage.admin.subscription_plans.action')
            //->make(true)
            ->toJson();
    }
}
