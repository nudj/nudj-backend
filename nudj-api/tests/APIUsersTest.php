<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APIUsersTest extends TestCase {

	/*
		Testing Users related API calls
	 */
	public function test1()
	{

		// Testing retrieving the list of users.

		$uri = 'api/v1/users';
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
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			{
				"data": [{
					"id": "1",
					"name": "Lachezar Todorov"
				}, {
					"id": "2",
					"name": "Lacho"
				}, {
					"id": "3",
					"name": "Lachezar Todorov"
				}, {
					"id": "4",
					"name": "Antonio Tester"
				}, {
					"id": "5",
					"name": "Eugene Kouumdjieff"
				}, {
					"id": "6",
					"name": "Eleanor H"
				}, {
					"id": "7",
					"name": "Nicolas Leclercq"
				}, {
					"id": "8",
					"name": "Robyn "
				}, {
					"id": "9",
					"name": "Imriel Morgan"
				}, {
					"id": "10",
					"name": "Imriel Morgan"
				}],
				"pagination": {
					"total": 196,
					"count": 10,
					"next": "/api/v1/users/?page=2",
					"previous": false
				},
				"timestamp": 1452451244.759
			}
		*/
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('id', $xp1['data'][0]);
		$this->assertArrayHasKey('name', $xp1['data'][0]);
		$this->assertArrayHasKey('pagination', $xp1);
	}
	public function test2()
	{

		// Testing retriving a user by its identifier.

		$uri = 'api/v1/users/1';
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
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			{
				"data": {
					"id": "1",
					"name": "Lachezar Todorov"
				},
				"timestamp": 1452451924.4747
			}
		*/
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('id', $xp1['data']);
		$this->assertArrayHasKey('name', $xp1['data']);
	}
	public function test3()
	{

		// Testing login/registering a user.

		$uri = 'api/v1/users';
		$method = 'POST';
		$parameters = [
			"phone" => "+447920549291",
			"country_code" => "GB"
		];
		$cookies = [];
		$files = [];
		$server = [];
		$content = null;
		$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
		$request->headers->set('token','JD7duPsAC1qgea4UD4otZpBG2wLKBxFIIhz32zFk1RdwWR4bsiCjeFwofWSz');
		$response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);

		$this->assertEquals(200, $response->getStatusCode());
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			{
				"status": true,
				"timestamp": 1452975331.1362
			}
		*/
		$this->assertArrayHasKey('status', $xp1);

	}

	public function test4()
	{

		// Testing resetting the name of a user.

		$newname = md5(microtime());

		$uri = 'api/v1/users/me';
		$method = 'PUT';
		$parameters = [
			"name" => $newname
		];
		$cookies = [];
		$files = [];
		$server = [];
		$content = null;
		$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
		$request->headers->set('token','JD7duPsAC1qgea4UD4otZpBG2wLKBxFIIhz32zFk1RdwWR4bsiCjeFwofWSz');
		$response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);

		$this->assertEquals(200, $response->getStatusCode());
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			{
				"status": true,
				"timestamp": 1452975331.1362
			}
		*/
		$this->assertArrayHasKey('status', $xp1);

		// TODO: could expand by retrieving the user and compare the names

	}

	public function test5()
	{
		// Testing deleting a user.
		// Left empty for the moment.
	}

	public function test6()
	{

		// Testing pin verification process.

		$uri = 'api/v1/users/verify';
		$method = 'PUT';
		$parameters = [
			"phone" => "07920549291",
			"country_code" => "GB",
			"verification" => "6803",
		];
		$cookies = [];
		$files = [];
		$server = [];
		$content = null;
		$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
		$request->headers->set('token','JD7duPsAC1qgea4UD4otZpBG2wLKBxFIIhz32zFk1RdwWR4bsiCjeFwofWSz');
		$response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);

		$this->assertEquals(200, $response->getStatusCode());
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			{
				"status": true,
				"data": {
					"id": 212,
					"token": "6IeDFXIW6ZZeeiah2Ovk6m2jMb8fiqjb7cQmPEIR7cW7PAzFhtdBtIKFCan6",
					"completed": true
				},
				"timestamp": 1453028923.5545
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertArrayHasKey('id', $xp1['data']);
		$this->assertArrayHasKey('token', $xp1['data']);
		$this->assertArrayHasKey('completed', $xp1['data']);
		$this->assertTrue($xp1['data']['completed']);

	}

	public function test7()
	{

		// Testing users/2/favourites.

		$uri = 'api/v1/users/2/favourites';
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
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			{
				"data": [],
				"pagination": {
					"total": 0,
					"count": 0,
					"next": false,
					"previous": false
				},
				"timestamp": 1452711012.072
			}
		*/
		$this->assertArrayHasKey('total', $xp1['pagination']);
		$this->assertArrayHasKey('count', $xp1['pagination']);
		$this->assertArrayHasKey('next', $xp1['pagination']);
		$this->assertArrayHasKey('previous', $xp1['pagination']);

	}

	public function test8()
	{

		// Testing users/exists/{userid}.

		$uri = 'api/v1/users/exists/1';
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
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			{
				"status": true,
				"timestamp": 1452710537.5602
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);

	}

}
