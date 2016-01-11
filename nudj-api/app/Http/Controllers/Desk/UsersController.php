<?php

namespace App\Http\Controllers\Desk;

use App\Models\User;

class UsersController extends DeskController
{

    public function index()
    {
        return view('desk/pages/users/list');
    }

    public function show($id)
    {
        $records = User::findOrFail($id);

        $params = [
            "user" => $records,
            "jobs" => $records->jobs()->count(),
            "user_job" => \App\Models\Job::where('user_id', '=', $id)->get(),
            "applications" => \App\Models\Application::where('candidate_id', '=', $id)->get()
        ];

        return view('desk/pages/users/show', $params);
    }

}