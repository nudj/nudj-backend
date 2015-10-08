<?php

namespace App\Http\Controllers\Desk;


class DashboardController extends DeskController {



    public function index()
    {
        $sumInfo =[
            'users'=> \App\Models\User::select()->count(),
            'jobs' => \App\Models\Job::select()->count(),
        ];
        return view('desk/pages/dashboard',$sumInfo);
    }
}