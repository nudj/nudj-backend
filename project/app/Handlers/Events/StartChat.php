<?php namespace App\Handlers\Events;


use App\Events\StartChatEvent;
use App\Models\User;

use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Protocol\Message;
use Fabiang\Xmpp\Protocol\Presence;
use GameNet\Jabber\RpcClient;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Illuminate\Support\Facades\Config;


class StartChat implements ShouldBeQueued
{


    public function handle(StartChatEvent $event)
    {

        $initiator = User::findOrFail($event->initiatorId);
        $initiatorUsername = $initiator->id . '@chat.nudj.co';
        $interlocutorUsername = $event->interlocutorId . '@chat.nudj.co';

        // Create room and invite people
        $rpc = new RpcClient([
            'server' => Config::get('cfg.chat_server_ip'),
            'host' => Config::get('cfg.chat_server_host'),
            'debug' => false,
        ]);

        $rpc->createRoom((string) $event->chatId);
        $rpc->inviteToRoom($event->chatId, null, null, [$initiatorUsername, $interlocutorUsername]);


        // Connect trough XMPP
        $options = new Options(Config::get('cfg.chat_server_tcp'));
        $options->setUsername($initiator->id)
            ->setPassword($initiator->token);

        $client = new Client($options);
        $client->connect();


        // Join the room
        $roomFullName = $event->chatId . Config::get('cfg.chat_conference_domain');

        $channel = new Presence;
        $channel->setTo($roomFullName)
            ->setNickName($initiatorUsername);
        $client->send($channel);

        // Write your message
        $message = new Message;
        $message->setMessage($event->message)
            ->setTo($roomFullName)
            ->setType(Message::TYPE_GROUPCHAT);
        $client->send($message);


        // Bye bye
        $client->disconnect();
    }

}
