<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laracasts\Presenter\PresentableTrait;
use App\Models\Presenters\MediaPresenter;

class Media extends BaseModel
{
    use PresentableTrait;

    protected $presenter = MediaPresenter::class;

    public $table = 'media';
    protected $guarded = [];

    const AWAITING_REVIEW = 0;
    const APPROVED_CHANGE = 1;
    const REJECTED_CHANGE = 2;
    
    const STATUS = [
        SELF::AWAITING_REVIEW => 'Awaiting review',
        SELF::APPROVED_CHANGE => 'Approved change',
        SELF::REJECTED_CHANGE => 'Rejected change',
    ];

    const STATUS_COLOUR = [
        self::AWAITING_REVIEW => 'blck',
        self::APPROVED_CHANGE => 'success',
        self::REJECTED_CHANGE => 'failed'
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function mediaTraining()
    {
        return $this->hasMany(MediaTraining::class, 'media_id');
    }
}
