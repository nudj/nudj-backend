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
    public function askContactsToReffer($jobId, $contactList, $message)
    {

        $job = Job::findOrFail($jobId);
        $contacts = Contact::findOrFail($contactList);

        //@TODO check if job is held by current user

        // prepare message
        $message = $message ?: Lang::get('messages.refer', ['position' => $job->title]);

        foreach ($contacts as $contact) {

            $referral = $this->addNewReferral($job->id, $contact->id);

//            if (!$referral)
//                continue;

            if ($contact->user_id)
                $this->askUserToRefer($job, $contact, $message);
            else
                $this->askContactToRefer($job, $contact, $message, $referral->hash);
        }

    }

    private function addNewReferral($jobId, $referrerId)
    {

        if (Referral::where(['job_id' => $jobId, 'referrer_id' => $referrerId])->first())
            return false;

        $this->job_id = $jobId;
        $this->referrer_id = $referrerId;
        $this->hash = self::generateUniqueHash();
        $this->save();

        return $this;
    }

    private function askUserToRefer($job, $contact, $message)
    {
        // Create notification
        Notification::createAskToReferNotification($contact->user_id, $job->user_id);

        // Start chat
        $chat = Chat::add($job->id, [$job->user_id, $contact->user_id]);
        Event::fire(new StartChatEvent($chat->id, $job->user_id, $contact->user_id, $message));
    }


    private function askContactToRefer($job, $contact, $message, $hash)
    {
        $employer = User::findOrFail($job->user_id);

        $message = Lang::get('sms.refer', [
            'name' => $employer->name,
            'message' => $message,
            'link' => web_url('register/refer/' . $hash)
        ]);


        Event::fire(new SendMessageToContactEvent($contact->phone, $message));
    }

}


