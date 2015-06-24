<?php namespace App\Utility;


use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;
use Facebook\GraphUser;
use Illuminate\Support\Facades\Config;

class FacebookHelper
{

    private $appId;
    private $appSecret;
    private $userToken;

    public function __construct($token)
    {
        $this->appId = Config::get('cfg.facebook_app_id');
        $this->appSecret = Config::get('cfg.facebook_app_secret');

        $this->userToken = $token;
    }

    public function getUser()
    {
        return (object) $this->request('/me');
    }

    private function request($query = null, $type = 'GET')
    {

        if (!$query)
            return false;

        FacebookSession::setDefaultApplication($this->appId, $this->appSecret);

        $session = new FacebookSession($this->userToken);

        try {
            $result = (new FacebookRequest($session, $type, $query))
                ->execute()
                ->getGraphObject(GraphUser::className())
                ->asArray();

        } catch (FacebookRequestException $e) {
            throw new ApiException(ApiExceptionType::$FACEBOOK_ERROR, $e->getMessage());
        } catch (\Exception $e) {
            throw new ApiException(ApiExceptionType::$FACEBOOK_ERROR, $e->getMessage());
        }

        return $result;
    }

}