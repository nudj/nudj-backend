UUID: 52494eff-a413-4d03-b76c-08ceef2c5e77

# What happens during the API authentication


### Shield::validate();

Using the API requires a token that is used both for authentication (figuring out who is making the call) and authorization (establishing that the caller has the right of making the call). Using curl to make an API call is done with 

```
curl --header "token:JD7duPsAC1qgea4UD4otZpBG2wLKBxFIIhz32zFk1RdwWR4bsiCjeFwofWSz" \
    "http://localhost:8000/api/v1/jobs/mine"
```

The call is handled by the 

```
Route::group(['prefix' => 'api/v1'], function () {
    Route::get('jobs/{filter}', 'JobsController@index');
```

`JobsController` implements ApiController, whose first action is to `Shield::validate();`.

The Shield class can be found at 

```
app/Utility/Authentication/Shield.php
```

It which implements `ApiAuthenticable`, this latter contains `validate($driverType);`.

The entire code of validate at Shield is 

```
public function validate($driverType = null)
{
    if (!$driverType)
        $driverType = $this->defaultDriverType;

    if (!in_array($driverType, $this->driverTypes))
        throw new \InvalidArgumentException();

    switch ($driverType) {
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

    $this->user = $this->auth->findByToken($this->token);

    if (!$this->user)
        throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

    if (!isset($this->user->id))
        throw new \UnexpectedValueException();

    $this->userId = $this->user->id;
    $this->userRoles = json_decode($this->user->roles);

    return true;
}
```

This shows that the token can be taken from a request header or an existing session variable. Once the token as been found we get the user (if there is one) by 

```
$this->user = $this->auth->findByToken($this->token);
```

### Shield::getUserId();

The index function of JobsController starts with 

```
$me = Shield::getUserId();
```

If a user could not be identified we get 

```
{
	"error": {
		"message": "No valid token supplied",
		"code": 11101
	},
	"timestamp": 1452886124.1097
}
```

Otherwise "getUserId()" just calls the user identifer that was found during the validation. Note that "getUserId()" is a function of `interface ApiAuthenticable`.
