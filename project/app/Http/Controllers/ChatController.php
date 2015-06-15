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



//        $rpc->createRoom('test');
        $rpc->inviteToRoom('test', null, null,[
            '2@chat.nudj.co',
            '4@chat.nudj.co',
            '3@chat.nudj.co'
        ]);


//
//        $rooms = $rpc->getOnlineRooms();


//        $result = $rpc->sendMessageChat('3@chat.nudj.co', 'test@conference.chat.nudj.co', 'adasd');

//        print_r($result);
    }


}
