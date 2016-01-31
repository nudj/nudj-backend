<?php

namespace App\Http\Controllers\Desk;

use App\Models\Job;

class JobsController extends DeskController
{

    public function index()
    {
        return view('desk/pages/jobs/list');
    }

    public function show($id)
    {
        $job = Job::findOrFail($id);

        $user = \App\Models\User::find($job->user_id);
        $active_referrers_count      = \App\NSX300\NSX300_Nudges::number_of_distinct_referrers_contacting_candidates_for_job_id($job->id);
        $referral_requests_count     = \App\NSX300\NSX300_Referrals::referral_requests_count_for_job_id($job->id);
        $applications_requests_count = \App\NSX300\NSX300_Applications::applications_requests_count_for_job_id($job->id);

        $data = [
            "job"  => $job,
            "user" => $user,
            "active_referrers_count"      => $active_referrers_count,
            "referral_requests_count"     => $referral_requests_count,
            "applications_requests_count" => $applications_requests_count
        ];

        return view('desk/pages/jobs/show', $data);
    }

}