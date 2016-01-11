<?php

use App\Http\Controllers\CloudController;
use App\Utility\CloudHelper;
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


		$cloudHelper = new CloudHelper(config('cfg.rackspace'));
		$cloudHelper->emptyContainer('UserImage');
		$this->command->info('All cloud containers emtied!');


		$this->call('ChatSeeder');

		$this->call('JobSeeder');

		$this->call('UserSeeder');

		$this->call('SkillSeeder');

		DB::table('notifications')->truncate();
		$this->command->info('Truncated: notifications');

		$this->call('TaskSeeder');


		Model::reguard();
	}

}
