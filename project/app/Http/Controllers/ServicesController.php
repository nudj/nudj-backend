<?php namespace App\Http\Controllers;


use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\CloudHelper;
use App\Utility\Facades\Shield;
use Davibennun\LaravelPushNotification\PushNotification;
use Illuminate\Support\Facades\Config;

use App\Models\User;

use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Protocol\Message;
use Fabiang\Xmpp\Protocol\Presence;
use GameNet\Jabber\RpcClient;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Log;

class ServicesController extends ApiController
{


    public function clean()
    {
        if (!Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

    }


    public function test()
    {


		$notifier = new PushNotification();
		$notifier->app('NudgeIOS')
			->to('7fa239ee5afa03d1951e6e1081769b20ba1dc0a85002101ecc1b61a47db1fbcf')
			->send('message');


    }

	public function message() {
// Connect trough XMPP
		Log::info('Start Sending: 3');

		$initiator = User::findOrFail("3");
		$initiatorUsername = "3" . '@chat.nudj.co';
		$interlocutorUsername = "5" . '@chat.nudj.co';

		$options = new Options(Config::get('cfg.chat_server_tcp'));
		$options->setUsername($initiator->id)
			->setPassword($initiator->token)
			->setLogger(Log::getMonolog());

		$client = new Client($options);
		$client->connect();

		// Join the room
		$roomFullName = '65' . Config::get('cfg.chat_conference_domain');

		$channel = new Presence;
		$channel->setTo($roomFullName)
			->setNickName('System');
		$client->send($channel);

		$messageText = "Test Message: " . rand(1, PHP_INT_MAX);

		// Write your message
		$message = new Message;
		$message->setMessage($messageText)
			->setTo($roomFullName)
			->setType(Message::TYPE_GROUPCHAT);
		$client->send($message);

		Log::info('Sent Group Message: ' . $messageText);

		// Bye bye
		$client->disconnect();
	}





}
