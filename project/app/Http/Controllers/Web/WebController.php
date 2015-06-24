<?php namespace App\Http\Controllers\Web;

use App\Models\Country;

class WebController extends \Illuminate\Routing\Controller
{

    public function login()
    {

        $data = [
            'countries' => Country::web()->get(),
            'user' => (object) [
                'name' => 'Simo'
            ]
        ];

        return view('web/page/login', $data);
    }

    public function submit()
    {

        $data = [
            'user' => (object) [
                'phone' => ' +44 546546546'
            ],
        ];

        return view('web/page/submit',$data);
    }

    public function job()
    {

        $data = [
            'user' => [
                'name' => 'Simo'
            ]
        ];
        return view('web/page/job',$data);
    }

}

