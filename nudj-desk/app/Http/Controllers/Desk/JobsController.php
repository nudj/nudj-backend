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
        $active_referrers_number = \App\NSX300\NSX300_Nudges::number_of_distinct_referrals_contacting_candidates_for_job_id($job->id);

        $data = [
            "job"  => $job,
            "user" => $user,
            "active_referrers_number" => $active_referrers_number
        ];

        return view('desk/pages/jobs/show', $data);
    }

}