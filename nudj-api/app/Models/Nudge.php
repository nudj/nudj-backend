<?php namespace App\Models;

use App\Events\SendMessageToContactEvent;
use App\Events\StartChatEvent;
use App\Models\Traits\Hashable;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Snafu;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;

use Log;

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
    public function job()
    {
        return $this->belongsTo('App\Models\Job', 'job_id');
    }

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
    public static function nudgeContacts($userId, $jobId, $contactList, $message)
    {

        /*
            $userId      : Integer   # contextual user
                                     # will later on be called referrer
            $jobId       : Integer   
            $contactList : [Integer] 
            $message     : String    
        */

        $job = Job::with('user')->findOrFail($jobId);
        $contacts = Contact::findOrFail($contactList);

        /*
            Note: 
                Eloquent findOrFail accept (int) identifiers or arrays of
        */

        /*
            $job         # Instance of Job model
            $contacts    # [ User ]    
        */

        foreach ($contacts as $contact) {

            /*
                $job->id      : id of contextual job
                $job->user_id : id of user who owns the job  
                $userId       : contextual user id
                $contact->id  : user recipient of the nudge id   
            */

            $nudge = self::addNewNudge($job->id, $job->user_id, $userId, $contact->id);

            if (!$nudge)
                continue;

            $referrer = User::find($userId); # contextual user

            if ($contact->isMobileUser()) {
                $message  = $message ?: Lang::get('messages.nudge_chat');
                /*
                    $job      : Job
                    $referrer : User 
                    $contact  : Contact
                    $message  : String   
                */
                $nudge->nudgeUser($job, $referrer, $contact, $message);
            } else {
                $message  = $message ?: Lang::get('messages.nudge_sms');
                /*
                    $job      : Job
                    $referrer : User 
                    $contact  : Contact
                    $message  : String   
                */
                $nudge->nudgeContact($job, $referrer, $contact, $message);
            }

        }

    }

    /* Private Methods
    ----------------------------------------------------- */
    private static function addNewNudge($jobId, $employerId, $referrerId, $candidateId)
    {

        $nudge = Nudge::where(['job_id' => $jobId, 'referrer_id' => $referrerId, 'candidate_id' => $candidateId])->first();

        Snafu::show($nudge, 'nudge');

        if ($nudge)
            return $nudge;

        $nudge = new Nudge();
        $nudge->job_id = $jobId;
        $nudge->employer_id = $employerId;
        $nudge->referrer_id = $referrerId;
        $nudge->candidate_id = $candidateId;
        $nudge->hash = self::generateUniqueHash();
        $nudge->save();

        return $nudge;
    }

    private function nudgeUser($job, $referrer, $contact, $message)
    {
        //@TODO if referrer->mobile = false send a notification instead of chat message
        $chat = Chat::add($job->id, [$referrer->id, $contact->user_id]);
        Event::fire(new StartChatEvent($chat->id, $referrer->id, $contact->user_id, $message));
    }

    private function nudgeContact($job, $referrer, $contact, $message)
    {

        //$message = Lang::get('sms.nudge', [
        //    'name' => $referrer->name,
        //    'message' => $message,
        //    'link' => web_url('register/nudge/' . $this->hash)
        //]);

        // https://mobileweb.nudj.co/jobpreview/98/v747uur2Ym (for production)
        // https://mobileweb-dev.nudj.co/jobpreview/98/v747uur2Ym (for dev)        

        $web_url = "https://mobileweb.nudj.co/jobpreview/".$job->id."/".$this->hash."";

        $message = Lang::get('sms.nudge', [
            'name'    => $referrer->name,
            'message' => $message,
            'link'    => $web_url
        ]);

        Event::fire(new SendMessageToContactEvent($contact->phone, $contact->country_code, $message));

    }

}


