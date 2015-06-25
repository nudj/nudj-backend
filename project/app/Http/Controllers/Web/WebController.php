<?php namespace App\Http\Controllers\Web;


use App\Events\Event;
use App\Events\LoginUserEvent;
use App\Http\Requests\Web\CreateUserRequest;
use App\Http\Requests\Web\VerifyUserRequest;
use App\Models\Country;
use App\Models\Job;
use App\Models\Nudge;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class WebController extends \Illuminate\Routing\Controller
{


    public function register($type = null, $hash = null)
    {

        switch ($type) {
            case 'nudge' :
                $action = Nudge::findByHash($hash);
                break;
            case 'refer' :
                $action = Referral::findByHash($hash);
                break;
            default :
                $action = false;
        }

        if (!$action)
            return redirect('/');

        return view('web/page/register', [
            'type' => $type,
            'job' => $action->job,
            'user' => $action->referrer,
            'countries' => Country::web()->get(),
        ]);
    }

    public function validate(CreateUserRequest $request)
    {
        $user = User::login(['phone' => $request->phone], false);

        Event::fire(new LoginUserEvent($user->phone, $user->verification));

        return view('web/page/validate', [
            'user' => $user
        ]);
    }

    public function verify(VerifyUserRequest $request)
    {
        if (!Request::ajax())
            redirect('/');

        $user = User::verify($request->all());

        if($user)
            //@TODO: create user session

        return response()->json([
            'success' => (bool)$user
        ]);
    }

    public function job($jobId = null)
    {
        // @TODO: get logged in user
        // for the moment just use the first one
        $user = User::first();

        // @TODO: check if job is visible for this user
        // ...


        $job = Job::find($jobId);

        return view('web/page/job', [
            'user' => $user,
            'job' => $job,
            'employer' => $job->employer,
            'skills' => $job->skills,
        ]);
    }

}

