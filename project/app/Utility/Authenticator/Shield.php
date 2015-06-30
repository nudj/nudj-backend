<?php namespace App\Utility\Authenticator;

use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Authenticator\Contracts\ApiAuthenticable;
use App\Utility\Authenticator\Contracts\ShieldAuthServiceContract;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;


class Shield implements ApiAuthenticable
{

    private $driverTypes = ['session', 'header'];

    private $defaultDriverType = 'header';


    /*
     * User Repository used for authentication
     *
     * @var ShieldAuthServiceContract
     */
    protected $auth;

    /*
    * A token used to identify the user
    *
    * @property string $token
    */
    protected $token;

    /*
     * TheUser's id in the system
     *
     * @property int $userId
     */
    protected $userId;

    /*
     * A list of user roles
     *
     * @property array $userRoles
     */
    protected $userRoles;


    public function __construct($authService)
    {

        if (!($authService instanceof ShieldAuthServiceContract))
            throw new \InvalidArgumentException ();

        $this->auth = $authService;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function hasRole($role)
    {
        if (!$this->userRoles)
            return false;

        return (bool) in_array($role, $this->userRoles);
    }

    public function validate($driverType = null)
    {
        if(!$driverType)
            $driverType = $this->defaultDriverType;

        if(!in_array($driverType, $this->driverTypes))
            throw new \InvalidArgumentException();

        switch($driverType) {
            case 'session' :
                $this->token = Session::get('token');
                break;
            case 'header' :
                $this->token = Request::header('token');
                break;
            default:
                $this->token = null;
        }

        if (!$this->token)
            throw new ApiException(ApiExceptionType::$NO_TOKEN);

        $user = $this->auth->findByToken($this->token);

        if (!$user)
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);


        if(!isset($user->id))
            throw new \UnexpectedValueException();

        $this->userId = $user->id;
        $this->userRoles = json_decode($user->roles);

        return true;
    }

    public function createSession($token)
    {
       Session::put('token', $token);
    }







}