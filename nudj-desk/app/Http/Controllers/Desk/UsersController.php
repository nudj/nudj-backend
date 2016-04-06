<?php

namespace App\Http\Controllers\Desk;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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

    public function ajax_update_user($id){
        $user = User::find($id);
        if (!$user){
            return '[false]';
        }

        $input = Input::all();

        if (isset($input['email']))
            $user->email = (string)$input['email'];

        if (isset($input['phone']))
            $user->phone = (string)$input['phone'];

        if (isset($input['country_code']))
            $user->country_code = (string)$input['country_code'];

        if (isset($input['name']))
            $user->name = (string)$input['name'];

        if (isset($input['position']))
            $user->position = (string)$input['position'];

        if (isset($input['address']))
            $user->address = (string)$input['address'];

        if (isset($input['company']))
            $user->company = (string)$input['company'];

        if (isset($input['about']))
            $user->about = $input['about'];

        if (isset($input['completed']))
            $user->completed = (string)$input['completed'];

        if (isset($input['status']))
            $user->status = (int)$input['status'];

        $user->save();

        return '[true]';
    }

}