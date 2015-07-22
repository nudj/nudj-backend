<?php namespace App\Http\Controllers\Web;


use App\Http\Requests\ApplyRequest;
use App\Http\Requests\AskForReferralsRequest;
use App\Http\Requests\NudgeRequest;
use App\Http\Requests\Web\VerifyUserRequest;
use App\Models\Application;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Nudge;
use App\Models\Referral;
use App\Models\User;
use App\Utility\Facades\Shield;

class ActionsController extends \Illuminate\Routing\Controller
{

    public function __construct()
    {

    }

    public function countries(){
        return Country::web()->orderBy('name', 'asc')->get();
    }


    public function verify(VerifyUserRequest $request)
    {

        $user = User::verify($request->all());

        if ($user) {
            Contact::syncContactOf($user->id, $user->phone);
            Shield::createSession($user->token);
        }

        return response()->json([
            'success' => (bool) $user
        ]);
    }


    public function ask(AskForReferralsRequest $request)
    {

        if(!Shield::validate('session'))
            return response()->json(['success' => false]);

        Referral::askContacts(Shield::getUserId(), $request->job, $request->contacts, $request->message);

        return response()->json(['success' => true]);
    }

    public function nudge(NudgeRequest $request)
    {
        if(!Shield::validate('session'))
            return response()->json(['success' => false]);

        Nudge::nudgeContacts(Shield::getUserId(), $request->job, $request->contacts, $request->message);

        return response()->json(['success' => true]);
    }


    public function apply(ApplyRequest $request)
    {
        if(!Shield::validate('session'))
            return response()->json(['success' => false]);

        Application::applyForJob(Shield::getUserId(), $request->job_id);

        return response()->json(['success' => true]);
    }

}

