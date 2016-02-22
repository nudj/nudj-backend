<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Utility\Facades\Shield;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

class AbuseController extends ApiController
{

    public function send()
    {
        $user = User::find(Shield::getUserId());

        $data = [
            'userId'   => (int) $user->id,
            'userName' => (string) $user->name,
            'abuse'    => (string) Request::get('abuse')
        ];

        Mail::send('emails.abuse', $data, function($message)
        {
            $message->from(Config::get('cfg.email_system'));
            $message->to(Config::get('cfg.email_abuse'));
            $message->subject('New Abuse!');
        });

        return $this->respondWithStatus(true);
    }

}
