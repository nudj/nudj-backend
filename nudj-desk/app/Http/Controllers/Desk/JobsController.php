<?php

namespace App\Http\Controllers\Desk;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Models\Job;
use App\NSX300\NSX300_JobSkills as NSX300_JobSkills;
use App\NSX300\NSX300_Skills    as NSX300_Skills;

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
            "user_name"                   => strlen(trim($user->name))>0 ? $user->name : "",
            "user_email"                  => $user->email,
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

    public function ajax_get_job_skills_DataTypeB7B00162($jobidentifier){
        return json_encode(NSX300_JobSkills::job_skills_as_DataTypeB7B00162($jobidentifier));
    }

    public function ajax_remove_skill_from_job($job_identifier,$skill_id){
        NSX300_JobSkills::remove_skill_from_job($job_identifier,$skill_id);
        return json_encode(array(true));
    }

    public function ajax_add_skill_to_job(){

        $input = Input::all();

        $job_identifier = $input['jobid'];
        $skill = $input['skill'];

        // First we check if the skill exists and if it doesn't exist we create it. 
        $record = NSX300_Skills::get_skill_record_by_description_possibly_create_new($skill);
        /*
            Item = {
                'skill_identifier'  : Integer
                'skill_description' : String
            }
            [Item]
        */

        // Second we add that skill to the job, if the job didn't already have it.
        $skill_id = $record['id'];
        if(in_array($skill_id,NSX300_JobSkills::job_skills_as_integers_for_job_identifier($job_identifier))){
            return json_encode(array(true));
        }

        NSX300_JobSkills::add_skill_to_job($job_identifier,$skill_id);
        return json_encode(array(true));        
    }

    public function ajax_set_job_owner($job_identifier,$user_identifier){
        $job = Job::find($job_identifier);
        if (!$job){
            return '[false]';
        }
        $user = \App\Models\User::find($user_identifier);
        if (!$user){
            return '[false]';
        }
        $user_identifier = (int)$user_identifier;
        $job->user_id = $user_identifier;
        $saved = $job->save();
        return '[true]';
    }

    public function ajax_delete_job($job_identifier){
        $job = Job::find($job_identifier);
        if (!$job){
            return '[false]';
        }
        \App\NSX300\NSX300_Jobs::delete_job($job_identifier);
        return '[true]';
    }

    public function jobapplications(){
        $data = [

        ];
        return view('desk/pages/jobs/jobapplications', $data);
    }

}