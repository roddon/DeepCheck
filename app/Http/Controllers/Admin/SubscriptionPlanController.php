<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionPlanRequest;
use App\Models\SubscriptionPlanRecord;
use App\Repositories\SubscriptionPlanRepository;

class SubscriptionPlanController extends Controller
{
    protected $repository;
    /**
     * __construct
     *
     * @param  mixed $subscriptionPlanRepository
     * @return void
     */
    public function __construct(SubscriptionPlanRepository $subscriptionPlanRepository)
    {

        try {
            $this->middleware('auth');

            $this->repository = $subscriptionPlanRepository;
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
            return redirect('/')
                ->with('error', __("common.something_went_wrong"));
        }
    }

    /**
     * Return index page
     * @param App\Http\Requests\SubscriptionPlanRequest $request
     * @return view
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->repository->dataTable($request);
        }
        return view('manage.admin.subscription_plans.index');
    }

    /**
     * Return create subscription plan
     * @return view
     */
    public function create()
    {
        try {
            return view('manage.admin.subscription_plans.create');
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
            return back()
                ->with('error', __("common.something_went_wrong"));
        }
    }

    /**
     * Return edit subdcription plan
     * @param  int $id
     * @return view
     */
    public function edit($id)
    {
        try {
            $subscription = $this->repository->edit($id);
            if ($subscription) {
                $planRecords = SubscriptionPlanRecord::where('subscription_plan_id', $id)->get();
                return view('manage.admin.subscription_plans.edit', compact('subscription', 'planRecords'));
            }
            return redirect()->route('admin.subscription_plan.index')
                ->with('error', __("common.something_went_wrong"));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back()
                ->with('error', __("common.something_went_wrong"));
        }
    }


    /**
     * Store subscription
     *
     * @param  mixed $request
     * @return mixed
     */
    public function store(SubscriptionPlanRequest $request)
    {
        try {
            $response = $this->repository->store($request);
            if ($response) {
                return redirect()->route('admin.subscription_plans.index')->with('message', __('subscription_plan.success.save'));
            }
            return redirect()->back()->withInput()->with('error', __('subscription_plan.error.save'));
        } catch (\Exception $e) {

            \Log::error(
                'SubscriptionPlanController::store' . PHP_EOL .
                    'Error :' . $e->getMessage() . PHP_EOL .
                    'Line :' . $e->getLine() . PHP_EOL
            );
            return back()
                ->withInput()
                ->with('error', __("common.something_went_wrong"));
        }
    }

    /**
     * Update subscription
     *
     * @param  int $id
     * @param  mixed $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        try {
            $response =  $this->repository->update($id, $request);
            if ($response) {
                return Redirect()->route('admin.subscription_plans.index')->with('success', __('subscription.success.update'));
            }
            return redirect()->back()->withInput()->with('error', __('subscription_plan.error.update'));
        } catch (\Exception $e) {
            \Log::error(
                'SubscriptionPlanController::update' . PHP_EOL .
                    'Error :' . $e->getMessage() . PHP_EOL .
                    'Line :' . $e->getLine() . PHP_EOL
            );
            return back()
                ->withInput()
                ->with('error', __("common.something_went_wrong"));
        }
    }
}
