<?php namespace App\Http\Controllers;


use App\Http\Requests;

use GameNet\Jabber\RpcClient;
use Illuminate\Support\Facades\Config;

use OpenCloud\Rackspace;


class ChatController extends ApiController
{

    public function index()
    {

        $rpc = new RpcClient([
            'server' => Config::get('cfg.chat_server_ip'),
            'host' => Config::get('cfg.chat_server_host'),
            'debug' => false,
        ]);


        $rpc->createRoom('test');
        $rpc->inviteToRoom('test', null, null,[
            '3@chat.nudj.co',
            '4@chat.nudj.co'
        ]);

    }


}
