<?php

namespace App\Services;

use DatePeriod;
use DateInterval;
use \Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\Cashflow;
use Carbon\CarbonPeriod;
use App\Models\Syncinovice;
use App\Models\SyncreportPl;
use App\Models\CockpitInvoice;
use App\Models\CockpitCustomer;
use App\Models\SyncFraudAnalysis;
use Psr\Http\Message\ResponseInterface;
use App\Http\Resources\AccountingCheckResource;
use App\Models\Customer;

class DetectorService extends BaseService
{
    private $crossBgColor = 'greenbg';
    private $zScoreDecision = 'No Anomaly Detected';
    private $nonManipulator = 'Non Manipulator';
    private $noFraudDetected = 'No Fraud Detected';
    private $noOutliersOrAnomalyDetected = 'No Outliers/Anomaly Detected';

    public function accountingCheck()
    {
        $physicalDate = '2020-04-18';
        $userId = \Auth::user()->id;

        $userCompany = $this->getCompany($userId);

        $frennsId = $userCompany->cust_no;
        $frnId = $userCompany->cust_no;
        $companyNo = $userCompany->cust_no;

        $accountingSync = $userCompany->accounting_sync;

        // $userCustomer = $this->getCustomer($userId);

        $fromDate = Carbon::parse($physicalDate)->startOfMonth()->format('Y-m-d');
        $toDate = Carbon::now()->startOfMonth()->format('Y-m-d');

        $currentYear = Carbon::now()->format('Y');
        $totalFindMonth = $this->totalFindMonth($fromDate, $toDate);

        $revenue = $this->calculateRevenue($currentYear, $totalFindMonth);
        $profitOrLoss = $this->profitOrLoss($currentYear, $totalFindMonth);
        $noOfRecords = $this->noOfRecords($companyNo);
        $noOfSalesInvoice = $this->noOfSalesInvoice($companyNo);
        $noOfSuppliersInvoice = $this->noOfSuppliersInvoice($companyNo);
        $countWeekendInvoice = $this->countWeekendInvoice($companyNo);
        $monthWiseCashFlow = $this->monthWiseCashFlow($currentYear, $companyNo);
        $monthWiseRevenue = $this->monthWiseRevenue($currentYear, $companyNo);
        $monthWiseProfitOrLoss = $this->monthWiseProfitOrLoss($currentYear);

        $zScore = $this->zScore($frennsId);
        $devianceInvoices = $this->devianceInvoices($frennsId, $frnId);

        $zScoreBgColor = $this->zScoreBgColor($zScore);

        $devianceInvoiceBgColor = $this->devianceInvoiceBgColor($devianceInvoices);

        $this->warningBg($countWeekendInvoice, $zScore, $devianceInvoices);

        return [
            'revenue' => $revenue,
            'profitOrLoss' => $profitOrLoss,
            'noOfRecords' => $noOfRecords,
            'noOfSalesInvoice' => $noOfSalesInvoice,
            'noOfSuppliersInvoice' => $noOfSuppliersInvoice,
            'countWeekendInvoice' => $countWeekendInvoice,
            'monthWiseCashFlow' => $monthWiseCashFlow,
            'monthWiseRevenue' => $monthWiseRevenue,
            'monthWiseProfitOrLoss' => $monthWiseProfitOrLoss,
            'zScore' => optional($zScore)->value ? $zScore->value : 0,
            'devianceInvoice' => 'Invoice Anomaly',
            'crossBgColorClass' => $this->crossBgColor,
            'zScoreBgColor' => $zScoreBgColor,
            'devianceInvoiceBgColor' => $devianceInvoiceBgColor,
            'accountingSync' => $accountingSync
        ];
    }

    public function getCustomer($userId)
    {
        return Customer::where('user_id', $userId)->pluck('id')->toArray();
    }

    public function getCompany($userId)
    {
        return Company::where('user_id', $userId)->first();
    }


    public function getCrossBgColorStatus()
    {
        return $this->crossBgColor  == 'redbg' ? 1 : 0;
    }

    public function calculateRevenue($currentYear, $months)
    {

        return Cashflow::whereIn('month', $months)->where('year', $currentYear)->sum('revenue');
    }

    public function profitOrLoss($currentYear, $months)
    {
        return Cashflow::whereIn('month', $months)->where('year', $currentYear)->sum('profit_loss');
    }

    public function totalFindMonth($fromDate, $toDate)
    {

        $period = CarbonPeriod::create($fromDate, '1 month', $toDate);
        $months = [];
        foreach ($period as $dt) {
            $months[] = $dt->format('M');
        }
        return $months;
    }

    public function noOfRecords($companyNo)
    {
        $countSyncInvoice = Syncinovice::where('cust_no', $companyNo)->count('syncinvoice_id');
        $countSyncReportPl = SyncreportPl::where('cust_no', $companyNo)->count('syncreport_pl_id');
        return $countSyncInvoice + $countSyncReportPl;
    }

    public function noOfSalesInvoice($companyNo)
    {
        return Syncinovice::where('type', 'ACCREC')->where('cust_no', $companyNo)->count('syncinvoice_id');
    }

    public function noOfSuppliersInvoice($companyNo)
    {
        return Syncinovice::where('type', 'ACCPAY')->where('cust_no', $companyNo)->count('syncinvoice_id');
    }

