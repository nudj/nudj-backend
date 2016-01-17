<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APINudgeTest extends TestCase {

	/*
		Testing Nudge related API calls
	 */
	public function test1()
	{
		$uri = 'api/v1/nudge';
		$method = 'PUT';
		$parameters = [
			"job"      => 1,
			"contacts" => [204,204],
			"message"  => "message-x"
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
			See documentation: d29d44fd-96ad-41ba-b28a-5417a80697cb
			{
				"status": true,
				"timestamp": 1453039053.6592
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);
	}

	public function test2()
	{
		$uri = 'api/v1/nudge/ask';
		$method = 'PUT';
		$parameters = [
			"job"      => 1,
			"contacts" => [204,204],
			"message"  => "message-x"
		];
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
			See documentation: d29d44fd-96ad-41ba-b28a-5417a80697cb
			{
				"error": {
					"message": "This job does not belong to the user",
					"code": 14402
				},
				"timestamp": 1453039940.7315
			}
		*/
		$this->assertArrayHasKey('error', $xp1);
		$this->assertArrayHasKey("message", $xp1['error']);
		$this->assertArrayHasKey("code", $xp1['error']);
	}

	public function test3()
	{
		$uri = 'api/v1/nudge/ask';
		$method = 'PUT';
		$parameters = [
			"job"      => 105,
			"contacts" => [204,204],
			"message"  => "message-x"
		];
		$cookies = [];
		$files = [];
		$server = [];
		$content = null;
		$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
		$request->headers->set('token','9TFjx52eZEgVSv3PZsja3iyBBw3XwsWH1XHI4T0iUIvCbQ2WqJS98S3f2HGE');
		$response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);

		$this->assertEquals(200, $response->getStatusCode());
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			See documentation: d29d44fd-96ad-41ba-b28a-5417a80697cb
			{
				"status": true,
				"timestamp": 1453040424.4323
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);
	}

}
