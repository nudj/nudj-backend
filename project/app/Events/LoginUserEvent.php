<?php namespace App\Events;


use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class LoginUserEvent extends Event {

	use SerializesModels;


	public $phone = null;
	public $message = null;

	public function __construct($userPhone, $verificationCode)
	{
		$this->phone = $userPhone;
		$this->message =  Lang::get('messages.verificationSMS', [
			'code' => $verificationCode
		]);
	}

}
