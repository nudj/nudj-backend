<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class LoginUserEvent extends Event {

	use SerializesModels;


	public $userPhone = null;
	public $verificationCode = null;

	public function __construct($userPhone, $verificationCode)
	{
		$this->userPhone = $userPhone;
		$this->verificationCode = $verificationCode;
	}

}
