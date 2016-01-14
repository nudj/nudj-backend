### Part 1
Just in case you've been looking for it the function call (used to make HTTP calls) is defined here:
 
vendor / laravel / framework / src / Illuminate / Foundation / Testing / ApplicationTrait.php

Signature:

```
	/**
	 * Call the given URI and return the Response.
	 *
	 * @param  string  $method
	 * @param  string  $uri
	 * @param  array   $parameters
	 * @param  array   $cookies
	 * @param  array   $files
	 * @param  array   $server
	 * @param  string  $content
	 * @return \Illuminate\Http\Response
	 */
	public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
```

### Part 2

To call a secure route (https), use $this->callSecure().


### Part 3

Note, the standard way to make HTTP requests in Laravel

```
$this->call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
```

doesn't support setting of HTTP headers. The solution is to build a HTTP request manually and do

```				
$request->headers->set($key,$value)
```

to set them. Example:

```
$uri = 'api/v1/jobs/search/Casting+instructor';
$method = 'GET';
$parameters = [];
$cookies = [];
$files = [];
$content = null;
$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
$request->headers->set('token','JD7duPsAC1qgea4UD4otZpBG2wLKBxFIIhz32zFk1RdwWR4bsiCjeFwofWSz');
```

Then we can ask laravel to digest this request and give us the answer

```
$response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);
```