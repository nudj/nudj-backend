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
            ],
            'job'  => (object) [
                'title' => 'UX Designer (Permanent)',
                'from'  => 'Jeremy Garza',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'tags' => [
                    'Photoshop','Corel Draw'
                ],
                'employer' => 'Digitalz',
                'location' =>(object)[
                    'name' => 'London',
                    'lat'  => '51.508742',
                    'lon'  => '-0.11055'
                ],
                'salary' => '25K - 35K',
                'status' => 1
            ]
        ];
        return view('web/page/job',$data);
    }

}

