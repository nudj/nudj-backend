<?php

namespace App\Http\Controllers\Desk;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class DeskController extends \Illuminate\Routing\Controller {
    use DispatchesCommands, ValidatesRequests;


    public function __construct()
    {
        $this->middleware('desk');
    }

    public function tableData($who)
    {
        $data = DB::table($who)->select();

        return Datatables::of($data)->make(true);
    }


}