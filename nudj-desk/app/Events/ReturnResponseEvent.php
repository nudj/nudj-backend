<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class ReturnResponseEvent extends Event {

	use SerializesModels;

	public $response;

	public function __construct($response) {
		$this->response = $response;
	}

}
