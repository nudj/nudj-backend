<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();


		$this->call('ChatSeeder');
		$this->command->info('Chats seeded!');

		$this->call('JobSeeder');
		$this->command->info('Jobs seeded!');

		$this->call('UserSeeder');
		$this->command->info('Users seeded!');

		$this->call('SkillSeeder');
		$this->command->info('Skills seeded!');

		DB::table('notifications')->truncate();
		$this->command->info('Truncated: notifications');

		DB::table('tasks')->truncate();
		DB::table('failed')->truncate();
		$this->command->info('Task Queue Cleared');

		Model::reguard();
	}

}
