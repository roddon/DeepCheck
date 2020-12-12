<?php

namespace App\Models;


use App\Models\User;
use App\Models\Invoice;
use App\Models\Currency;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    const COMPANY_IMAGE = 'company_image';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::COMPANY_IMAGE)
            ->singleFile();
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
