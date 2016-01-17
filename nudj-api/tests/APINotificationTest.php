<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APINotificationTest extends TestCase {

	/*
		Testing Notification related API calls
	 */

	public function test1()
	{
		$uri = 'api/v1/notifications';
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
				"data": [],
				"pagination": {
					"total": 0,
					"count": 0,
					"next": false,
					"previous": false
				},
				"timestamp": 1453045239.755
			}
		*/
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('pagination', $xp1);
		$this->assertArrayHasKey('total', $xp1["pagination"]);
		$this->assertArrayHasKey('count', $xp1["pagination"]);
		$this->assertArrayHasKey('next', $xp1["pagination"]);
		$this->assertArrayHasKey('previous', $xp1["pagination"]);
	}

	public function test2()
	{
		$uri = 'api/v1/notifications/205/read';
		$method = 'PUT';
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
				"status": true,
				"timestamp": 1453045759.4289
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);
	}

}
