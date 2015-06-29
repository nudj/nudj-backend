<?php namespace App\Models;

use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Transformers\ChatTransformer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends ApiModel
{

    use SoftDeletes;

    protected $table = 'chats';
    protected $prefix = 'chat.';

    protected $visible = ['id', 'job_id'];

    protected $gettableFields = ['id', 'job', 'participants'];
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
        return $this->belongsToMany('App\Models\User', 'chat_participants');
    }

    /* Scopes
    ----------------------------------------------------- */
    public function scopeMine($query, $userId = null)
    {
        return $query->whereHas('participants', function($q) use ($userId)
        {
          $q->where('chat_participants.user_id', '=', $userId);
        });
    }

    public function scopeLive($query)
    {
        return $query->whereNull('archived_at');
    }

    public function scopeArchive($query)
    {
        return $query->whereNotNull('archived_at');
    }


    /* CRUD
   ----------------------------------------------------- */
    public static function add($chatId, $participants = [])
    {
        if (empty($participants))
            throw new ApiException(ApiExceptionType::$CHAT_ERROR);

        $chat = new Chat;
        $chat->job_id = $chatId;

        $chat->save();

        $chat->participants()->sync($participants);

        return $chat;
    }


    public function restore()
    {
        $this->archived_at = null;

        return $this->save();

    }

    public function archive()
    {
        $this->archived_at = Carbon::now();

        return $this->save();

    }

}


