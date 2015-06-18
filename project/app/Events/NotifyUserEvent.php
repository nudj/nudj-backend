<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class NotifyUserEvent extends Event {

	use SerializesModels;

	public $recipientId = null;
	public $message = null;

	public function __construct($recipientId, $message)
	{
		$this->recipientId = $recipientId;
		$this->message = $message;
	}
}
