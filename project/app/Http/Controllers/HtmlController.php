<?php namespace App\Http\Controllers;


class HtmlController extends \Illuminate\Routing\Controller
{

    public function terms()
    {
        return view('html/terms');
    }
    public function privacy()
    {
        return view('html/privacy');
    }
    public function cookies()
    {
        return view('html/cookies');
    }

}
