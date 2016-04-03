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

        $referral_requests = \App\NSX300\NSX300_Referrals::referral_requests_for_job_identifier($job->id);
        $html1 = \App\NSX300\NSX300_ReferralsHTML::array_of_referral_requests_as_html_lis($referral_requests);

        $nudge_requests = \App\NSX300\NSX300_Nudges::nudge_requests_for_job_identifier($job->id);
        $html2 = \App\NSX300\NSX300_NudgesHTML::array_of_nudge_requests_as_html_lis($nudge_requests);

        $application_requests = \App\NSX300\NSX300_Applications::application_requests_for_job_identifier($job->id);
        $html3 = \App\NSX300\NSX300_ApplicationsHTML::array_of_application_requests_as_html_lis($application_requests);

        $data = [
            "job"  => $job,
            "user" => $user,
            "active_referrers_count"      => $active_referrers_count,
            "referral_requests_count"     => $referral_requests_count,
            "applications_requests_count" => $applications_requests_count,
            "html1" => $html1,
            "html2" => $html2,
            "html3" => $html3,
        ];

        return view('desk/pages/jobs/show', $data);
    }

}