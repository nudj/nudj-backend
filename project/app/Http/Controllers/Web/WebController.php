<?php namespace App\Http\Controllers\Web;


use App\Models\Country;

class WebController extends \Illuminate\Routing\Controller
{

    public function login()
    {
        $public = realpath(__DIR__.'/../../public');

        $data = [
            'countries' => Country::web()->get(),
            'user' => [
                'name' => 'Simo'
            ],
            'local_css' => $public.'/assets/web/css/theme.css',
            'title' => 'Login'
        ];
        return view('web/page/login', $data);
    }

    public function submit()
    {
        $public = realpath(__DIR__.'/../../public');

        $data = [
            'user' => [
                'phone' => ' +44 546546546'
            ],
            'local_css' => $public.'/assets/web/css/theme_submit.css',
            'title' => 'Submit'
        ];
        return view('web/page/submit',$data);
    }

    public function job()
    {
        $public = realpath(__DIR__.'/../../public');

        $data = [
            'user' => [
                'name' => 'Simo'
            ],
            'local_css' => $public.'/assets/web/css/theme_job.css',
            'title' => 'Job'
        ];
        return view('web/page/job',$data);
    }

}

