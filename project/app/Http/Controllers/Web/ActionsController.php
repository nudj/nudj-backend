<?php namespace App\Http\Controllers\Web;


use App\Http\Requests\ApplyRequest;
use App\Http\Requests\NudgeRequest;
use App\Http\Requests\Web\VerifyUserRequest;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Nudge;
use App\Models\User;
use App\Utility\Facades\Shield;
use Illuminate\Support\Facades\Request;

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
            'success' => (bool)$user
        ]);
    }


    public function refer(NudgeRequest $request)
    {
        $nudge = new Nudge();
        $nudge->addNewNudge($request->hash, $request->contact);

        return $this->respondWithStatus(true);
    }

    public function apply(ApplyRequest $request)
    {
        die(json_encode(['status' => true]));
    }
}

