<?php

namespace App\Models\Presenters;

use App\Models\Media;
use Laracasts\Presenter\Presenter;

class MediaPresenter extends Presenter
{
    public function status(): string
    {
        return Media::STATUS[$this->entity->review_status];
    }

    public function statusColor(): string
    {
        return Media::STATUS_COLOUR[$this->entity->review_status];
    }
}