<?php

namespace App\Http\Controllers\Desk;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Models\Job;
use App\NSX300\NSX300_JobSkills as NSX300_JobSkills;

use Log;

class JobsController extends \Illuminate\Routing\Controller
{

    public function index(){
        return view('desk/pages/jobs/list');
    }

    public function show($id){
        $job = Job::findOrFail($id);

        $user = \App\Models\User::find($job->user_id);
        $active_referrers_count      = \App\NSX300\NSX300_Nudges::number_of_distinct_referrers_contacting_candidates_for_job_id($job->id);
        $referral_requests_count     = \App\NSX300\NSX300_Referrals::referral_requests_count_for_job_id($job->id);
        $applications_requests_count = \App\NSX300\NSX300_Applications::applications_requests_count_for_job_id($job->id);

        $referral_requests = \App\NSX300\NSX300_Referrals::referral_requests_for_job_identifier($job->id);
        $html1 = \App\NSX300\NSX300_ReferralsHTML::array_of_referral_requests_as_html_lis($referral_requests);

        $nudge_requests = \App\NSX300\NSX300_Nudges::nudge_requests_for_job_identifier($job->id);
        $html2 = \App\NSX300\NSX300_NudgesHTML::array_of_nudge_requests_as_html_lis($nudge_requests);

        $application_requests = \App\NSX300\NSX300_Applications::application_requests_for_job_identifier($job->id);
        $html3 = \App\NSX300\NSX300_ApplicationsHTML::array_of_application_requests_as_html_lis($application_requests);

        $data = [
            "job"    => $job,
            "user"   => $user,
            "user_reference"              => ( strlen(trim($user->name))>0 ? $user->name : "" )." ".$user->email,
            "active_referrers_count"      => $active_referrers_count,
            "referral_requests_count"     => $referral_requests_count,
            "applications_requests_count" => $applications_requests_count,
            "html1"  => $html1,
            "html2"  => $html2,
            "html3"  => $html3,
            "skills" => implode(', ',NSX300_JobSkills::job_skills_as_descriptions_for_job_identifier($job->id))
        ];

        return view('desk/pages/jobs/show', $data);
    }

    public function createpage(){
        $data = [

        ];
        return view('desk/pages/jobs/create_new_job', $data);
    }

    public function ajax_create_job(){
        $job = new Job;

        $job->user_id = 1;
        $job->active  = 1;

        $input = Input::all();

        if (isset($input['title'])) {
            $job->title = (string)$input['title'];
        }

        if (isset($input['description'])) {
            $job->description = (string)$input['description'];
        }

        if (isset($input['active'])) {
            $job->active = (bool)$input['active'];
        }

        if (isset($input['bonus'])) {
            $job->bonus = (double)$input['bonus'];
        }

        if (isset($input['location'])) {
            $job->location = (string)$input['location'];
        }

        if (isset($input['company'])) {
            $job->company = (string)$input['company'];
        }

        if (isset($input['salary'])) {
            $job->salary = (string)$input['salary'];
        }

        $job->save();

        $return = array();
        $return['jobid'] = $job->id;

        log::info($return);

        return json_encode($return);        
    }

    public function ajax_update_job($id){
        $job = Job::find($id);
        if (!$job){
            return '[false]';
        }

        $input = Input::all();

        if (isset($input['title'])) {
            $job->title = (string)$input['title'];
        }

        if (isset($input['description'])) {
            $job->description = (string)$input['description'];
        }

        if (isset($input['active'])) {
            $job->active = (bool)$input['active'];
        }

        if (isset($input['bonus'])) {
            $job->bonus = (double)$input['bonus'];
        }

        if (isset($input['location'])) {
            $job->location = (string)$input['location'];
        }

        if (isset($input['company'])) {
            $job->company = (string)$input['company'];
        }

        if (isset($input['salary'])) {
            $job->salary = (string)$input['salary'];
        }

        $saved = $job->save();

        return '[true]';
    }

}