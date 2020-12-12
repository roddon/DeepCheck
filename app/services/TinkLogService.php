<?php

namespace App\Services;

use DataTables;
use App\Models\TinkAccount;
use Spatie\QueryBuilder\QueryBuilder;

class TinkLogService extends BaseService
{
    public function __construct(TinkAccount $tinkAccount)
    {
        $this->model = $tinkAccount;
    }

    public function datatable()
    {
        $query = QueryBuilder::for($this->newQuery()->orderBy('updated_at', 'desc'));

        return DataTables::of($query)
            ->editColumn('model_name', function (TinkAccount $tinkAccount) {
                return optional($tinkAccount->model)->name;
            })
            ->editColumn('account_number', function (TinkAccount $tinkAccount) {
                return $tinkAccount->account_number;
            })
            ->editColumn('available_credit', function (TinkAccount $tinkAccount) {
                return $tinkAccount->available_credit;
            })
            ->editColumn('balance', function (TinkAccount $tinkAccount) {
                return $tinkAccount->balance;
            })
            ->editColumn('holder_name', function (TinkAccount $tinkAccount) {
                return $tinkAccount->holder_name;
            })
            ->editColumn('currency_code', function (TinkAccount $tinkAccount) {
                return $tinkAccount->currency_code;
            })
            ->editColumn('name', function (TinkAccount $tinkAccount) {
                return $tinkAccount->name;
            })
            ->editColumn('updated_at', function (TinkAccount $tinkAccount) {
                return $tinkAccount->updated_at;
            })
            ->addIndexColumn()
            ->toJson();
    }
}
