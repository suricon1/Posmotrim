<?php

namespace App\Repositories;

//use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\Order as Model;

class OrderRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    public function get($id): Model
    {
        $order = $this->modelName()->find($id);
        if (!$order) {
            throw new \RuntimeException('Заказ не существует.');
        }
        return $order;
    }

    public function save(Model $order): void
    {
        if (!$order->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Model $order): void
    {
        if (!$order->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function isCompleted(Model $order): void
    {
        if ($order->isCompleted()) {
            throw new \RuntimeException('Заказ закрыт.');
        }
    }
//    public function get($id): Order
//    {
//        if (!$order = Order::find($id)) {
//            throw new \RuntimeException('Order is not found.');
//        }
//        return $order;
//    }
//
//    public function save(Order $order): void
//    {
//        if (!$order->save()) {
//            throw new \RuntimeException('Saving error.');
//        }
//    }
//
//    public function remove(Order $order): void
//    {
//        if (!$order->delete()) {
//            throw new \RuntimeException('Removing error.');
//        }
//    }
//
//    public function isCompleted(Order $order): void
//    {
//        if ($order->isCompleted()) {
//            throw new \RuntimeException('Заказ закрыт.');
//        }
//    }
}
