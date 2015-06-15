<?php namespace App\Http\Controllers\Admin;


class CommandsController extends AdminController {


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function composerUpdate()
    {
        set_time_limit(600);
        return $this->execAndReturn("sudo composer  --working-dir=../ update --no-dev");
    }

    private function execAndReturn($command)
    {
        exec($command, $output);
        return implode("<br>", $output);
    }

}
