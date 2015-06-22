<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends ApiController
{

    public function send()
    {

        $user = User::find($this->authenticator->getUserId());

        $data = [
            'userId' => (int) $user->id,
            'userName' => (string) $user->name,
            'feedback' => (string) Input::get('feedback')
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
