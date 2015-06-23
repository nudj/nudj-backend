<?php namespace App\Http\Controllers\Web;


use App\Models\Country;

class WebController extends \Illuminate\Routing\Controller
{


    public function login()
    {

        $data = [
            'countries' => Country::web()->get(),
            'user' => [
                'name' => 'Simo'
            ]
        ];

        return view('web/page/login', $data);
    }

    public function submit()
    {
        return view('web/page/submit');
    }

}
