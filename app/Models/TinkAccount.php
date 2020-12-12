<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TinkAccount extends Model
{
    protected $guarded = [];

    public function model()
    {
        return $this->morphTo();
    }
}
