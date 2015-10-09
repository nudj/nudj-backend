<?php

namespace App\Http\Controllers\Desk;


use App\Models\Admin;
use Illuminate\Http\Request;
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

    public function update($id, AdminUpdateRequest $request)
    {

//        var_dump($request);die();

        $record = Admin::findOrFail($id);

        $record->edit($request->all());

        return redirect('/admins/'. $id)->with('status', $record->email);
    }
}