    public function countWeekendInvoice($companyNo)
    {
        return Syncinovice::where('cust_no', $companyNo)->where(function ($query){
            return $query->whereRaw('WEEKDAY(issue_date) = 5')
                ->orWhereRaw('WEEKDAY(issue_date) = 6');
        })->count();
    }

    public function monthWiseCashFlow($currentYear, $companyNo)
    {
        return Cashflow::select(\DB::raw('MONTHNAME(STR_TO_DATE(month, "%m")) as label, sum(cashflow) as value'))->groupBy('month')->where('cust_no', $companyNo)->where('year', $currentYear)->orderBy(\DB::raw("FIELD(month, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)"))->get()->toJson();
    }

    public function monthWiseRevenue($currentYear, $companyNo)
    {
        $months = Cashflow::select(\DB::raw('MONTHNAME(STR_TO_DATE(month, "%m")) as label'))->groupBy('month')->where('cust_no', $companyNo)->where('year', $currentYear)->orderBy(\DB::raw("FIELD(month, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)"))->get()->toJson();
        $revenue = Cashflow::select(\DB::raw('sum(revenue) as value'))->groupBy('month')->where('cust_no', $companyNo)->where('year', $currentYear)->orderBy(\DB::raw("FIELD(month, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)"))->get()->toJson();

        return [
            'months' => $months,
            'revenue' => $revenue
        ];
    }

    public function monthWiseProfitOrLoss($currentYear)
    {
        $months = Cashflow::select(\DB::raw('MONTHNAME(STR_TO_DATE(month, "%m")) as label'))->groupBy('month')->where('year', $currentYear)->orderBy(\DB::raw("FIELD(month, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)"))->get()->toJson();
        $profitOrLoss = Cashflow::select(\DB::raw('sum(profit_loss) as value'))->groupBy('month')->where('year', $currentYear)->orderBy(\DB::raw("FIELD(month, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)"))->get()->toJson();

        return [
            'months' => $months,
            'profitOrLoss' => $profitOrLoss
        ];
    }

    public function zScore($frennsId)
    {
        return SyncFraudAnalysis::where(
            [
                'cust_no' => $frennsId,
                'area' => 'Z Score'
            ]
        )->first();
    }

    public function devianceInvoices($frennsId, $frnId)
    {
        $data['beneishScore'] = SyncFraudAnalysis::where(
            [
                'cust_no' => $frennsId,
                'area' => 'Beneish-M Score'
            ]
        )->first();

        $data['blackScholes'] = SyncFraudAnalysis::where(
            [
                'cust_no' => $frennsId,
                'area' => 'Black_Scholes'
            ]
        )->first();

        $data['mlp'] = CockpitCustomer::where(
            [
                'cust_no' => $frnId,
                'variable_analysis' => 'MLP'
            ]
        )->first();

        $data['autoencoderResult'] = CockpitInvoice::where(
            [
                'cust_no' => $frnId,
                'variable_analysis' => 'Autoencoder Result'
            ]
        )->first();

        return $data;
    }

    public function warningBg($countWeekendInvoice, $zScore, $devianceInvoices)
    {
        if (
            $countWeekendInvoice > 2
            || $zScore && $zScore->decision != $this->zScoreDecision
            || $devianceInvoices['beneishScore'] && optional($devianceInvoices['beneishScore'])->decision != $this->nonManipulator
            || $devianceInvoices['blackScholes'] && optional($devianceInvoices['blackScholes'])->decision != $this->noFraudDetected
            || $devianceInvoices['mlp'] && optional($devianceInvoices['mlp'])->decision != $this->noOutliersOrAnomalyDetected
            || $devianceInvoices['autoencoderResult'] && optional($devianceInvoices['autoencoderResult'])->decision != 0
        ) {
            $this->crossBgColor = 'redbg';
        }
    }

    public function zScoreBgColor($zScore)
    {
        $bg = 'greenbg';
        if ($zScore && $zScore->decision != $this->zScoreDecision) {
            $bg = 'redbg';
        }
        return $bg;
    }

    public function devianceInvoiceBgColor($devianceInvoices)
    {
        $bgColor = 'greenbg';
        if (
            $devianceInvoices['beneishScore'] && optional($devianceInvoices['beneishScore'])->decision != $this->nonManipulator
            || $devianceInvoices['blackScholes'] && optional($devianceInvoices['blackScholes'])->decision != $this->noFraudDetected
            || $devianceInvoices['mlp'] && optional($devianceInvoices['mlp'])->decision != $this->noOutliersOrAnomalyDetected
            || $devianceInvoices['autoencoderResult'] && optional($devianceInvoices['autoencoderResult'])->decision != 0
        ) {
            $bgColor = 'redbg';
        }

        return $bgColor;
    }

    public function accountingSync($request)
    {
        try {
            $isAccointingSync = $request->isAccountingSync == 'true'  ? 1 : 0;

            $userId = \Auth::user()->id;

            Company::where('user_id', $userId)->update(
                [
                    'accounting_sync' => $isAccointingSync
                ]
            );
            return response()->json(['message' => 'Accounting sync updated'], 200);
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json(['message' => 'Something went wrong'], 422);
        }
        
    }
}
