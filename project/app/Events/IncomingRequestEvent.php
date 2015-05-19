<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class IncomingRequestEvent extends Event {

	use SerializesModels;

	public $name;
	public $data;

	public function __construct($name, $data = [])
	{
		$this->name = $name;
		$this->data = $data;
	}

}
