<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APICountriesTest extends TestCase {

	/*
		Testing Notification related API calls
	 */

	public function test1()
	{
		$uri = 'api/v1/countries';
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
			[{
			    "id": 79,
			    "name": "United Kingdom",
			    "code": "44",
			    "iso2": "GB",
			    "currency": "GBP"
			}, {
			    "id": 234,
			    "name": "United States",
			    "code": "1",
			    "iso2": "US",
			    "currency": "USD"
			}]
		*/
		$this->assertArrayHasKey('id', $xp1[0]);
		$this->assertArrayHasKey('name', $xp1[0]);
		$this->assertArrayHasKey('code', $xp1[0]);
		$this->assertArrayHasKey('iso2', $xp1[0]);
		$this->assertArrayHasKey('currency', $xp1[0]);
	}

}
