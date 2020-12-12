<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountingCheckResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'revenue' => 324465,
            'profitOrLost' => 324465,
            'noOfRecords' => 989,
            'noOfSalesInvoices' => 345,
            'noOfSupplierInvoices' => 265,
            'weekendInvioces' => 'none',
            'crossScore' => 0,
            'devianceInInvoices' => 'invoice anomaly'
        ];
    }
}
