<?php

namespace App\Repositories;

use App\Models\Vinograd\Order\Order;

class OrderRepository
{
    public function get($id): Order
    {
        if (!$order = Order::find($id)) {
            throw new \RuntimeException('Order is not found.');
        }
        return $order;
    }

    public function save(Order $order): void
    {
        if (!$order->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Order $order): void
    {
        if (!$order->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function isCompleted(Order $order): void
    {
        if ($order->isCompleted()) {
            throw new \RuntimeException('Заказ закрыт.');
        }
    }
}
