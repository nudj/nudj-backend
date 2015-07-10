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


		DB::table('jobs')->insert([
			'id' => 1,
			'user_id' => 2,
			'title' => 'Junior web developer',
			'location' => 'Sofia',
			'bonus' => 300,
			'company' => 'DevEmployer ltd',
			'salary' => 'Circa 25k - 30k',
			'description' =>  "We aren't looking for an ambitious junior web developer to join our team",
			'active' => 1,
		]);

		DB::table('jobs')->insert([
			'id' => 2,
			'user_id' => 3,
			'title' => 'Architect',
			'location' => 'Hoxton, London',
			'bonus' => 225,
			'company' => 'OurArchitectureCompany Ltd',
			'salary' => '50 000',
			'description' =>  "OurArchitectureCompany Ltd. is looking for Part-II or Part-III architects to join our practice in Hoxton, London.The studio is a growing practice and has a fun, creative culture with exciting design focused work delivered by a close knit team of designers.",
			'active' => 1,
		]);


		$this->command->info('Jobs seeded!');

	}

}
