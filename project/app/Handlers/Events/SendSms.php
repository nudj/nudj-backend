<?php namespace App\Handlers\Events;



use App\Events\LoginUserEvent;

class SendSms {


	public function __construct()
	{
		//
	}


	public function handle(LoginUserEvent $event)
	{
		// sends SMS
	}

}
