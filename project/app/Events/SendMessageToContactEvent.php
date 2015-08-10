<?php namespace App\Events;


use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class SendMessageToContactEvent extends Event {

	use SerializesModels;


	public $phone = null;
	public $message = null;

	public function __construct($userPhone, $message)
	{
		$this->phone = $userPhone;
		$this->message =  $message;
	}

}
