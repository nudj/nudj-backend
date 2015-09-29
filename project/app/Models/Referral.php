<?php namespace App\Models;

use App\Events\SendMessageToContactEvent;
use App\Events\StartChatEvent;
use App\Models\Traits\Hashable;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Snafu;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;


class Referral extends ApiModel
{

    use SoftDeletes;
    use Hashable;

    protected $table = 'referrals';
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
    public static function askContacts($userId, $jobId, $contactList, $message)
    {

        $job = Job::with('user')->findOrFail($jobId);
        $contacts = Contact::findOrFail($contactList);


        if ($userId != $job->user_id)
            throw new ApiException(ApiExceptionType::$JOB_OWNER_MISMATCH);


        // prepare message
        $message = $message ?: Lang::get('messages.refer', ['position' => $job->title]);

        foreach ($contacts as $contact) {

            $referral = self::addNewReferral($job->id, $contact->id);

            if (!$referral)
                continue;

            if ($contact->user_id)
                $referral->askUserToRefer($job, $contact, $message);
            else
                $referral->askContactToRefer($job, $contact, $message);
        }

    }

    private static function addNewReferral($jobId, $referrerId)
    {

        $referral = Referral::where(['job_id' => $jobId, 'referrer_id' => $referrerId])->first();
        if ($referral)
            return $referral;

        $referral = new Referral();
        $referral->job_id = $jobId;
        $referral->referrer_id = $referrerId;
        $referral->hash = self::generateUniqueHash();
        $referral->save();

        return $referral;
    }

    private function askUserToRefer($job, $contact, $message)
    {
        // Start chat
        $chat = Chat::add($job->id, [$job->user_id, $contact->user_id]);
        Event::fire(new StartChatEvent($chat->id, $job->user_id, $contact->user_id, $message));

        // Create notification
        Notification::askToRefer($contact->user_id, $job->user_id, [
            'job_id' => $job->id,
            'job_title' => $job->title,
            'job_bonus' => $job->bonus,
            'chat_id' => $chat->id,
            'message' => $message,
            'employer' => $job->user->name,
        ]);
    }


    private function askContactToRefer($job, $contact, $message)
    {
        $employer = User::findOrFail($job->user_id);

        $message = Lang::get('sms.refer', [
            'name' => $employer->name,
            'message' => $message,
            'link' => web_url('register/refer/' . $this->hash)
        ]);


        Event::fire(new SendMessageToContactEvent($contact->phone, $contact->country_code, $message));
    }

}


