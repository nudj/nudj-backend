<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APIContactTest extends TestCase {

	/*
		Testing Nudge related API calls
	 */
	public function test1()
	{
		// [GET     api/v1/contacts/mine](xf1901)

		$dbresults = DB::select('select token from users where deleted_at is NULL');
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/contacts/mine';
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
			
		*/
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('count', $xp1);
	}

	public function test2()
	{
		// [POST    api/v1/contacts/{id}/invite](xf1904)
		// No testing due to SMS sending
	}

	public function test3()
	{
		// [PUT     api/v1/contacts/{id}](xf1902)
		// TODO: be tested.
	}

	public function test4()
	{
		// [DELETE  api/v1/contacts/{id}](xf1903)
		// TODO: be tested.
	}

}
