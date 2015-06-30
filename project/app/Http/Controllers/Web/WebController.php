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
use App\Utility\ApiException;
use App\Utility\Facades\Shield;
use Illuminate\Support\Facades\Request;

class WebController extends \Illuminate\Routing\Controller
{

    const TYPE_NUDGE = 'nudge';
    const TYPE_REFER = 'refer';

    public function register($type = null, $hash = null)
    {

        switch ($type) {
            case self::TYPE_NUDGE :
                $action = Nudge::findByHash($hash);
                break;
            case self::TYPE_REFER :
                $action = Referral::findByHash($hash);
                break;
            default :
                $action = false;
        }

        if (!$action)
            return redirect('/');

        return view('web/page/register', [
            'type' => $hash,
            'job' => $action->job,
            'user' => $action->referrer,
            'countries' => Country::web()->orderBy('name', 'asc')->get(),
        ]);
    }

    public function validate()
    {
        $user = User::login(['phone' => Request::get('phone')], false);

        /*Event::fire(new LoginUserEvent($user->phone, $user->verification));*/

        return view('web/page/validate', [
            'user' => $user,
            'job' => Request::get('jobid')
        ]);
    }

    public function verify(VerifyUserRequest $request)
    {
        if (!Request::ajax())
            redirect('/');

        $user = User::verify($request->all());

        if ($user)
            Shield::createSession($user->token);

        return response()->json([
            'success' => (bool)$user
        ]);
    }

    public function job($jobId = null)
    {
        try {
            Shield::validate('session');
        } catch (ApiException $e) {
            redirect('/');
        }

        $user = User::find(Shield::getUserId());

        $job = Job::find($jobId);

        $type = false;

        if ($user->isAskedToRefer($job->id))
            $type = self::TYPE_REFER;

        if ($user->isNudged($job->id))
            $type = self::TYPE_NUDGE;

        if(!$type)
            redirect('/');

        return view('web/page/job', [
            'user' => $user,
            'type' => $type,
            'job' => $job,
            'employer' => $job->user->name,
            'skills' => $job->skills,
        ]);
    }

}

