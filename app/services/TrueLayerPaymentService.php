<?php

namespace App\Services;

use DataTables;
use App\Models\TrueLayerPayment;
use Spatie\QueryBuilder\QueryBuilder;

class TrueLayerPaymentService extends BaseService
{
    public function __construct(TrueLayerPayment $trueLayerPayment)
    {
        $this->model = $trueLayerPayment;
    }


    public function datatable()
    {
        $query = QueryBuilder::for($this->newQuery()->orderBy('updated_at', 'desc'));

        return DataTables::of($query)
            ->editColumn('beneficiary_name', function (TrueLayerPayment $trueLayerPayment) {
                return !empty($trueLayerPayment->invoice->supplier)?$trueLayerPayment->invoice->supplier->name:'';
            })
            ->editColumn('beneficiary_reference', function (TrueLayerPayment $trueLayerPayment) {
                return $trueLayerPayment->payment_reference;
            })
            ->editColumn('beneficiary_sort_code', function (TrueLayerPayment $trueLayerPayment) {
                return !empty($trueLayerPayment->invoice->supplier)?$trueLayerPayment->invoice->supplier->sort_code:'';
            })
            ->editColumn('beneficiary_account_number', function (TrueLayerPayment $trueLayerPayment) {
                return !empty($trueLayerPayment->invoice->supplier)?$trueLayerPayment->invoice->supplier->bank_account_number:'';
            })
            ->editColumn('status', function (TrueLayerPayment $trueLayerPayment) {
                return $trueLayerPayment->status;
            })
            ->editColumn('updated_at', function (TrueLayerPayment $trueLayerPayment) {
                return $trueLayerPayment->updated_at;
            })
            ->addIndexColumn()
            ->toJson();
    }
}
