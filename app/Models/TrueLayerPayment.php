<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrueLayerPayment extends Model
{
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoices_id', 'id');
    }
}
