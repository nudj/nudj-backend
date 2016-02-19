<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APIUsersTest extends TestCase {

	/*
		Testing Users related API calls
	 */
	public function test1()
	{

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		// Testing retrieving the list of users.

		$uri = 'api/v1/users';
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

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/users/1';
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

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

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
		$request->headers->set('token',$usertoken);
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

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

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
		$request->headers->set('token',$usertoken);
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


		// --------------------------------------------------------------------
		// Selecting jobid
		$user_phone        = null;
		$user_country_code = null;
		$user_verification = null;
		$dbresults = DB::select('select phone, country_code, verification from users where deleted_at is NULL');
		foreach($dbresults as $dbresult){
			$user_phone        = $dbresult->phone;	
			$user_country_code = $dbresult->country_code;	
			$user_verification = $dbresult->verification;		
		}
		if(is_null($user_phone)){
			return;
		}
		// --------------------------------------------------------------------

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/users/verify';
		$method = 'PUT';
		$parameters = [
			"phone"        => $user_phone,
			"country_code" => $user_country_code,
			"verification" => $user_verification,
		];
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
	}

	public function test7()
	{

		// Testing users/2/favourites.

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/users/2/favourites';
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

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/users/exists/1';
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
			{
				"status": true,
				"timestamp": 1452710537.5602
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);

	}

	public function test9()
	{

		// Testing api/v1/users/2/contacts.

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/users/2/contacts';
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
			{
				"data": {
					"A": [{
						"id": "4",
						"phone": "+445555228243",
						"alias": "Anna Haro"
					}, {
						"id": "7",
						"phone": "+447507765774",
						"alias": "Antonio"
					}],
					"D": [{
						"id": "2",
						"phone": "+445554787672",
						"alias": "Daniel Higgins Jr."
					}, {
						"id": "6",
						"phone": "+445556106679",
						"alias": "David Taylor"
					}],
					"H": [{
						"id": "5",
						"phone": "+445557664823",
						"alias": "Hank M. Zakroff"
					}],
					"J": [{
						"id": "3",
						"phone": "+448885555512",
						"alias": "John Appleseed"
					}],
					"K": [{
						"id": "1",
						"phone": "+445555648583",
						"alias": "Kate Bell"
					}],
					"L": [{
						"id": "8",
						"phone": "+447946390510",
						"alias": "Lacho UK"
					}]
				},
				"pagination": {
					"total": 8,
					"count": 8,
					"next": false,
					"previous": false
				},
				"timestamp": 1452710733.5182
			}
		*/
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('pagination', $xp1);

	}

	public function test10()
	{

		// Testing GET api/v1/users/2/favourites.

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/users/2/favourites';
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
		$this->assertArrayHasKey('data', $xp1);
		$this->assertArrayHasKey('pagination', $xp1);
		$this->assertArrayHasKey('total', $xp1['pagination']);
		$this->assertArrayHasKey('count', $xp1['pagination']);
		$this->assertArrayHasKey('next', $xp1['pagination']);
		$this->assertArrayHasKey('previous', $xp1['pagination']);

	}

	public function test11()
	{

		// Testing DELETE api/v1/users/205/favourite.

		$dbresults = DB::select('select * from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;	
			$userid = $dbresult->id;		
		}

		$uri = 'api/v1/users/'.$userid.'/favourite';
		$method = 'DELETE';
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
			{
				"status": true,
				"timestamp": 1453032189.9975
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);

	}

	public function test12()
	{

		$dbresults = DB::select('select * from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;	
			$userid = $dbresult->id;		
		}

		$uri = 'api/v1/users/2/block';
		$method = 'POST';
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
			{
				"status": true,
				"timestamp": 1453032189.9975
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);

	}
}
