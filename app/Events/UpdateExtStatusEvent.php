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
class UpdateExtStatusEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    public $message;

    /**
     * Create a new event instance.
     *
     * @param $ext 内線番号
     * @param $status 状態
     */
    public function __construct($ext, $status)
    {

        $message = \App\Message::create([
            'message' => json_encode([
                'type' => 'UpdateExtStatus',
                'ExtNo' => $ext,
                'ExtStatus' => $status
            ]),
        ]);

        $this->message = $message;

        \Redis::SET('extStatus:' . $ext, $status);

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('BroadcastChannel');
    }
}
