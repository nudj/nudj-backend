<?php namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Http\Requests;
use App\Utility\Facades\Shield;
use App\Utility\Transformers\NotificationTransformer;

class NotificationsController extends ApiController
{

    public function index()
    {
        $id = Shield::getUserId();
        $items = User::min()->find($id)->notifications()->api()->desc()->paginate($this->limit);

        return $this->respondWithPagination($items, new NotificationTransformer());
    }

    public function read($id)
    {
        return $this->respondWithStatus(Notification::markRead($id));
    }

}
