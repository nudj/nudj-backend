<?php namespace App\Utility;

use App\Utility\Contracts\SocialInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use League\Flysystem\Exception;

class LinkedInHelper implements SocialInterface
{

    const API_URL = 'https://api.linkedin.com/v1';

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
        return $this->request('/people/~:(id,first-name,last-name,email-address)');
        //return $this->request('/people/~:(id,first-name,last-name,email-address,skills,picture-url)');
    }

    private function request($query = null)
    {
        $params = http_build_query([
            'oauth2_access_token' => $this->userToken,
            'format' => $this->format,
        ]);

        $url = self::API_URL . $query . '?' . $params;

        try {
            $request = $this->client->get($url);
        } catch (Exception $e) {
            throw new ApiException(ApiExceptionType::$LINKEDIN_ERROR, $e->getMessage());
        }

        switch ($this->format) {
            case 'json' :
                return $request->json(['object' => true]);
            case 'xml' :
                return $request->xml();
            default :
                return $request;
        }

    }

}