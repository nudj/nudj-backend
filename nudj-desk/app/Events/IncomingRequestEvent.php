<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class IncomingRequestEvent extends Event {

	use SerializesModels;

}
