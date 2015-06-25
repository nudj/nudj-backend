<?php namespace App\Models;

use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Transformers\ChatTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends ApiModel
{

    use SoftDeletes;

    protected $table = 'chats';
    protected $prefix = 'chat.';

    protected $visible = ['id', 'job_id'];

    protected $gettableFields = ['id', 'job'];
    protected $defaultFields = [];


    public function __construct()
    {
        $this->dependencies = ChatTransformer::$dependencies;
    }

    /* Relations
    ----------------------------------------------------- */
    public function job()
    {
        return $this->belongsTo('App\Models\Job', 'job_id');
    }

    public function participants()
    {
        return $this->belongsToMany('App\Models\Participant', 'chat_participants');
    }

    /* CRUD
   ----------------------------------------------------- */
    public static function add($chatId, $participants = [])
    {
        if(empty($participants))
            throw new ApiException(ApiExceptionType::$CHAT_ERROR);

        $chat = new Chat;
        $chat->job_id = $chatId;

        $chat->save();

        return $chat;
    }


}


