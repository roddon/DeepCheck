<?php

namespace App\Helpers;


use GuzzleHttp\Client;

class Firebase
{
    public $apiKey = '';

    public function __construct()
    {
        $this->apiKey = env('FIREBASE_API_KEY',"AIzaSyCY00t93feq0cn8D8LK4OdLMFtAXo1WXq0");
    }


    public function verifyOtp($code, $sessionInfo)
    {
        $client = new Client(['verify' => false]);

        $body['sessionInfo'] = $sessionInfo;
        $body['code'] = $code;


        $res = $client->request('POST', 'https://www.googleapis.com/identitytoolkit/v3/relyingparty/verifyPhoneNumber?key='.$this->apiKey, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            "json" => $body,
        ]);

        return json_decode($res->getBody()->getContents());
    }
}
