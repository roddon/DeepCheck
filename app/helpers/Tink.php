<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class Tink
{

    private $clientId = '';
    private $clientSecret = '';
    private $appUrl = "";
    private $apiUrl = "";
    private $scope = "";


    public function __construct()
    {
        $this->clientId = env('TINK_CLIENT_ID');
        $this->clientSecret = env('TINK_CLIENT_SECRET');
        $this->appUrl = env('TINK_APP_URL');
        $this->apiUrl = env('TINK_API_URL');
        $this->scope = env('TINK_API_SCOPE');
    }


    public function verificationLink()
    {
        return  $this->appUrl;
    }


    public function authenticateToken($code)
    {
        $client = new Client();

        $res = $client->request('POST', $this->apiUrl . '/oauth/token', [
            'form_params' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'authorization_code',
                'code' => $code,
                'scope' => $this->scope
            ]
        ]);

        return json_decode($res->getBody()->getContents());
    }


    public function getAccountList($accessToken)
    {
        $client = new Client();

        $res = $client->request('GET', $this->apiUrl . '/accounts/list', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        return json_decode($res->getBody()->getContents());
    }


    public function getIdentities($accessToken)
    {
        $client = new Client();

        $res = $client->request('GET', $this->apiUrl . '/identities', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        return json_decode($res->getBody()->getContents());
    }


    public function getUserProfile($accessToken)
    {
        $client = new Client();

        $res = $client->request('GET', $this->apiUrl . '/user/profile', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        return json_decode($res->getBody()->getContents());
    }
}
