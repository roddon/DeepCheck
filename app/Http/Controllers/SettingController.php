<?php

namespace App\Http\Controllers;

use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends AppController
{

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    public function edit()
    {
        return $this->setting->edit();
    }


    public function getInstitutions()
    {
        return $this->setting->getInstitutions();
    }

    public function createPaymentConsentToken(Request $request)
    {
        return $this->setting->createPaymentConsentToken($request);
    }

    public function makePayment(Request $request)
    {
        return $this->setting->makePayment($request);
    }
}
