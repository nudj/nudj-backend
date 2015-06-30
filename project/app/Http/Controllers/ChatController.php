<?php namespace App\Http\Controllers;


use App\Http\Requests;

use App\Models\Chat;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Transformers\ChatTransformer;
use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Protocol\Message;
use Fabiang\Xmpp\Protocol\Presence;
use GameNet\Jabber\RpcClient;
use Illuminate\Support\Facades\Config;


class ChatController extends ApiController
{

    public function index()
    {
        $userId = Shield::getUserId();

        $items = Chat::api()->mine($userId)->live()->paginate($this->limit);

        return $this->respondWithPagination($items, new ChatTransformer());
    }

    public function archived()
    {
        $userId = Shield::getUserId();

        $items = Chat::api()->mine($userId)->archive()->paginate($this->limit);

        return $this->respondWithPagination($items, new ChatTransformer());
    }

    public function archive($id = null)
    {
        $chat = Chat::find($id);

        if (!$chat)
            throw new ApiException(ApiExceptionType::$CHAT_MISSING);

        $status = $chat->archive($id);

        return $this->respondWithStatus($status);
    }

    public function restore($id = null)
    {

        $chat = Chat::find($id);

        if (!$chat)
            throw new ApiException(ApiExceptionType::$CHAT_MISSING);

        $status = $chat->restore($id);

        return $this->respondWithStatus($status);
    }

    /* Test Purposes
    --------------------------------------------- */
    public function spawn()
    {

//        $options = new Options('tcp://chat.nudj.co:5222');
//        $options->setUsername('1@chat.nudj.co/6576494651435660563955096')
//            ->setPassword('sys-7xngvxq1uGF8BWpEwjmmg1NfAqxdYHL4xqgXBCtxwYcxJH3un1Foh0nz');
//
//        $client = new Client($options);
//        $client->connect();
//
//        // join a channel
//        $channel = new Presence;
//        $channel->setTo('1@conference.chat.nudj.co')
//            ->setNickName('Some name');
//        $client->send($channel);
//
//        $message = new Message;
//        $message->setMessage('testing')
//            ->setTo('1@conference.chat.nudj.co')
//            ->setType(Message::TYPE_GROUPCHAT);
//        $client->send($message);
//        $client->disconnect();
//        die();




        $roomName = (string) 1;
        $creator = $this->getChatName($this->authenticator->getUserId());
        $other = $this->getChatName(3);

        $chat = Chat::add($roomName, [6,$this->authenticator->getUserId()]);

        $rpc = new RpcClient([
            'server' => Config::get('cfg.chat_server_ip'),
            'host' => Config::get('cfg.chat_server_host'),
            'debug' => false,
        ]);


        $rpc->createRoom($roomName);
        $rpc->setRoomAffiliation($roomName, $creator, 'owner');
        $rpc->setRoomAffiliation($roomName, $other, 'owner');
        $rpc->setRoomOption($roomName,'anonymous', true);
        $rpc->setRoomOption($roomName,'allow_change_subj', true);
        $rpc->setRoomOption($roomName,'public', true);
        $rpc->setRoomOption($roomName,'logging', true);


        $rpc->inviteToRoom($roomName, null, null, [$creator, $other]);

    }

    public function deleteAllRooms() {

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

    }

    private function getChatName($id)
    {
        return $id . '@' . Config::get('cfg.chat_server_host');
    }


}
