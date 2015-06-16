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


        $rooms = $rpc->getOnlineRooms();
        print_r($rooms);

//        foreach ($rooms as $room) {
//            list($roomName) = explode('@', $room);
//            $rpc->deleteRoom($roomName);
//        }

        $newRoomName = 'lacho';
        $rpc->createRoom($newRoomName);
        $rpc->setRoomOption($newRoomName, 'persistent', true);
        $rpc->setRoomOption($newRoomName, 'logging', false);
        $rpc->setRoomOption($newRoomName, 'members_by_default', true);
        $rpc->inviteToRoom($newRoomName, null, null,[
            '2@chat.nudj.co',
            '3@chat.nudj.co'
        ]);


    }


}
