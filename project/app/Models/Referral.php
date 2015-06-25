<?php namespace App\Models;

use App\Models\Traits\Indexable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Referral extends ApiModel
{

    use SoftDeletes;

    protected $table = 'job_referrer';
    protected $visible = ['id', 'hash', 'job_id', 'referrer_id'];

    protected $gettableFields = ['id', 'hash', 'job_id', 'referrer_id'];
    protected $defaultFields = ['hash'];

    protected $prefix = 'referral.';



    /* Relations
    ----------------------------------------------------- */
    public function job()
    {
        return $this->belongsTo('App\Models\Job', 'job_id');
    }

    public function referrer()
    {
        return $this->belongsTo('App\Models\Contact', 'referrer_id');
    }



    /* Search
    ----------------------------------------------------- */
    public static function findByHash($hash = null)
    {
        return self::where('hash', '=', (string) $hash)->first();
    }

}


