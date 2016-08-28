<?php namespace App\Http\Controllers;

use App\Models\Job;

use App\Utility\ApiException;

use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;

use Jenssegers\Agent\Agent as Agent;

use App\NSX300\NSX300_Configuration;

use Log;

class WebController extends \Illuminate\Routing\Controller
{

    // -------------------------------------------------------------------
    // New implementation

    public function apply($jobId = null) {
        $job = Job::findorFail($jobId);
        if(!$job){
            return redirect('/');
        }

        //https://github.com/jenssegers/agent
        $agent = new Agent();
        
        if($agent->is('iPhone')){
            return redirect('https://geo.itunes.apple.com/gb/app/nudj-the-talent-referral-app/id1081609782?mt=8');
        }else{
            return view('2b1-apply', [
                'job' => $job,
            ]);
        }
    }

    public function appdownloads($applicationuuid) {
        return view('2b3-appdownloads', [
            'applicationuuid' => $applicationuuid
        ]);
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
        return view('screen1-jobview', [
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
        return view('2a1-nudj-a-friend', [
            'job' => $job,
            'websiteurl' => NSX300_Configuration::getApplicationURL()
        ]);
    }

}

