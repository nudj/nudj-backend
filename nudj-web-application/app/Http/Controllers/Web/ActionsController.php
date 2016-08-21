<?php namespace App\Http\Controllers\Web;

use App\Http\Requests\ApplyRequest;
use App\Http\Requests\Web\NudgeRequest;
use App\Http\Requests\Web\VerifyUserRequest;
use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Nudge;
use App\Models\User;
use App\Utility\Facades\Shield;

use App\NSX300\NSX300_ApplicationsX1;

use Log;

class ActionsController extends \Illuminate\Routing\Controller
{

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

    // -------------------------------------------------------------------
    // New implementation

    public function applicationDetails(ApplicationRequest $request) {
        //Log::info("nameInput    : ".$request->nameInput);
        //Log::info("emailInput   : ".$request->emailInput);
        //Log::info("linkInput    : ".$request->linkInput);
        //Log::info("referrerInput: ".$request->referrerInput);
        $name     = $request->nameInput;
        $email    = $request->emailInput;
        $link     = $request->linkInput;
        $referrer = $request->referrerInput;
        NSX300_ApplicationsX1::insertRecord($name,$email,$link,$referrer);
        return response()->json([
            'success' => $request->all()
        ]);
    }

}

