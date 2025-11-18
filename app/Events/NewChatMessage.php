<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\ChatMessage;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        // Hum sirf saamne wale (Receiver) ke channel par bhejenge
        return [
            new PrivateChannel('chat.' . $this->message->incoming_msg_id),
        ];
    }

    /**
     * YEH IMPORTNT HAI: Is naam se hi JS mein sunna padega
     */
    public function broadcastAs()
    {
        return 'message.new';
    }

    public function broadcastWith(): array
    {
        $this->message->load(['sender', 'repliedTo.sender']);
        return ['message' => $this->message];
    }
}