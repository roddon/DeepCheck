<?php

namespace App\Services;

use DB;
use App\Models\User;
use App\Models\Media;
use App\Models\Invoice;
use App\Models\Supplier;
use App\Models\SyncInvoice;
use App\Models\SubscriptionPlan;

class DashboardService extends BaseService
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }


    public function verifiedInvoiceCount(User $user, $date)
    {

        return $user->invoices()->whereDate('created_at', '>=', $date)
            ->whereIn('status', [Invoice::NO_RISK, Invoice::OK, Invoice::PAID, Invoice::NOT_PAID])
            ->count();
    }


    public function verifiedInvoiceDailyCount(User $user, $date)
    {

        return $user->invoices()->select([
            DB::raw('count(*) as value'),
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as label_date'),
            DB::raw('DATE_FORMAT(created_at, "%M %d") as label')
        ])
            ->whereIn('status', [Invoice::NO_RISK, Invoice::OK, Invoice::PAID, Invoice::NOT_PAID])
            ->whereDate('created_at', '>=', $date)
            ->groupBy('label_date')
            ->orderBy('label_date', 'ASC')
            ->get();
    }


    public function falseDocumentCount(User $user, $date)
    {
        $media = Media::where('analysis_status', 'FALSE')
            ->whereDate('created_at', '>=', $date)
            ->count();

        return $media;
    }


    public function falseDocumentDailyCount(User $user, $date)
    {
        return Media::select([
            DB::raw('count(*) as value'),
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as label_date'),
            DB::raw('DATE_FORMAT(created_at, "%M %d") as label')
        ])
            ->where('analysis_status', 'FALSE')
            ->whereDate('created_at', '>=', $date)
            ->groupBy('label_date')
            ->orderBy('label_date', 'ASC')
            ->get();
    }


    public function notVerifiedSupplierCount(User $user, $date)
    {
        return $user->suppliers()
            ->where('status', '!=', Supplier::APPROVED)
            ->whereDate('created_at', '>=', $date)
            ->count();
    }


    public function notVerifiedSupplierDailyCount(User $user, $date)
    {
        return $user->suppliers()
            ->select([
                DB::raw('count(*) as value'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as label_date'),
                DB::raw('DATE_FORMAT(created_at, "%M %d") as label')
            ])
            ->where('status', '!=', Supplier::APPROVED)
            ->whereDate('created_at', '>=', $date)
            ->groupBy('label_date')
            ->orderBy('label_date', 'ASC')
            ->get();
    }


    public function savingsCount(User $user, $date)
    {
        return Media::where('analysis_status', 'TRUE')
            ->join('invoices', 'invoices.id', '=', 'media.model_id')
            ->where('invoices.user_id', $user->id)
            ->where('model_type', 'App\Models\Invoice')
            ->whereDate('media.created_at', '>=', $date)
            ->count();
    }


    public function savingsDailyCount(User $user, $date)
    {
        return Media::select([
            DB::raw('count(*) as value'),
            DB::raw('DATE_FORMAT(media.created_at, "%Y-%m-%d") as label_date'),
            DB::raw('DATE_FORMAT(media.created_at, "%M %d") as label')
        ])
            ->join('invoices', 'invoices.id', '=', 'media.model_id')
            ->where('invoices.user_id', $user->id)
            ->where('analysis_status', 'TRUE')

            ->where('model_type', 'App\Models\Invoice')

            ->whereDate('media.created_at', '>=', $date)
            ->groupBy('label_date')
            ->orderBy('label_date', 'ASC')
            ->get();
    }


    public function detectorCount($companyNo)
    {
        return SyncInvoice::where('cust_no', $companyNo)->where('type', 'ACCPAY')->distinct('syncsupplier_id')->count();
    }

    public function checkUserPurchasedPlan($user)
    {
        $userPlan = $user->userSubscription ? $user->userSubscription->where('is_active', 1)->pluck('subscription_id')->toArray() : null;

        $checkPurchasePlan['includeInvoiceCheck'] = false;
        $checkPurchasePlan['includeSupplierCheck'] = false;
        $checkPurchasePlan['includeSafePayout'] = false;
        $checkPurchasePlan['includeDetector'] = false;
        $checkPurchasePlan['includeOnboarding'] = false;

        if ($userPlan) {
            $purchasePlan = SubscriptionPlan::whereIn('id', $userPlan)->get();
            foreach ($purchasePlan as $plan) {
                if ($plan->include_check_invoice) {
                    $checkPurchasePlan['includeInvoiceCheck'] = true;
                }
                if ($plan->include_supplier_check) {
                    $checkPurchasePlan['includeSupplierCheck'] = true;
                }
                if ($plan->include_safe_payout) {
                    $checkPurchasePlan['includeSafePayout'] = true;
                }
                if ($plan->include_detector_records) {
                    $checkPurchasePlan['includeDetector'] = true;
                }
                if ($plan->include_onboarding) {
                    $checkPurchasePlan['includeOnboarding'] = true;
                }
            }
        }

        return $checkPurchasePlan;
    }
}
