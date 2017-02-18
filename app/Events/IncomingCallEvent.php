<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 内線状態の更新
 * Class UpdateExtStatusEvent
 * @package App\Events
 */
class IncomingCallEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    public $message;

    /**
     * Create a new event instance.
     *
     * @param $ext 着信先
     * @param $number 番号
     * @param $displayName 名称
     */
    public function __construct($ext, $number, $displayName)
    {

        // ToDo: ユーザIDの取得
        $message = \App\Message::create([
            'to_user_id' => 2,
            'message' => json_encode([
                'type' => 'IncomingCall',
                'Number' => $number,
                'DisplayName' => $displayName
            ]),
        ]);

        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('PrivateChannel.' . $this->message->to_user_id);
    }
}
