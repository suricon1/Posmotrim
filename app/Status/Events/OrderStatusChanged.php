<?php

namespace App\Status\Events;

use App\Models\Vinograd\Order\Order;
use App\Status\OrderState;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $old;
    public $current;

    public function __construct(Order $order, OrderState $old, OrderState $current)
    {
        $this->order = $order;
        $this->old = $old;
        $this->current = $current;
    }
}
