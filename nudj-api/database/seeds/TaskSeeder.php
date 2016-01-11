<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder {

	public function run()
	{

		DB::table('tasks')->truncate();
		DB::table('failed')->truncate();

		$this->command->info('Task Queue Cleared');
	}

}
