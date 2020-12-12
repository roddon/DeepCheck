<?php

namespace App\Models;

use App\Models\MediaTrainingItems;
use Illuminate\Database\Eloquent\Model;

class MediaInvoiceItems extends Model
{
    public $table = 'media_invoice_items';
    protected $guarded = [];

    public function mediaTrainingItems()
    {
        return $this->hasMany(MediaTrainingItems::class, 'media_invoice_items_id');
    }
}
