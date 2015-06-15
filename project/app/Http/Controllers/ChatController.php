<?php namespace App\Http\Controllers;


use App\Http\Requests;

use GameNet\Jabber\RpcClient;
use Illuminate\Support\Facades\Config;

use OpenCloud\Rackspace;


class ChatController extends ApiController
{

    public function index()
    {

//        $rpc = new RpcClient([
//            'server' => Config::get('cfg.chat_server_ip'),
//            'host' => Config::get('cfg.chat_server_host'),
//            'debug' => false,
//        ]);



        $client = new Rackspace(Rackspace::UK_IDENTITY_ENDPOINT, array(
            'username' =>   Config::get('cfg.rackspace_username'),
            'apiKey'   => Config::get('cfg.rackspace_apikey')
        ));

        $this->cdn = $client->objectStoreService('cloudFiles', Config::get('cfg.rackspace_apikey'), 'publicURL');

    }


}
