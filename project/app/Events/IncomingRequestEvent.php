<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class IncomingRequestEvent extends Event {

	use SerializesModels;

	public $authenticator;

	public function __construct($authenticator = null) {
		$this->authenticator = $authenticator;
	}

}
