<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APIUsersTest extends TestCase {

	/*
		Testing Users related API calls
	 */
	public function test1()
	{
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
}
