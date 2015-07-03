<?php namespace App\Models;

use App\Models\Traits\Hashable;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use Illuminate\Database\Eloquent\SoftDeletes;


class Nudge extends ApiModel
{

    use SoftDeletes;
    use Hashable;

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

    /* Actions
   ----------------------------------------------------- */
    public static function addNewNudge($hash, $contactId)
    {
        $referral = Referral::where('hash', '=', $hash)->first();

        if(!$referral)
            throw new ApiException(ApiExceptionType::$REFERRAL_MISSING);

        // we can access $referral->job->user_id instead,
        // but we use the method below to throw an exception in case of missing Job
        $job = Job::findOrFail($referral->job_id);
        $contact = Contact::findOrFail($contactId);

        $nudge = new Nudge();
        $nudge->job_id = $job->id;
        $nudge->employer_id = $job->user_id;
        $nudge->referrer_id = $referral->referrer_id;
        $nudge->candidate_id = $contact->id;
        $nudge->hash = self::generateUniqueHash();
        $nudge->save();

    }



}


