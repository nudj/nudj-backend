<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class NotifyUserEvent extends Event {

	use SerializesModels;

	public $recipientId = null;
	public $message = null;
	public $meta = [];

	public function __construct($recipientId, $message, $meta = [])
	{
		$this->recipientId = $recipientId;
		$this->message = $message;
		$this->meta = $meta;
	}
}
