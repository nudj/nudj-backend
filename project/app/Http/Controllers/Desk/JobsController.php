<?php

namespace App\Http\Controllers\Desk;


use App\Models\Job;
use Illuminate\Support\Facades\DB;

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
            "user" => DB::table('users')->whereId( $records->user_id)->first()
        ];

        return view('desk/pages/jobs/show', $details);
    }
}