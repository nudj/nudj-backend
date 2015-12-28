<?php namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class LoginUserEvent extends Event {

	use SerializesModels;

	public $phone = null;
	public $message = null;
	public $countryCode = null;

	public function __construct($userPhone, $countryCode, $verificationCode)
	{
		$this->phone = $userPhone;
		$this->countryCode = $countryCode;
		$this->message =  Lang::get('sms.verification', [
			'code' => $verificationCode
		]);
	}

}
