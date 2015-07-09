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

            if(!$this->addNewReferral($jobId, $contact->id))
                continue;

            if ($contact->user_id)
                $this->askUserToRefer($job->id, $contact->user_id, $job->user_id);
            else
                $this->askContactToRefer($job->id, $contact->id, $job->user_id);
        }

    }

    private function addNewReferral($jobId, $referrerId)
    {

        if(Referral::where(['job_id' => $jobId, 'referrer_id' => $referrerId])->first())
            return false;

        $this->job_id = $jobId;
        $this->referrer_id = $referrerId;
        $this->hash = self::generateUniqueHash();

        return $this->save();
    }

    private function askUserToRefer($jobId, $referrerUserId, $employerUserId)
    {
        // Create notification
        Notification::createAskToReferNotification($referrerUserId, $employerUserId, ['job' => $jobId]);

        // Start chat
        $chat = Chat::add($jobId, [$employerUserId, $referrerUserId]);
        Event::fire(new StartChatEvent($chat->id, $employerUserId, $referrerUserId, Lang::get('messages.askToRefer')));
    }


    private function askContactToRefer($phone)
    {
        Event::fire(new SendMessageToContactEvent($phone,  Lang::get('sms.askToRefer')));
    }

}


