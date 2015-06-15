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


//        $rpc->createRoom('test');
//        $rpc->inviteToRoom('test', null, null,[
//            '3@chat.nudj.co',
//            '4@chat.nudj.co'
//        ]);

        $rpc->setRoomAffiliation('test', '3@chat.nudj.co' ,'member');
        $rpc->setRoomAffiliation('test', '4@chat.nudj.co' ,'member');

        $rooms = $rpc->getOnlineRooms();

        print_r($rooms);
    }


}
