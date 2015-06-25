<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


class Nudge extends ApiModel
{

    use SoftDeletes;

    protected $table = 'nudges';
    protected $visible = ['id', 'hash', 'employer_id', 'referrer_id', 'candidate_id', 'job_id'];

    protected $gettableFields = ['id', 'hash', 'employer_id', 'referrer_id', 'candidate_id', 'job_id'];
    protected $defaultFields = ['hash'];

    protected $prefix = 'nudge.';



    /* Relations
    ----------------------------------------------------- */
    public function employer()
    {
        return $this->belongsTo('App\Models\User', 'employer_id');
    }

    public function referrer()
    {
        return $this->belongsTo('App\Models\Contact', 'referrer_id');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Models\Contact', 'candidate_id');
    }




    /* Search
    ----------------------------------------------------- */
    public static function findByHash($hash = null)
    {
        return self::where('hash', '=', (string) $hash)->first();
    }


}


