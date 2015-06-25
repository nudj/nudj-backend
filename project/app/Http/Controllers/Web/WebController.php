<?php namespace App\Http\Controllers\Web;

use App\Models\Country;
use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Facades\Request;

class WebController extends \Illuminate\Routing\Controller
{

    public function login()
    {

        $data = [
            'countries' => Country::web()->get(),
            'user' => (object) [
                'name' => 'Simo'
            ],
            'job' => (object)[
                'id' => ''
            ]
        ];

        return view('web/page/login', $data);
    }

    public function submit()
    {
        $from_login = (object)Request::all();

        $searchUser = $from_login->code . $from_login->mobile;

        $this_user = User::login(array('phone' =>   $searchUser));

        $data = [
            'user' => (object) [
                'phone' => $this_user->phone,
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
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'skills' => (object)[
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

