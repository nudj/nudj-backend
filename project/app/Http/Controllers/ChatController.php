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


    }


}
