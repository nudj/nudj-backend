<?php

use GameNet\Jabber\RpcClient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder {

	public function run()
	{

		$rpc = new RpcClient([
			'server' =>config('cfg.chat_server_ip'),
			'host' =>config('cfg.chat_server_host'),
			'debug' => false,
		]);

		$rooms = $rpc->getOnlineRooms();

		foreach ($rooms as $room) {
			list($roomName) = explode('@', $room);
			$rpc->deleteRoom($roomName);
		}

		$this->command->info('Chats rooms deleted!');

		DB::table('chat_participants')->truncate();
		DB::table('chats')->truncate();

		$this->command->info('Chats seeded!');

	}

}
