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

class NudgeController extends ApiController
{


    public function ask(AskForReferralsRequest $request)
    {
        Referral::askContacts(Shield::getUserId(), $request->job, $request->contacts, $request->message);

        return $this->respondWithStatus(true);
    }

    public function nudge(NudgeRequest $request)
    {
        Nudge::nudgeContacts(Shield::getUserId(), $request->job, $request->contacts, $request->message);

        return $this->respondWithStatus(true);
    }


    public function apply(ApplyRequest $request)
    {
        $me = Shield::getUserId();

        $myContactIds = Contact::where('user_id', '=', $me)->list('id')->get();
        Snafu::show($myContactIds);
        $nudge = Nudge::select('referrer_id')
            ->where('job_id', '=', $request->job_id)
            ->whereIn('candidate_id', $myContactIds)
            ->get();

        if ($nudge)
            $referrer_id = $nudge->referrer_id;

        die();
        Application::applyForJob($me, $request->job_id, $referrer_id);

        return $this->respondWithStatus(true);
    }

    public function chat(StartChatRequest $request)
    {

        $chat = Chat::add($request->job_id, [Shield::getUserId(), $request->user_id]);

        Notification::updateNotificationMeta($request->notification_id, array(
            'chat_id' => $chat->id
        ));

        Event::fire(new StartChatEvent($chat->id, Shield::getUserId(), $request->user_id, $request->message));

        return $this->respondWithStatus(true);
    }

}
