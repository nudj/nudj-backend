<?php namespace App\Http\Controllers;

use App\Events\NotifyUserEvent;
use App\Events\StartChatEvent;

use App\Http\Requests;
use App\Http\Requests\NotifyOfflineUserRequest;

use App\Models\Chat;
use App\Models\NotificationType;
use App\Models\UsersUnsafe;

use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Transformers\ChatTransformer;

use GameNet\Jabber\RpcClient;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

class ChatController extends ApiController
{

    public function index($filter = null)
    {
        $me = Shield::getUserId();

        // ->whereNotIn('id', UsersUnsafe::unsafe_userids_for_primary_user($me))

        switch ($filter) {
            case 'active' :
                $items = Chat::api()
                    ->mine($me)
                    ->live($me)
                    ->active()
                    ->desc()
                    ->paginate($this->limit);
                break;
            case 'archived' :
                $items = Chat::api()
                    ->mine($me)
                    ->archive($me)
                    ->active()
                    ->desc()
                    ->paginate($this->limit);
                break;
            case 'all' :
                $items = Chat::api()
                    ->mine($me)
                    ->active()
                    ->desc()
                    ->paginate($this->limit);
                break;
            default:
                throw new ApiException(ApiExceptionType::$INVALID_ENDPOINT);
        }

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

    public function destroy($id)
    {
        $chat = Chat::findIfOwnedBy($id, Shield::getUserId());

        if (!$chat)
            throw new ApiException(ApiExceptionType::$NOT_FOUND);


        $status = $chat->delete();

        return $this->respondWithStatus($status);
    }

    public function archive($id = null)
    {
        $chat = Chat::find($id);

        if (!$chat)
            throw new ApiException(ApiExceptionType::$CHAT_MISSING);

        $status = $chat->archive(Shield::getUserId());

        return $this->respondWithStatus($status);
    }

    public function restore($id = null)
    {
        $chat = Chat::find($id);

        if (!$chat)
            throw new ApiException(ApiExceptionType::$CHAT_MISSING);

        $status = $chat->archive(Shield::getUserId(), true);

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

    public function notify(NotifyOfflineUserRequest $request)
    {
        $meta = [
            'chat_id' => $request->chat_id,
            'type_id' => NotificationType::$CHAT_MESSAGE
        ];
        Event::fire(new NotifyUserEvent($request->user_id, $request->message, $meta));


        return $this->respondWithStatus(true);
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

    public function deleteAllRooms()
    {
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

}
