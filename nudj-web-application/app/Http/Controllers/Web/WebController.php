<?php namespace App\Http\Controllers\Web;

use App\Events\LoginUserEvent;
use App\Http\Requests\Web\WebloginRequest;
use App\Models\Country;
use App\Models\Job;
use App\Models\Nudge;
use App\Models\Referral;
use App\Models\User;
use App\Utility\ApiException;
use App\Utility\Facades\Shield;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Facades\Agent;

class WebController extends \Illuminate\Routing\Controller
{

    const TYPE_NUDGE = 'nudge';
    const TYPE_REFER = 'refer';

    public function download()
    {
        return view('web/page/downloads');
    }

    public function login($type = null, $hash = null)
    {
        if(Agent::is('iPhone'))
            return redirect('download');
            //return redirect('https://itunes.apple.com/app/id1027993202');

        switch ($type) {
            case self::TYPE_NUDGE :
                $action = Nudge::findByHash($hash);
                $user = $action->candidate;
                break;
            case self::TYPE_REFER :
                $action = Referral::findByHash($hash);
                $user = $action->referrer;
                break;
            default :
                $action = false;
        }
   
        if (!$action  || !$action->job || !$action->referrer)
            return redirect('/');

        return view('web/page/register', [
            'type' => $type,
            'hash' => $hash,
            'job' => $action->job,
            'user' => $user,
            'countries' => Country::web()->orderBy('name', 'asc')->get(),
        ]);
    }

    public function validate(WebLoginRequest $request)
    {
        $user = User::login([
            'phone' => $request->phone,
            'country_code' => $request->country_code,
            'name' => $request->name
        ], false);

        Event::fire(new LoginUserEvent($user->phone, $user->country_code, $user->verification));

        return view('web/page/validate', [
            'user' => $user,
            'job' => Request::get('job_id'),
            'hash' => Request::get('hash')
        ]);
    }

    public function job($jobId = null , $hash = null)
    {

        try {
            Shield::validate('session');
        } catch (ApiException $e) {
            return redirect('/');
        }

        $job = Job::findorFail($jobId);

        $user = User::find(Shield::getUserId());

        if(!$user || !$job)
            return redirect('/');

        if ($user->isNudged($job->id))
            $type = self::TYPE_NUDGE;
        else
            $type = self::TYPE_REFER;

        return view('web/page/job', [
            'user' => $user,
            'type' => $type,
            'hash' => $hash,
            'job' => $job,
            'employer' => $job->company,
            'skills' => $job->skills,
            'countries' => Country::web()->orderBy('name', 'asc')->get(),
        ]);
    }

    public function jobpreview($jobId = null , $hash = null)
    {

        $job = Job::findorFail($jobId);

        if(!$job)
            return redirect('/');

        return view('web/page/jobpreview', [
            'hash' => $hash,
            'job' => $job,
            'employer' => $job->company,
            'skills' => $job->skills,
            'countries' => Country::web()->orderBy('name', 'asc')->get(),
        ]);
    }

}

