<?php namespace App\Http\Controllers;


use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\CloudHelper;
use App\Utility\Facades\Shield;
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

        $cloudHelper = new CloudHelper(Config::get('cfg.rackspace'));

        $cloudHelper->emptyContainer('UserImage/2');

//        $logs = Log::orderBy('id', 'asc')->take(10)->get();
//
//        foreach($logs as $log) {
//            echo $log->display() . "\n";
//        }

    }

	public function message() {
// Connect trough XMPP
//		$initiator = User::findOrFail("3");

		$options = new Options(Config::get('cfg.chat_server_tcp'));
		$options->setUsername("3")
			->setPassword("CO74MZZtmGdM7ygUj0alJ5JZphwppsBWQKtRyPC3ArG8nVJQxPcDQfsuWJjy")
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
