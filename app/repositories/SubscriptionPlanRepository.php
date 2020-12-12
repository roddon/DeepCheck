<?php

namespace App\Repositories;

use App\Models\SubscriptionPlanRecord;
use Illuminate\Http\Request;
use App\Services\SubscriptionPlanService;
use Exception;

class SubscriptionPlanRepository extends BaseRepository
{
    protected $service;

    public function __construct(SubscriptionPlanService $subscriptionPlanService)
    {
        $this->service = $subscriptionPlanService;
    }
    public function dataTable(Request $request)
    {
        return $this->service->dataTable();
    }

    /**
     * Edit Subscription Plan
     *
     * @param  mixed $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->service->find($id);
    }

    public function store(Request $request)
    {
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

            $subPlan = $this->service->create($data);
            foreach ($request->planRecords as $record) {
                SubscriptionPlanRecord::create(
                    [
                        'no_of_records_count' => $record['no_of_records_count'],
                        'price' => $record['price'],
                        'subscription_plan_id' => $subPlan->id
                    ]
                );
            }
            return $subPlan;
        } catch (\Exception $e) {
            \Log::error(
                'SubscriptionPlanRepository::store' . PHP_EOL .
                    'Error :' . $e->getMessage() . PHP_EOL .
                    'Line :' . $e->getLine() . PHP_EOL
            );
            throw new Exception($e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
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
}
