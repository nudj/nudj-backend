<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APIConfigTest extends TestCase {

	/*
		Testing Notification related API calls
	 */

	public function test1()
	{

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/config';
		$method = 'GET';
		$parameters = [];
		$cookies = [];
		$files = [];
		$server = [];
		$content = null;
		$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
		$request->headers->set('token',$usertoken);
		$response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);

		$this->assertEquals(200, $response->getStatusCode());
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			See documentation: d29d44fd-96ad-41ba-b28a-5417a80697cb
			{
				"data": {
					"status": {
						"1": "Hiring",
						"2": "Available",
						"3": "Do not disturb"
					},
					"linkedin_permission": "r_basicprofile"
				},
				"timestamp": 1453046531.1291
			}
		*/
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('status', $xp1["data"]);
		$this->assertArrayHasKey('linkedin_permission', $xp1["data"]);
	}

	public function test2()
	{

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/config/status';
		$method = 'GET';
		$parameters = [];
		$cookies = [];
		$files = [];
		$server = [];
		$content = null;
		$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
		$request->headers->set('token',$usertoken);
		$response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);

		$this->assertEquals(200, $response->getStatusCode());
		$xp1 = json_decode($response->getContent(),true);
		$this->assertInternalType('array', $xp1);
		/*
			See documentation: d29d44fd-96ad-41ba-b28a-5417a80697cb
			{
				"data": {
					"1": "Hiring",
					"2": "Available",
					"3": "Do not disturb"
				},
				"timestamp": 1453046941.3916
			}
		*/
		$this->assertArrayHasKey('data', $xp1);
	}

}
