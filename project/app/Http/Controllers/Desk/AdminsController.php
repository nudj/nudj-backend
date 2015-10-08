<?php

namespace App\Http\Controllers\Desk;


use App\Models\Admin;

class AdminsController extends DeskController
{


    public function index()
    {
        return view('desk/pages/admins/list');
    }

    public function show($id)
    {
        $records = Admin::findOrFail($id);

        return view('desk/pages/admins/show', $records);
    }
}