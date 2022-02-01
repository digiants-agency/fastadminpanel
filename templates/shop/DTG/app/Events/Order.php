<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Order
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $order_products;

    public function __construct($order, $order_products)
    {
        $this->order = $order;
        $this->order_products = $order_products;
    }
    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

}
