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

        return view('desk/pages/users/show', $records);
    }
}