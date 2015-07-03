<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class StartChatEvent extends Event {

	use SerializesModels;


	public $chatId;
	public $initiatorId;
	public $interlocutorId;
	public $message;

	public function __construct($chatId, $initiatorId, $interlocutorId, $message = '')
	{
		$this->chatId = $chatId;
		$this->initiatorId = $initiatorId;
		$this->interlocutorId = $interlocutorId;
		$this->message = $message;
	}

}
