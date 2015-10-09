<?php

namespace App\Http\Controllers\Desk;


use App\Models\Admin;
use App\Http\Requests\Desk\AdminCreateRequest;
use App\Http\Requests\Desk\AdminUpdateRequest;

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

    public function create()
    {
        return view('desk/pages/admins/create');
    }


    public function store(AdminCreateRequest $request)
    {
        $newAdmin = Admin::add($request);

        return redirect('/admins/create')->with('status', $newAdmin->email);
    }

    public function update($id, AdminUpdateRequest $request)
    {

        $record = Admin::findOrFail($id);

        $record->edit($request->all());

        return redirect('/admins/'. $id)->with('status', $record->email);
    }
}