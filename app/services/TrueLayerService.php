<?php

namespace App\Services;

use App\Models\TrueLayer;

class TrueLayerService extends BaseService
{
    public function __construct(TrueLayer $trueLayer)
    {
        $this->model = $trueLayer;
    }


    public function getAuthToken()
    {
        $trueLayer = \Auth::user()->trueLayer;

        if ($trueLayer) {
            return $trueLayer->access_token;
        }

        return false;
    }
}
