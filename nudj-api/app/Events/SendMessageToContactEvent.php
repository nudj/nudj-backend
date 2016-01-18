<?php namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

use Log;

class SendMessageToContactEvent extends Event {

	use SerializesModels;

	public $phone = null;
	public $message = null;
	public $countryCode = null;

	public function __construct($userPhone, $countryCode, $message)
	{
		$this->phone = $userPhone;
		$this->countryCode = $countryCode;
		$this->message =  $message;
	}

}
