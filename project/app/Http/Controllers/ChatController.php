<?php namespace App\Http\Controllers;


use App\Events\StartChatEvent;
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
use Illuminate\Support\Facades\Event;


class ChatController extends ApiController
{

    public function index()
    {

        $userId = Shield::getUserId();

        $items = Chat::api()->mine($userId)->live()->paginate($this->limit);

        return $this->respondWithPagination($items, new ChatTransformer());
    }

    public function show($id = null)
    {
        $id = $this->getPreparedId($id);

        $item = Chat::api()->find($id);

        if (!$item)
            throw new ApiException(ApiExceptionType::$CHAT_MISSING);

        return $this->respondWithItem($item, new ChatTransformer());
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


    public function mute($id = null)
    {
        return $this->respondWithStatus(Chat::mute($id, Shield::getUserId()));
    }

    public function unmute($id = null)
    {
        return $this->respondWithStatus(Chat::mute($id, Shield::getUserId()));
    }



    /* Test Purposes
    --------------------------------------------- */
    public function spawn()
    {
        $chat = Chat::add(1, [1, Shield::getUserId()]);

        $room = isset($_GET['room']) ? $_GET['room'] : 1;
        Event::fire(new StartChatEvent($room, Shield::getUserId(), 3, 'Spawning a chat :)'));

        return $this->respondWithStatus('true');
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
