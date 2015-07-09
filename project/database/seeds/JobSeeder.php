<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder {

	public function run()
	{

		DB::table('job_likes')->truncate();
		DB::table('job_skill')->truncate();
		DB::table('job_referrer')->truncate();
		DB::table('nudges')->truncate();
		DB::table('jobs')->truncate();

	}

}
