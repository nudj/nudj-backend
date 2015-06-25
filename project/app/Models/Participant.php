<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends ApiModel
{

    use SoftDeletes;

    protected $table = 'chat_participants';
    protected $prefix = 'participant.';

    public function __construct()
    {
    }

    /* Relations
    ----------------------------------------------------- */
    public function chat()
    {
        return $this->belongsTo('App\Models\Chat', 'chat_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}


