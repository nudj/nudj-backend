<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APISkillsTest extends TestCase {

	/*
		Testing Skills related API calls
	 */

	public function test1()
	{
		$uri = 'api/v1/skills/suggest/php';
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
				"data": ["PHP"],
				"timestamp": 1453048240.8579
			}
		*/
		$this->assertArrayHasKey('data', $xp1);
	}

}
