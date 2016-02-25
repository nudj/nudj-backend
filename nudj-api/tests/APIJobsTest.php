<?php

// https://phpunit.de/manual/current/en/phpunit-book.html

class APIJobsTest extends TestCase {

	/*
		Testing Jobs related API calls
	 */
	public function test1()
	{

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/jobs/search/Casting+instructor';
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
		if(count($xp1['data'])>0){
			$this->assertArrayHasKey('id', $xp1['data'][0]);
			$this->assertArrayHasKey('title', $xp1['data'][0]);
			$this->assertArrayHasKey('user', $xp1['data'][0]);			
		}
	}
	public function test2()
	{

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/jobs/mine';
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
		if(count($xp1['data'])>0){
			$this->assertArrayHasKey('id', $xp1['data'][0]);
			$this->assertArrayHasKey('title', $xp1['data'][0]);
			$this->assertArrayHasKey('user', $xp1['data'][0]);			
		}

	}
	public function test3()
	{

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/jobs/alice';
		$method = 'GET';
		$parameters = [];
		$cookies = [];
		$files = [];
		$server = [];
		$content = null;
		$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
		$request->headers->set('token',$usertoken);
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

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		// Get a job by identifier

		$uri = 'api/v1/jobs/1';
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

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		// Insert a job

		$uri = 'api/v1/jobs';
		$method = 'POST';
		$parameters = [
			"title"           => 'title-x',
			"description"     => 'description-x',
			"salary"          => "testing free form salary",
			"salary_amount"   => 701,
			"salary_currency" => 'GBP',
			"bonus"           => 666,
			"bonus_currency"  => 'GBP',
			"skills"          => ["skill1","skill2"]
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

		$jobmodel = new App\Models\Job();
		$jobs = $jobmodel->all();
		$this->assertTrue(count($jobs)>0);
		$job = $jobs[0];
		$user = $job->user;
		$usertokens = DB::select('select token from users where id = ?', [$user->id]);
		$usertoken = $usertokens[0];

		// Update the job details

		$uri = 'api/v1/jobs/'.$job->id;
		$method = 'PUT';
		$parameters = [
			"title"           => "title:".md5(microtime()),
			"description"     => "description:".md5(microtime()),
			"bonus"           => rand(0,1000),
			"bonus_currency"  => 'GBP',
			"salary_amount"   => rand(0,1000),
			"salary_currency" => 'GBP',
			"skills"          => [md5(microtime()),md5(microtime())],
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
				"timestamp": 1452958734.212
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
	}

	public function test7()
	{

		// Delete a job identified by id

		// --------------------------------------------------------------------
		// Selecting jobid
		$jobid = null;
		$dbresults = DB::select('select id from jobs where deleted_at is NULL');
		foreach($dbresults as $dbresult){
			$jobid = $dbresult->id;
		}
		if(is_null($jobid)){
			return;
		}
		// --------------------------------------------------------------------

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		$uri = 'api/v1/jobs/'.$jobid;
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
				"timestamp": 1452958734.212
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);
	}

	public function test8()
	{

		// ---------------------------------------------
		// Create a job with minimum information

		$title = md5(microtime());

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		// ---------------------------------------------
		// Create a job
		$uri = 'api/v1/jobs';
		$method = 'POST';
		$parameters = [
			"title"            => $title,
			"description"      => 'description-x',
			"bonus"            => 999,
			"bonus_currency"   => 'GBP',
			"skills"           => ["php"],
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

		$job_identifier = $xp1['data']['id'];


		// ---------------------------------------------
		// Create a job
		// Check that the job exist
		// Delete the job

		$title = md5(microtime());

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		// ---------------------------------------------
		// Create a job
		$uri = 'api/v1/jobs';
		$method = 'POST';
		$parameters = [
			"title"            => $title,
			"description"      => 'description-x',
			"bonus"            => 666,
			"salary_amount"    => 999,
			"salary_currency"  => 'GBP',
			"bonus_currency"   => 'GBP',
			"skills"           => ["skill1","skill2"],
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

		$job_identifier = $xp1['data']['id'];

		// ---------------------------------------------
		// Check that the job exist		

		$uri = 'api/v1/jobs/'.$job_identifier;
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

		$this->assertEquals($job_identifier, $xp1['data']['id']);			

		// ---------------------------------------------
		// Delete the job

		$uri = 'api/v1/jobs/'.$job_identifier;
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
				"timestamp": 1452958734.212
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);

	}
	public function test9()
	{

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		// Like a job

		$uri = 'api/v1/jobs/1/like';
		$method = 'PUT';
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
				"timestamp": 1452958734.212
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);
	}
	public function test10()
	{

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		// Like a job

		$uri = 'api/v1/jobs/1/like';
		$method = 'PUT';
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
				"timestamp": 1452958734.212
			}
		*/
		$this->assertArrayHasKey('status', $xp1);
		$this->assertTrue($xp1['status']);
	}
	public function test11()
	{

		$dbresults = DB::select('select token from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;			
		}

		// Unlike a job

		$uri = 'api/v1/jobs/1/like';
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
				"timestamp": 1452958734.212
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

		$uri = 'api/v1/jobs/4/block';
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

	public function test13()
	{

		$dbresults = DB::select('select * from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;	
			$userid = $dbresult->id;		
		}

		$uri = 'api/v1/jobs/2/block';
		$method = 'POST';
		$parameters = [];
		$cookies = [];
		$files = [];
		$server = [];
		$content = null;
		$request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
		$request->headers->set('token',$usertoken);
		$response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);

		$this->assertEquals(400, $response->getStatusCode());

	}

	public function test14()
	{

		$dbresults = DB::select('select * from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			$usertoken = $dbresult->token;	
			$userid = $dbresult->id;		
		}

		$uri = 'api/v1/jobs/2/block';
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

	}	

}
