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

        $initiatorUsername = $this->returnUsername($initiator->id);
        $interlocutorUsername = $this->returnUsername($event->interlocutorId);
        $sysUsername = $this->returnUsername(config('cfg.sys_id'));


        // Create room and invite people
        $rpc = new RpcClient([
            'server' => Config::get('cfg.chat_server_ip'),
            'host' => Config::get('cfg.chat_server_host'),
            'debug' => false,
        ]);


        $rpc->createRoom((string) $event->chatId);
        $rpc->inviteToRoom($event->chatId, null, null, [$initiatorUsername, $interlocutorUsername, $sysUsername]);

        if($event->message)
            $this->sendInitialMessage($event);

    }

    private function sendInitialMessage(StartChatEvent $event)
    {

        // Connect trough XMPP
        $options = new Options(Config::get('cfg.chat_server_tcp'));

        //$options->setUsername($initiator->id)
        //->setPassword($initiator->token)

        $options->setUsername(config('cfg.sys_id'))
            ->setPassword(config('cfg.sys_token'));

        $client = new Client($options);
        $client->connect();

        // Join the room
        $roomFullName = $event->chatId . config('cfg.chat_conference_domain');

        $channel = new Presence;
        $channel->setTo($roomFullName)
            ->setNickName(config('cfg.sys_name'));

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

    private function returnUsername($id)
    {
        return $id . config('cfg.chat_server_at');
    }

}
