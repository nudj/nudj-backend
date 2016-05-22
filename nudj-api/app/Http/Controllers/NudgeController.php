<?php namespace App\Http\Controllers;

use App\Events\StartChatEvent;
use App\Http\Requests\ApplyRequest;
use App\Http\Requests\AskForReferralsRequest;
use App\Http\Requests\NudgeRequest;
use App\Http\Requests\StartChatRequest;
use App\Models\Application;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\Notification;
use App\Models\Nudge;
use App\Models\Referral;
use App\Utility\Facades\Shield;
use App\Utility\Snafu;
use Illuminate\Support\Facades\Event;

use Log;

class NudgeController extends ApiController
{

    public function nudge(NudgeRequest $request)
    {
        /*
            requests:
                job      : Integer
                contacts : [Integer] # optional
                message  : String 
        */
        if(empty($request->contacts)){
            return $this->respondWithStatus(true);
        }
        if(@$request->client_will_send=='true'){
            Nudge::nudgeContacts2(Shield::getUserId(), $request->job, $request->contacts, $request->message);
            return $this->respondWithStatus(true);
        }
        Nudge::nudgeContacts(Shield::getUserId(), $request->job, $request->contacts, $request->message);
        return $this->respondWithStatus(true);
    }

    public function ask(AskForReferralsRequest $request)
    {
        /*
            requests:
                job      : Integer
                contacts : [Integer] # optional
                message  : String 
        */
        if(empty($request->contacts)){
            return $this->respondWithStatus(true);
        }
        if(@$request->client_will_send=='true'){
            Referral::askContacts2(Shield::getUserId(), $request->job, $request->contacts, $request->message);
            return $this->respondWithStatus(true);
        }
        Referral::askContacts(Shield::getUserId(), $request->job, $request->contacts, $request->message);
        return $this->respondWithStatus(true);
    }

    public function apply(ApplyRequest $request)
    {
        /*
            requests:
                job_id : 
        */
        $me = Shield::getUserId();

        // --------------------------------------------
        /**
         * Below is a temporary solution to choose a referrer when applying for a job
         * When there is only one referrer, select him, In case there are more than one
         * referrer pass null. An additional solution will be implemented in future
         * adn the referrer will be passed with the ApplyRequest
         */
        $myContactIds = Contact::where('user_id', '=', $me)->lists('id');
        $nudges = Nudge::select('referrer_id')
            ->where('job_id', '=', $request->job_id)
            ->whereIn('candidate_id', $myContactIds)
            ->get();

        $referrer_id = null;
        if (count($nudges) == 1) {
            $nudge =    $nudges->first();
            $referrer_id = $nudge->referrer_id;
        }
        // --------------------------------------------

        Application::applyForJob($me, $request->job_id, $referrer_id);

        return $this->respondWithStatus(true);
    }

    public function chat(StartChatRequest $request)
    {
        /*
            requests:
                job_id  : 
                user_id : 
                message : 
        */
        $chat = Chat::add($request->job_id, [Shield::getUserId(), $request->user_id]);
        Notification::updateNotificationMeta($request->notification_id,[
            'chat_id' => $chat->id
        ]);
        Event::fire(new StartChatEvent($chat->id, Shield::getUserId(), $request->user_id, $request->message));
        return $this->respondWithStatus(true);
    }

}
