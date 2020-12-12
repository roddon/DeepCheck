<?php

namespace App\Helpers;

use GuzzleHttp\Client;


class Yapili
{
    protected $appUrl = '';
    protected $applicationUuid = '';
    protected $applicationSecret = '';
    protected $authorization = '';
    protected $applicationUserId = '';


    public function __construct()
    {
        $this->appUrl = env('YAPILI_APP_URL');
        $this->applicationUuid = env('YAPILI_APPLICATION_UUID');
        $this->applicationSecret = env('YAPILI_APPLICATION_SECRET');
        $this->authorization = 'Basic ' . base64_encode($this->applicationUuid . ':' . $this->applicationSecret);
        $this->client = new Client(['verify' => false]);
        $this->applicationUserId = env('YAPILI_APP_USER_ID');
    }


    public function institutions()
    {
        try {
            $res = $this->client->request('GET', $this->appUrl . '/institutions', [
                'headers' => [
                    'Authorization' =>  $this->authorization,
                    'Accept-Encoding' => ''
                ]
            ]);
            return json_decode($res->getBody()->getContents());
        } catch (\Exception $e) {
        }
    }

    public function accountAuthRequest($institutionId)
    {
        try {
            $body = [
                "applicationUserId" => $this->applicationUserId,
                "institutionId" => $institutionId,
                "callback" => url('callback')
            ];

            $res = $this->client->request('POST', $this->appUrl . '/account-auth-requests', [
                'headers' => [
                    'Authorization' =>  $this->authorization,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $body,
                'http_errors' => false,
            ]);

            return json_decode($res->getBody()->getContents());
        } catch (\Exception $e) {
        }
    }

    public function getAccounts($consentToken)
    {
        try {
            $res = $this->client->request('GET', $this->appUrl . '/accounts', [
                'headers' => [
                    'Authorization' =>  $this->authorization,
                    'Accept-Encoding' => '',
                    'Consent' => $consentToken
                ]
            ]);
            return json_decode($res->getBody()->getContents());
        } catch (\Exception $e) {
        }
    }

    public function getIdentities($consentToken)
    {
        try {
            $res = $this->client->request('GET', $this->appUrl . '/identity', [
                'headers' => [
                    'Authorization' =>  $this->authorization,
                    'Accept-Encoding' => '',
                    'Consent' => $consentToken
                ]
            ]);
            return json_decode($res->getBody()->getContents());
        } catch (\Exception $e) {
        }
    }



    public function paymentAuthRequest($paymentRequest, $institutionId)
    {
        try {
            $body = [
                "applicationUserId" => $this->applicationUserId,
                "institutionId" => $institutionId,
                "callback" => url('live-protect/payments/consent-callback'),
                "oneTimeToken" => "false",
                "paymentRequest" => $paymentRequest
            ];

            $res = $this->client->request('POST', $this->appUrl . '/payment-auth-requests', [
                'headers' => [
                    'Authorization' =>  $this->authorization,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $body
            ]);

            return json_decode($res->getBody()->getContents());
        } catch (\Exception $e) {
        }
    }


    public function makePayment($paymentRequest, $consentToken)
    {
        try {

            $res = $this->client->request('POST', $this->appUrl . '/payments', [
                'headers' => [
                    'Authorization' =>  $this->authorization,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Consent' => $consentToken
                ],
                'json' => $paymentRequest,
                'http_errors' => false,
            ]);
            return json_decode($res->getBody()->getContents());
        } catch (\Exception $e) {
        }
    }


    public function createBulkPaymentAuthentication($paymentRequest, $institutionId)
    {
        try {
            $body = [
                "applicationUserId" => $this->applicationUserId,
                "institutionId" => $institutionId,
                "callback" => url('live-protect/payments/consent-callback'),
                "oneTimeToken" => "false",
                "paymentRequest" => $paymentRequest
            ];

            $res = $this->client->request('POST', $this->appUrl . '/bulk-payment-auth-requests', [
                'headers' => [
                    'Authorization' =>  $this->authorization,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $body,
                'http_errors' => false,
            ]);

            return json_decode($res->getBody()->getContents());
        } catch (\Exception $e) {
        }
    }


    public function makeBulkPayment($paymentRequest, $consentToken)
    {
        try {

            $res = $this->client->request('POST', $this->appUrl . '/bulk-payments', [
                'headers' => [
                    'Authorization' =>  $this->authorization,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Consent' => $consentToken
                ],
                'json' => $paymentRequest,
                'http_errors' => false,
            ]);
            return json_decode($res->getBody()->getContents());
        } catch (\Exception $e) {
        }
    }
}
