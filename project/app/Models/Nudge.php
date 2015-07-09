<?php namespace App\Models;

use App\Events\SendMessageToContactEvent;
use App\Events\StartChatEvent;
use App\Models\Traits\Hashable;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use OpenCloud\Database\Resource\User;


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
    public function addNewNudge($hash, $contactId, $message = null)
    {
        $referral = Referral::where('hash', '=', $hash)->first();

        if(!$referral)
            throw new ApiException(ApiExceptionType::$REFERRAL_MISSING);


        // we can access $referral->job->user_id instead,
        // but we use the method below to throw an exception in case of missing Job
        $job = Job::findOrFail($referral->job_id);
        $contact = Contact::findOrFail($contactId);

        // @TODO maybe check for duplicates

        $nudge = new Nudge();
        $nudge->job_id = $job->id;
        $nudge->employer_id = $job->user_id;
        $nudge->referrer_id = $referral->referrer_id;
        $nudge->candidate_id = $contact->id;
        $nudge->hash = self::generateUniqueHash();
        $nudge->save();

        $message = $message ?: Lang::get('messages.refer');
        $referrer = Shield::getUserModel();

        if ($contact->user_id)
            $this->nudgeUser($job, $referrer, $contact, $message);
        else
            $this->nudgeContact($job, $referrer, $contact, $message, $hash);

    }


    private function nudgeUser($job, $referrer, $contact, $message)
    {
        $chat = Chat::add($job->id, [$referrer->id, $contact->user_id]);
        Event::fire(new StartChatEvent($chat->id, $referrer->id, $contact->user_id, $message));
    }


    private function nudgeContact($job, $referrer, $contact, $message, $hash)
    {

        $message = Lang::get('sms.nudge', [
            'name' => $referrer->name,
            'message' => $message,
            'link' => web_url('register/nudge/' . $hash)
        ]);

        Event::fire(new SendMessageToContactEvent($contact->phone, $message));
    }



}


