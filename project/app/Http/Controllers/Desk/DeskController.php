<?php

namespace App\Http\Controllers\Desk;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;

class DeskController extends \Illuminate\Routing\Controller {
    use DispatchesCommands, ValidatesRequests;


    public function __construct()
    {
        $this->middleware('desk');
    }

}