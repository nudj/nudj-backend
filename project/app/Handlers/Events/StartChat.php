<?php namespace App\Handlers\Events;


use App\Events\StartChatEvent;
use App\Models\User;

use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Protocol\Message;
use Fabiang\Xmpp\Protocol\Presence;
use GameNet\Jabber\RpcClient;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Log;

use Illuminate\Support\Facades\Config;


class StartChat implements ShouldBeQueued
{


    public function handle(StartChatEvent $event)
    {

        $initiator = User::findOrFail($event->initiatorId);
        $initiatorUsername = $initiator->id . '@chat.nudj.co';
        $interlocutorUsername = $event->interlocutorId . '@chat.nudj.co'; // WTF! (lacho)

	    Log::info('Chat Creation started: '. $initiatorUsername . ' :: ' . $interlocutorUsername);

        // Create room and invite people
        $rpc = new RpcClient([
            'server' => Config::get('cfg.chat_server_ip'),
            'host' => Config::get('cfg.chat_server_host'),
            'debug' => false,
        ]);

	    Log::info('RPC connection to the server established');

        $createRoomStatus = $rpc->createRoom((string) $event->chatId);

	    Log::info('Room Created: ' . $createRoomStatus);

        $inviteStatus = $rpc->inviteToRoom($event->chatId, null, null, [$initiatorUsername, $interlocutorUsername]);
	    Log::info('Invite Created: ' . $inviteStatus);

        // Connect trough XMPP
        $options = new Options(Config::get('cfg.chat_server_tcp'));
        $options->setUsername($initiator->id)
            ->setPassword($initiator->token)
            ->setLogger(Log::getMonolog());

        $client = new Client($options);
        $client->connect();

        // Join the room
        $roomFullName = $event->chatId . Config::get('cfg.chat_conference_domain');

	    Log::info('RPC connection to the server established');

        $channel = new Presence;
        $channel->setTo($roomFullName)
            ->setNickName($initiatorUsername);
        $client->send($channel);

	    Log::info('Joined the room: ' . $roomFullName);

        // Write your message
        $message = new Message;
        $message->setMessage($event->message)
            ->setTo($roomFullName)
            ->setType(Message::TYPE_GROUPCHAT);
        $client->send($message);

	    Log::info('Sent Message: ' . $message);

        // Bye bye
        $client->disconnect();
    }

}
