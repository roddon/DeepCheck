<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class TrueLayer
{
    protected $clientId = '';
    protected $clientSecret = '';
    protected $appUrl = '';
    protected $apiUrl = '';
    protected $redirectUrl = '';
    protected $paymentApiUrl = '';
    protected $client = '';

    public function __construct()
    {
        $this->clientId = env('TRUE_LAYER_CLIENT_ID');
        $this->clientSecret = env('TRUE_LAYER_CLIENT_SECRET');
        $this->appUrl = env('TRUE_LAYER_APP_URL');
        $this->authApiUrl = env('TRUE_LAYER_AUTH_URL');
        $this->redirectUrl = env('TRUE_LAYER_REDIRECT_PAGE');
        $this->paymentApiUrl = env('TRUE_LAYER_PAYMENT_API_URL');
    }

    public function getUrl()
    {
        return $this->appUrl;
    }


    public function getToken($code, $scope = '')
    {
        $client = new Client(['verify' => false]);

        $res = $client->request('POST', $this->authApiUrl . '/connect/token', [

            'form_params' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
                'code' => $code,
                'redirect_uri' => $this->redirectUrl,
                'scope' => 'payments'
            ]
        ]);

        return json_decode($res->getBody()->getContents());
    }


    public function getPaymentToken()
    {
        $client = new Client(['verify' => false]);

        $res = $client->request('POST', $this->authApiUrl . '/connect/token', [

            'form_params' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
                'redirect_uri' => $this->redirectUrl,
                'scope' => 'payments'
            ]
        ]);

        return json_decode($res->getBody()->getContents());
    }


    public function singleImmidiatePayment($body)
    {

        $response = $this->getPaymentToken();
        if (isset($response->access_token) && $response->access_token) {

            $client = new Client(['verify' => false]);

            $body['redirect_uri'] = $this->redirectUrl;


            $res = $client->request('POST', $this->paymentApiUrl . '/single-immediate-payments', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $response->access_token
                ],
                "json" => $body,
            ]);

            return json_decode($res->getBody()->getContents());
        }
    }


    public function singleImmidiatePaymentStatus($paymentId)
    {

        $response = $this->getPaymentToken();
        if (isset($response->access_token) && $response->access_token) {

            $client = new Client(['verify' => false]);

            $body['redirect_uri'] = $this->redirectUrl;


            $res = $client->request('GET', $this->paymentApiUrl . '/single-immediate-payments/' . $paymentId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $response->access_token
                ],
            ]);

            return json_decode($res->getBody()->getContents());
        }
    }
}
