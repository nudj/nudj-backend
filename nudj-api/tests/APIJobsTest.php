<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APIJobsTest extends TestCase {

	/*
		Testing Jobs related API calls
	 */
	public function test1()
	{
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
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			See documentation: d29d44fd-96ad-41ba-b28a-5417a80697cb
			{
			    "data": [{
			        "id": "3",
			        "title": "Casting instructor ",
			        "user": {
			            "id": "3",
			            "name": "Lachezar Todorov"
			        }
			    }],
			    "count": 1,
			    "timestamp": 1452417473.1581
			}
		*/
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('id', $xp1['data'][0]);
		$this->assertArrayHasKey('title', $xp1['data'][0]);
		$this->assertArrayHasKey('user', $xp1['data'][0]);
	}
	public function test2()
	{
		$uri = 'api/v1/jobs/mine';
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
					"id": "109",
					"title": "Test",
					"user": {
						"id": "205",
						"name": "Robyn"
					}
				}],
				"pagination": {
					"total": 1,
					"count": 1,
					"next": false,
					"previous": false
				},
				"timestamp": 1452890348.1144
			}
		*/
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('id', $xp1['data'][0]);
		$this->assertArrayHasKey('title', $xp1['data'][0]);
		$this->assertArrayHasKey('user', $xp1['data'][0]);
	}
	public function test3()
	{
		$uri = 'api/v1/jobs/alice';
		$method = 'GET';
		$parameters = [];
		$cookies = [];
		$files = [];
		$server = [];
		$content = null;
		$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
		$request->headers->set('token','JD7duPsAC1qgea4UD4otZpBG2wLKBxFIIhz32zFk1RdwWR4bsiCjeFwofWSz');
		$response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);
		
		$this->assertEquals(400, $response->getStatusCode());
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			{
				"error": {
					"message": "Invalid Endpoint",
					"code": 10101
				},
				"timestamp": 1452891298.8923
			}
		*/
		$this->assertArrayHasKey('error', $xp1);
		$this->assertArrayHasKey('message', $xp1['error']);
		$this->assertArrayHasKey('code', $xp1['error']);
	}
	public function test4()
	{
		$uri = 'api/v1/jobs/1';
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
					"title": "Web Developer",
					"user": {
						"id": "2",
						"name": "Lacho"
					}
				},
				"timestamp": 1452710226.551
			}
		*/
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('id', $xp1['data']);
		$this->assertArrayHasKey('title', $xp1['data']);
		$this->assertArrayHasKey('user', $xp1['data']);
	}
	public function test5()
	{
		$uri = 'api/v1/jobs';
		$method = 'POST';
		$parameters = [
			"title"       => 'title-x',
			"description" => 'description-x',
			"bonus"       => 666,
			"salary"      => "£999",
			"skills"      => ["skill1","skill2"],
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
					"id": 127
				},
				"timestamp": 1452951012.2224
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('id', $xp1['data']);
	}
	public function test6()
	{
		$uri = 'api/v1/jobs/127';
		$method = 'PUT';
		$parameters = [
			"title"       => 'title-o',
			"description" => 'description-o',
			"bonus"       => 665,
			"salary"      => "£998",
			"skills"      => ["skill6","skill7"],
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
				"timestamp": 1452958734.212
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
	}
}
