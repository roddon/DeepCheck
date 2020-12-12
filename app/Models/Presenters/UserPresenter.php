<?php

namespace App\Models\Presenters;


use App\Models\User;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function status(): string
    {
        return User::STATUS[$this->entity->status];
    }

    public function statusColor(): string
    {
        return User::STATUS_COLOR[$this->entity->status];
    }
}
