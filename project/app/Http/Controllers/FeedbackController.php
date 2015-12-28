<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Utility\Facades\Shield;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

class FeedbackController extends ApiController
{

    public function send()
    {
        $user = User::find(Shield::getUserId());

        $data = [
            'userId' => (int) $user->id,
            'userName' => (string) $user->name,
            'feedback' => (string) Request::get('feedback')
        ];

        Mail::queue('emails.feedback', $data, function($message)
        {
            $message->from(Config::get('cfg.email_system'));
            $message->to(Config::get('cfg.email_feedback'));
            $message->subject('New Feedback!');
        });

        return $this->respondWithStatus(true);
    }

}
