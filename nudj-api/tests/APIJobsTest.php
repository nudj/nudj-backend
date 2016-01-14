<?php

class APIJobsTest extends TestCase {

	/*
		Testing Jobs related API calls
	 */
	public function testJobsControllerSearch()
	{

		/*
			Note, the standard way to make HTTP requests in Laravel

				$this->call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)

			doesn't support setting of HTTP headers. The solution is to build a HTTP request manually and do

				$request->headers->set

			to set them. 
		*/
	
		$uri = 'api/v1/jobs/search/Casting+instructor';
		$method = 'GET';
		$parameters = [];
		$cookies = [];
		$files = [];
		$server = [];
		$content = null;
		$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
		$request->headers->set('token','JD7duPsAC1qgea4UD4otZpBG2wLKBxFIIhz32zFk1RdwWR4bsiCjeFwofWSz');
		$response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);

		$this->assertEquals(200, $response->getStatusCode());

	}

}
