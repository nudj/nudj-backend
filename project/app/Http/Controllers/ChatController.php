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


        $rpc->addRosterItem('ivan', 'lacho', 'Lacho', 'Nudge');
        $result = $rpc->getRoster('ivan');


        print_r($result);
        //do something

    }


    public function index_get($userId = NULL) {
        $filters['id'] = $userId ?: $this->token->userId;

        $this->response($this->user->getOne($filters));
    }

    public function username_get() {
        $username = $this->input->get('username');
        $this->responseStatus($this->user->checkBy(array( 'username' => $username )));
    }
}
