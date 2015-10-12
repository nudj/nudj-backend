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

        switch ($who){
            case "users":
                         $data = DB::table($who)
                            ->leftJoin('jobs', 'users.id', '=', 'jobs.user_id')
                            ->select(DB::raw('users.*, count(jobs.id) as jobs'))
                            ->groupBy('users.id');
                         break;
            default :
                     $data = DB::table($who)->select();
                     break;
        }


        return Datatables::of($data)->make(true);
    }


}