<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder {

	public function run()
	{

		DB::table('user_favourites')->truncate();
		DB::table('user_skill')->truncate();
		DB::table('contacts')->truncate();
		DB::table('devices')->truncate();
		DB::table('users')->truncate();

		DB::table('users')->insert([
			'token' => 'sys-7xngvxq1uGF8BWpEwjmmg1NfAqxdYHL4xqgXBCtxwYcxJH3un1Foh0nz',
			'roles' => json_encode(['admin'])
		]);

		$this->command->info('Users seeded!');


	}

}
