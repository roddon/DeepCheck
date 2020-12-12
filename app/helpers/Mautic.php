<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Mautic\Auth\ApiAuth;
use Mautic\MauticApi;
use App\Models\MauticConsumer;
use GuzzleHttp\Exception\ClientException;
use App\Models\MauticSetting;

class Mautic
{
    protected $url = '';
    protected $redirectUrl = '';
    protected $basicAuth = '';
    protected $_auth;

    public function __construct()
    {
		//dd(env('MAUTIC_CLIENT'));
        $this->mauticClient = "13_2j4i5wd0accgk84o88ksw4s0kkokwwkook8kgs0ws888o0gk08";
        $this->mauticSecret = "5rd03l5ika4ow80k8408sosw4wk44cg8ks0c84oscgwck4kw0s";
        $this->mauticCode = "NWIyYzRlNmU3MDEwZjZkM2Q5ZDZhODJmZDRjMjc4OTU5NGE3Yzc5ODNkZjI1MzE2Y2U4MGQ2ODE5N2FmMWUzNA";
        //$this->basicAuth = "bmlzYXJnLmJoYXZzYXJAcmlzaGFiaHNvZnQuY29tOkl3ZHlyWGQ3Qmhvc200dQ==";
        $this->url = "https://mtc.safepay.to";
        $this->redirectUrl = "https://deepcheck.one";
		//$this->mauticClient = env('MAUTIC_CLIENT');
		//$this->mauticSecret = env('MAUTIC_SECRET');
     	//$this->mauticCode = env('MAUTIC_CODE');
		$this->basicAuth = 'Basic '.base64_encode('per@conqorde.com:Ernie1234!');
		//$this->url = env('MAUTIC_URL');
	    //$this->redirectUrl = env('MAUTIC_REDIRECT_URL');
    }

    protected function getMauticUrl($endpoints=null)
    {
        if(!empty($endpoints))
            return $this->url.'/api/'.$endpoints;
        else
            return $this->url.'/';

    }

    public function initiateAuth()
    {
        session_name("mauticOAuth");
        session_start();

        $settings = array(
            'baseUrl'      => $this->url,
            'version'      => 'OAuth2',
            'clientKey'    => $this->mauticClient,
            'clientSecret' => $this->mauticSecret,
            'callback'     => $this->redirectUrl
        );

        $initAuth = new ApiAuth();
        $auth = $initAuth->newAuth($settings);

        if ($auth->validateAccessToken())
        {
            if ($auth->accessTokenUpdated()) {
                $accessTokenData = $auth->getAccessTokenData();
				
                return MauticConsumer::create($accessTokenData);
            }
        }
    }

    public function request($method, $endpoint, $body=null)
    {
		
        $consumer = MauticConsumer::whereNotNull('id')->orderBy('updated_at', 'desc')->first();
        $expiryStatus = $this->checkExpirationTime($consumer->expires);

       if($expiryStatus == true){	 
			$newToken = $this->regenerateToken($consumer->refresh_token);
		    return $this->callMautic($method, $endpoint, $body, $newToken->access_token);
	   }
        return $this->callMautic($method, $endpoint, $body, $consumer->access_token);
        
    }

    public function callMautic($method, $endpoint, $body, $token)
    {
        $mauticURL = $this->getMauticUrl($endpoint);
        $params = array();
        if(!empty($body)){
            $params = array();
            foreach ($body as $key => $item){
                $params['form_params'][$key] = $item;
            }
        }
        $headers = array('headers' => ['Authorization' => 'Bearer '. $token], 'verify' => false);
        $client = new Client($headers);
        try {
            $response = $client->request($method, $mauticURL, $params);
            $responseBodyAsString = $response->getBody();

            return json_decode($responseBodyAsString,true);
        }
        catch (ClientException $e) {
            $exceptionResponse = $e->getResponse();
            return $statusCode = $exceptionResponse->getStatusCode();
        }
    }    

    public function checkExpirationTime($expireTimestamp)
    {
        $now = time();
        if($now > $expireTimestamp)
            return true;
        else
            return false;
    }

    public function authenticateToken()
    {
        $client = new Client(['verify' => false]);

        $res = $client->request('POST', $this->url . '/oauth/v2/token', [
            'form_params' => [
                'client_id' => $this->mauticClient,
                'client_secret' => $this->mauticSecret,
                'grant_type' => 'authorization_code',
                'code' => $this->mauticCode,
                'redirect_uri' => $this->redirectUrl
            ]
        ]);

        return json_decode($res->getBody()->getContents());
    }

    public function regenerateToken($refreshToken)
    {
 		$client = new Client(['verify' => false]);
		
        $res = $client->request('POST', $this->url . '/oauth/v2/token', [
            'form_params' => [
                'client_id' => $this->mauticClient,
                'client_secret' => $this->mauticSecret,
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
                'redirect_uri' => $this->redirectUrl
            ]
        ]);

        $responseData = json_decode($res->getBody()->getContents(), true);
       	
        return MauticConsumer::create(
            [
                'access_token' => $responseData['access_token'],
                'expires' => time() + $responseData['expires_in'],
                'token_type' => $responseData['token_type'],
                'refresh_token' => $responseData['refresh_token']
            ]
        );
    }   

    /****BasicAuthFor mautic****/

    public function authInit(){
        try{
            $settings = MauticSetting::fetchData();
            $initAuth = new ApiAuth();
            return $initAuth->newAuth($settings, 'BasicAuth');
        }catch(\Exception $e){

        }
    }
    public function initNewApi($apiType){
        try{
            if (!($this->_auth instanceof ApiAuth)) {
                $this->_auth = $this->authInit();
            }            
            $api = new MauticApi();
            return $api->newApi($apiType, $this->_auth, $this->url.'/api');
        }catch(\Exception $e){
        }
    }
    public function create($apiType,$aData){
        try{
            return $this->initNewApi($apiType)->create($aData);
        }catch(\Exception $e){
            //$this->log($e->getMessage());
        }
    }

    public function addStageSegmentContact($apiType,$cId,$sId){
        $response = $this->initNewApi($apiType)->addContact($sId,$cId);
    }
}