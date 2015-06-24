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

        foreach ($rooms as $room) {
            list($roomName) = explode('@', $room);
            $rpc->deleteRoom($roomName);
        }


        $newRoomName = strtolower(str_random(6));
        $rpc->createRoom($newRoomName);
        $rpc->setRoomAffiliation($newRoomName, '6@chat.nudj.co', 'owner');
        $rpc->setRoomAffiliation($newRoomName, '3@chat.nudj.co', 'owner');
        $rpc->inviteToRoom($newRoomName, null, null,[
            '6@chat.nudj.co',
            '3@chat.nudj.co'
        ]);


    }


}
