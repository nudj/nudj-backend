<?php namespace App\Http\Controllers;

/*
	This controller was introduced mostly 
	to allow me to run specific commands using curl
	while by passing the normal authentication.
*/

use App\Models\Job;
use App\Models\Skill;
use Elasticsearch\Client;
use Illuminate\Support\Facades\Config;

class PascalController extends \Illuminate\Routing\Controller {

	function __construct()
	{	

	}

	function hello(){
		return "Hello World!\n";
	}

	function operation1(){

	}

}