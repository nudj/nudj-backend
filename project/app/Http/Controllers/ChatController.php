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
            'username' => $this->config->item('rackspace_username'),
            'apiKey'   => $this->config->item('rackspace_api_key')
        ));

        $this->cdn = $client->objectStoreService('cloudFiles', $this->config->item('rackspace_location'), 'publicURL');

    }


}
