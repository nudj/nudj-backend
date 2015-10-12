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
        $records = Job::findOrFail($id);
        $details = [
            "job" => $records,
            "user" => \App\Models\User::find($records->user_id)
        ];

        return view('desk/pages/jobs/show', $details);
    }
}