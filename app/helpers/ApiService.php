<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class ApiService
{

    protected $apiServer;

    public function __construct()
    {
       // $this->apiServer = env('API_SERVER');
		$this->apiServer = "http://144.76.137.232:2998/apiserver/v1/uk/";
    }


    public function companyNumberVerify($companyNumber)
    {
        $client = new Client();

        return $client->request(
            'GET',
            $this->apiServer . 'company_info?company_number=' . $companyNumber
        );
    }
}
