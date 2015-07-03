<?php namespace App\Models;

use App\Models\Traits\Hashable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Referral extends ApiModel
{

    use SoftDeletes;
    use Hashable;

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

    /* Actions
    ----------------------------------------------------- */
    public static function askContactsToReffer($jobId, $contactList)
    {

        $job = Job::findOrFail($jobId);
        $contacts = Contact::findOrFail($contactList);

        foreach ($contacts as $contact)
            self::askContactToReffer($job->id, $contact->id);

    }


    private static function askContactToReffer($jobId, $referrerId)
    {
        $refferal = new Referral();
        $refferal->job_id = $jobId;
        $refferal->referrer_id = $referrerId;
        $refferal->hash = self::generateUniqueHash();
        $refferal->save();

        //Fire Event
    }



}


