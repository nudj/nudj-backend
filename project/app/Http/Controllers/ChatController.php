<?php namespace App\Http\Controllers;


use App\Http\Requests;

use App\Models\Chat;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Transformers\ChatTransformer;
use GameNet\Jabber\RpcClient;
use Illuminate\Support\Facades\Config;


class ChatController extends ApiController
{

    public function index()
    {
        $userId = $this->authenticator->getUserId();

        $items = Chat::api()->mine($userId)->live()->paginate($this->limit);

        return $this->respondWithPagination($items, new ChatTransformer());
    }

    public function archived()
    {
        $userId = $this->authenticator->getUserId();

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

        $chat = Chat::add(1, [3,$this->authenticator->getUserId()]);

        $roomName = (string) 1;
        $creator = $this->getChatName($this->authenticator->getUserId());
        $other = $this->getChatName(3);

        $rpc = new RpcClient([
            'server' => Config::get('cfg.chat_server_ip'),
            'host' => Config::get('cfg.chat_server_host'),
            'debug' => false,
        ]);


        $rpc->createRoom($roomName);
        $rpc->setRoomAffiliation($roomName, $creator, 'owner');
        $rpc->setRoomAffiliation($roomName, $other, 'owner');
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
