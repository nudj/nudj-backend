<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder {

	public function run()
	{

		DB::table('chat_participants')->truncate();
		DB::table('chats')->truncate();

	}

}
