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

		DB::table('users')->insert([
			'id' => 2,
			'token' => 'CryUOlx7AN8k3PKQxJVh0JmH7ETiK6xUj8uSpZIn61dEZGZFhMSbyaAQyVks',
			'phone' => '+44123456789',
			'country_code' => 'GB',
			'verification' => 1111,
			'verified' => 1,
			'status' => 1,
			'mobile' => 1,
			'name' => 'Vanessa',
			'image' => '{"profile":"XQrFsvPlbz.png","cover":"XQrFsvPlbz.jpg"}',
			'notifications' => '{"notifications":{"1":true,"2":true,"3":true,"4":true,"5":true}}'
		]);

		DB::table('users')->insert([
			'id' => 3,
			'token' => 'CryUOlx7AN8k3PKQxJVh0JmH7ETiK6xUj8uSpZIn61dEZGZFhMSbyaAQyVks',
			'phone' => '+359884676575',
			'country_code' => 'GB',
			'verification' => 1111,
			'verified' => 1,
			'status' => 1,
			'mobile' => 1,
			'name' => 'Ivan',
			'address' => 'London',
			'position' => 'Developer',
			'company' => 'E-man',
			'about' => 'Everything is possible. The impossible just takes me more timet. Test',
			'image' => '{"profile":"AHf92G5rK3.png","cover":"AHf92G5rK3.jpg"}',
			'notifications' => '{"notifications":{"1":true,"2":true,"3":true,"4":true,"5":true}}'
		]);

		$this->command->info('Users seeded!');


	}

}
