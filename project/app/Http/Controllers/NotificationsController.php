<?php namespace App\Http\Controllers;


use App\Models\User;
use App\Http\Requests;
use App\Utility\Transformers\NotificationTransformer;


class NotificationsController extends ApiController
{

    public function index()
    {
        $id = $this->authenticator->getUserId();
        $items = User::min()->find($id)->notifications()->api()->paginate($this->limit);

        return $this->respondWithPagination($items, new NotificationTransformer());

    }

}
