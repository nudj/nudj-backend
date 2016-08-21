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

