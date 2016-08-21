<?php namespace App\Http\Controllers\Web;

use App\Events\LoginUserEvent;
use App\Http\Requests\Web\WebloginRequest;

use App\Models\Country;
use App\Models\Job;
use App\Models\Nudge;
use App\Models\Referral;
use App\Models\User;
use App\Models\Text1;

use App\Utility\ApiException;
use App\Utility\Facades\Shield;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;

use Jenssegers\Agent\Facades\Agent;


use Log;

class WebController extends \Illuminate\Routing\Controller
{

    const TYPE_NUDGE = 'nudge';
    const TYPE_REFER = 'refer';

    public function download()
    {
        return view('web/page/downloads');
    }

    public function login2($jobidentifier)
    {
        if(Agent::is('iPhone'))
            return redirect('download');
            //return redirect('https://itunes.apple.com/app/id1027993202');

        $job = Job::find($jobidentifier);
        $user = User::find(13);

        return view('web/page/register2', [
            'type' => self::TYPE_NUDGE,
            'job'  => $job,
            'user' => $user,
            'countries' => Country::web()->orderBy('name', 'asc')->get(),
        ]);
    }

    public function validate(WebLoginRequest $request)
    {

    	/*

			The following function is called 'login' but in fact it just retrieve a user by 
			a phone number and a country code.

			If that user didn't exist, it creates it, of course no more than the phone and 
			the country code are saved in the database

    	*/

        $user = User::login([
            'phone'        => $request->phone,
            'country_code' => $request->country_code,
            'name'         => $request->name
        ], false);

        /*
            So we fire an event. 
            I presume this was set up to avoid latency.
        */

        Event::fire(new LoginUserEvent($user->phone, $user->country_code, $user->verification));

        /*
            Generating the HTML page.
        */

        return view('web/page/validate', [
            'user' => $user,
            'job'  => Request::get('job_id'),
            'hash' => Request::get('hash')
        ]);
    }

    public function validate2(WebLoginRequest $request)
    {

        /*

            The following function is called 'login' but in fact it just retrieve a user by 
            a phone number and a country code.

            If that user didn't exist, it creates it, of course no more than the phone and 
            the country code are saved in the database

        */

        $user = User::login([
            'phone'        => $request->phone,
            'country_code' => $request->country_code,
            'name'         => $request->name
        ], false);

        /*
            So we fire an event. 
            Which is going to send the SMS
        */

        Event::fire(new LoginUserEvent($user->phone, $user->country_code, $user->verification));

        /*
            Generating the HTML page.
        */

        return view('web/page/validate2', [
            'user' => $user,
            'job'  => Request::get('job_id')
        ]);
    }

    // -------------------------------------------------------------------
    // New implementation

    public function apply($jobId = null) {
        return view('web/page/2b1-apply', []);
    }

    public function appdownloads($jobId = null) {
        return view('web/page/2b3-appdownloads', []);
    }

    public function jobview($jobId = null)
    {
        $job = Job::findorFail($jobId);
        if(!$job){
            return redirect('/');
        }
        $job_creation_unixtime = strtotime($job->created_at);
        $job_age_in_days = (time()-$job_creation_unixtime)/86400;
        $job_age_in_days_integer = (int)$job_age_in_days;
        return view('web/page/screen1-jobview', [
            'job'       => $job,
            'skills'    => $job->skills,
            'posted_at' => $job_age_in_days <= 1 ? 'Today' : "".($job_age_in_days_integer)." day". ( $job_age_in_days<=2 ? '' : 's' ) ." ago" 
        ]);
    }    

    public function nudjAFriend($jobId = null){
        $job = Job::findorFail($jobId);
        if(!$job){
            return redirect('/');
        }
        return view('web/page/2a1-nudj-a-friend', [
            'job' => $job
        ]);
    }

}

