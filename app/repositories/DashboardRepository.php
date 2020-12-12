<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Media;
use App\Models\Supplier;
use App\Services\ActivityLogService;
use App\Services\DashboardService;
use App\Services\DetectorService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardRepository extends BaseRepository
{
    public function __construct(
        DashboardService $dashboardService,
        ActivityLogService $activityLogService,
        DetectorService $detectorService,
        UserService $userService

    ) {
        $this->dashboardService = $dashboardService;
        $this->activityLogService = $activityLogService;
        $this->detectorService = $detectorService;
        $this->userService = $userService;
    }


    public function dashboard()
    {
        $user = Auth::user();
        $last30Days = Carbon::now()->subDays(30)->format('Y-m-d');
        $currentDate = Carbon::now();

        $supplierMaxVerificationDate = $user->suppliers()->max('verification_date');
        $customerMaxVerificationDate = $user->customers()->max('verification_date');
        $invoiceMaxCreatedDate = $user->invoices()->max('created_at');
        $paymentMaxCreatedDate = $user->trueLayerPayment()->max('created_at');


        $maxDate = $paymentMaxCreatedDate && Carbon::parse($paymentMaxCreatedDate)->gt(Carbon::parse($invoiceMaxCreatedDate))
            ? $paymentMaxCreatedDate : $invoiceMaxCreatedDate;

        $maxDate = $customerMaxVerificationDate && Carbon::parse($customerMaxVerificationDate)->gt(Carbon::parse($maxDate))
            ? $customerMaxVerificationDate : $maxDate;

        $maxDate = $supplierMaxVerificationDate && Carbon::parse($supplierMaxVerificationDate)->gt(Carbon::parse($maxDate))
            ? $supplierMaxVerificationDate : $maxDate;


        $lastDetection = $currentDate->diffInDays(Carbon::parse($maxDate));



        // Invoices Count
        $invoiceCount = $this->dashboardService->verifiedInvoiceCount($user, $last30Days);

        // Invoices Daily Count
        $invoiceDailyCount = $this->dashboardService->verifiedInvoiceDailyCount($user, $last30Days)
            ->toJson();

        // false Document Count
        $falseDocumentsCount = $this->dashboardService->falseDocumentCount($user, $last30Days);

        // False document daily Count
        $falseDocumentDailyCount = $this->dashboardService
            ->falseDocumentDailyCount($user, $last30Days)->toJson();

        // Not Verified Supplier Count
        $notVerifiedSupplierCount = $this->dashboardService->notVerifiedSupplierCount($user, $last30Days);

        // Not Verified Supplier Daily Count
        $notVerifiedSupplierDailyCount = $this->dashboardService
            ->notVerifiedSupplierDailyCount($user, $last30Days)->toJson();

        // Savings Count
        $savingsCount = $this->dashboardService->savingsCount($user, $last30Days);

        // Savings Daily Count
        $savingsDailyCount = $this->dashboardService
            ->savingsDailyCount($user, $last30Days)->toJson();



        $totalInvoiceCount = $user->invoices()->whereDate('created_at', '>=', $last30Days)
            ->whereIn('status', [Invoice::ACCPAY, Invoice::ACCREC])
            ->count();

        // All Invoices created in last 30 days with all status
        $allInvoiceCount = $user->invoices()->whereDate('created_at', '>=', $last30Days)
            ->count();

        // All invoices with check text status
        $checktextInvoiceInvoicesCount = $user->invoices()
            ->whereStatus(Invoice::CHECK_TEXT)
            ->whereDate('created_at', '>=', $last30Days)
            ->count();

        // Paid Invoice count
        $paidInvoiceCount =
            $user->invoices()
            ->where('status', Invoice::PAID)
            ->whereDate('created_at', '>=', $last30Days)
            ->count();
        // Not Paid invoice count
        $notPaidInvoiceCount =
            $user->invoices()->where('status', Invoice::NOT_PAID)
            ->whereDate('created_at', '>=', $last30Days)
            ->count();

        // All suppliers created in last 30 days
        $supplierCount = $user->suppliers()
            ->whereDate('created_at', '>=', $last30Days)
            ->count();
        // Failed in verfication supplier count in last 30 days
        $failedVerificationSupplierCount = $user->suppliers()->whereStatus(Supplier::FAILED)
            ->whereDate('created_at', '>=', $last30Days)
            ->count();

        // Verified suppliers count in last 30 days
        $verifiedSupplierCount = $user->suppliers()->whereStatus(Supplier::APPROVED)
            ->whereDate('created_at', '>=', $last30Days)
            ->count();

        // Customer created in last 30 days
        $customerCount = $user->customers()
            ->whereDate('created_at', '>=', $last30Days)
            ->count();

        // Not verified customer count in last 30 days
        $notVerifiedCustomerCount = $user->customers()->where('status', '!=', Customer::APPROVED)
            ->whereDate('created_at', '>=', $last30Days)
            ->count();


        // Detector
        $frennsId = optional($user->company)->account_number;
        $frnId = optional($user->company)->account_number;
        $companyNo = optional($user->company)->account_number;
        $countWeekendInvoice = $this->detectorService->countWeekendInvoice($companyNo);

        $zScore = $this->detectorService->zScore($frennsId);
        $devianceInvoices = $this->detectorService->devianceInvoices($frennsId, $frnId);

        $this->detectorService->warningBg($countWeekendInvoice, $zScore, $devianceInvoices);
        $detectorStatus = $this->detectorService->getCrossBgColorStatus();
        $detectorCount = $this->dashboardService->detectorCount($companyNo);


        // Check Dashboard Health
        $dashboardStatus = 0;

        if (
            $failedVerificationSupplierCount ||
            $falseDocumentsCount ||
            $notVerifiedCustomerCount ||
            $notPaidInvoiceCount ||
            $detectorStatus
        ) {
            $dashboardStatus = 1;
        } elseif (
            $checktextInvoiceInvoicesCount ||
            $notVerifiedSupplierCount
        ) {
            $dashboardStatus = 2;
        }

        $checkUserPurchasedPlan = $this->dashboardService->checkUserPurchasedPlan($user);

        $activities = $this->activityLogService->getDashboardLog();

        // $stageId = config('config.mautic.stages.dashboard');
        $segmentId = config('config.mautic.segment.dashboard');
        $contactParam['firstname'] = $user->name;
        $contactParam['email'] = $user->email;
        $contactParam['ipAddress'] = request()->ip();
        $contactParam['lastActive'] = date('Y-m-d H:m:i');
        $contactParam['overwriteWithBlank'] = true;
        
        $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);

        return view('manage.dashboard.dashboard', compact(
            'invoiceCount',
            'invoiceDailyCount',

            'falseDocumentsCount',
            'falseDocumentDailyCount',

            'notVerifiedCustomerCount',
            'notVerifiedSupplierDailyCount',

            'savingsCount',
            'savingsDailyCount',

            'checktextInvoiceInvoicesCount',
            'allInvoiceCount',
            'totalInvoiceCount',
            'paidInvoiceCount',
            'notPaidInvoiceCount',

            'supplierCount',
            'customerCount',

            'failedVerificationSupplierCount',

            'verifiedSupplierCount',
            'notVerifiedSupplierCount',
            'activities',
            'dashboardStatus',
            'detectorStatus',
            'detectorCount',
            'lastDetection',
            'maxDate',
            'checkUserPurchasedPlan'
        ));
    }
}
