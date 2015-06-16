<?php namespace App\Http\Controllers;


use App\Http\Requests;

use GameNet\Jabber\RpcClient;
use Illuminate\Support\Facades\Config;


class ChatController extends ApiController
{

    public function index()
    {

        $rpc = new RpcClient([
            'server' => Config::get('cfg.chat_server_ip'),
            'host' => Config::get('cfg.chat_server_host'),
            'debug' => false,
        ]);


//        $rpc->addRosterItem('5', '3', 'someone', 'Nudge');
//        print_r($rpc->getRoster('5'));

        $rooms = $rpc->getOnlineRooms();
        print_r($rooms);

        foreach ($rooms as $room) {
            list($roomName) = explode('@', $room);
            $rpc->deleteRoom($roomName);
        }


        $newRoomName = str_random(6);;
        $rpc->createRoom($newRoomName);
        $rpc->setRoomOption($newRoomName, 'persistent', true);
        $rpc->setRoomOption($newRoomName, 'members_by_default', true);
        $rpc->inviteToRoom($newRoomName, null, null,[
            '5@chat.nudj.co',
            '3@chat.nudj.co'
        ]);


    }


}
