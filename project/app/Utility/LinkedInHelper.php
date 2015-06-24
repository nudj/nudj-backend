<?php namespace App\Utility;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class LinkedInHelper
{

    const API_URL = 'http://api.linkedin.com/v1';

    private $client;
    private $appId;
    private $appSecret;
    private $userToken;

    private $format = 'json';

    public function __construct($token)
    {
        $this->userToken = $token;

        $this->client = new Client();

        $this->appId = Config::get('cfg.linkedin_app_id');
        $this->appSecret = Config::get('cfg.linkedin_app_secret');

    }

    public function getUser()
    {
        return (object) json_decode($this->request('/people/~:(id,first-name,last-name,skills)'));
    }

    private function request($query = null)
    {

        $params = http_build_query([
            'oauth2_access_token' => $this->userToken,
            'format' => $this->format,
        ]);

        $request = self::API_URL . $query . '?' . $params;

        $response = $this->client->get($request);

        return $response;
    }

}