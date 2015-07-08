<?php namespace App\Models;

use App\Events\SendMessageToContactEvent;
use App\Events\StartChatEvent;
use App\Models\Traits\Hashable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;


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
    public function askContactsToReffer($jobId, $contactList)
    {

        $job = Job::findOrFail($jobId);
        $contacts = Contact::findOrFail($contactList);

        foreach ($contacts as $contact) {

            $this->addNewReferral($jobId, $contact->id);

            if ($contact->user_id)
                $this->askContactToRefer($job->id, $contact->id, $job->user_id);
            else
                $this->askUserToRefer($job->id, $contact->id, $job->user_id);
        }

    }

    private function addNewReferral($jobId, $referrerId)
    {
        $this->job_id = $jobId;
        $this->referrer_id = $referrerId;
        $this->hash = self::generateUniqueHash();
        $this->save();

    }

    private function askUserToRefer($jobId, $referrerId, $employerId)
    {

        $chat = Chat::add($jobId, [$employerId, $referrerId]);

        Event::fire(new StartChatEvent($chat->id, $employerId, $referrerId, Lang::get('messages.askToRefer')));
    }


    private function askContactToRefer($phone)
    {
        Event::fire(new SendMessageToContactEvent($phone,  Lang::get('sms.askToRefer')));
    }

}


