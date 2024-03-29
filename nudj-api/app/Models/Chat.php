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

    protected $visible = ['id', 'job_id', 'created_at'];

    protected $gettableFields = ['id', 'job', 'participants', 'muted', 'created'];
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
        return $this->belongsToMany('App\Models\User', 'chat_participants')->withPivot('mute');
    }

    /* Scopes
    ----------------------------------------------------- */
    public function scopeMine($query, $userId = null)
    {
        return $query->whereHas('participants', function ($q) use ($userId) {
            $q->where('chat_participants.user_id', '=', $userId);
        });
    }

    public function scopeLive($query, $userId = null)
    {
        return $query->whereHas('participants', function ($q) use ($userId) {
            $q->where('user_id', '=', $userId)->whereNull('chat_participants.archived_at');
        });

    }

    public function scopeArchive($query, $userId = null)
    {
        return $query->whereHas('participants', function ($q) use ($userId) {
            $q->where('user_id', '=', $userId)->whereNotNull('chat_participants.archived_at');
        });

    }

    /* CRUD
   ----------------------------------------------------- */
    public static function add($jobId, $participants = [])
    {
        if (empty($participants))
            throw new ApiException(ApiExceptionType::$CHAT_ERROR);

        $chat = new Chat;
        $chat->job_id = $jobId;

        $chat->save();
        $chat->participants()->sync($participants);

        return $chat;
    }

    public function archive($participantId, $remove = false)
    {

        if ($remove)
            $archived_at = null;
        else
            $archived_at = Carbon::now();


        $this->participants()->updateExistingPivot($participantId, ['archived_at' => $archived_at]);

        return true;
    }

    public static function mute($id, $userId, $remove = false)
    {
        $chat = self::find($id);

        if (!$chat)
            return false;

        if (!$remove)
            $chat->participants()->updateExistingPivot($userId, ['mute' => !$remove]);

        return true;

    }

    public static function deleteByParticipant($participantId)
    {
        $chats = Chat::api()->mine($participantId)->active()->desc()->get();

        if (!$chats)
            return false;

        foreach ($chats as $chat)
            $chat->delete();
    }

    /* Checks
   ----------------------------------------------------- */
    public static function findIfOwnedBy($chatId, $participantId)
    {

        $chat = Chat::with('participants')->find($chatId);

        foreach ($chat->participants as $participant) {
            if ($participant->id == $participantId)
                return $chat;
        }

        return null;
    }

}


