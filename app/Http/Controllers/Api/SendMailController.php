<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    public function sendMail(Request $request)
    {
        return $this->setting->sendMail($request);
    }
}
