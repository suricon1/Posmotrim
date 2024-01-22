<?php

namespace App\UseCases;

use App\Models\Vinograd\Order\Order;
use App\Repositories\ModificationRepository;
use App\Repositories\OrderRepository;
use App\Status\Status;
use DB;

class StatusService
{
    private $orders;
    private $modifications;

    public function __construct
    (
        OrderRepository $orders,
        ModificationRepository $modifications
    )
    {
        $this->orders = $orders;
        $this->modifications = $modifications;
    }

    public function setStatus($order_id, $status, $track_code = null)
    {
        return DB::transaction(function () use ($order_id, $status, $track_code)
        {
            $order = Order::with('items')->find($order_id);
            $order->statuses->transitionTo(Status::createStatus((int) $status, $order));
            $order->setTrackCode($track_code);
            $this->orders->save($order);
        });
    }

    public function setPrintStatus($order_id)
    {
        return DB::transaction(function () use ($order_id)
        {
            $order = Order::find($order_id);
            if ($order->isNew() || $order->isPaid()) {
                $this->setStatus($order->id, Status::FORMED);
            }
        });

    }

    public function remove($order)
    {
        if ($order->isCompleted() || $order->isPreliminsry() || $order->isCancelled() || $order->isCancelledByCustomer()){
            return;
        }
        $this->returnQuantity($order);
        $this->returnInStock($order);
    }

    public function returnQuantity($order)
    {
        foreach ($order->items as $item){
            $item->modification->returnQuantity($item->quantity);
            $this->modifications->save($item->modification);
        }
    }

    public function checkoutQuantity($order)
    {
        foreach ($order->items as $item){
            $item->modification->checkout($item->quantity, true);
            $this->modifications->save($item->modification);
        }
    }

    public function returnInStock ($order)
    {
        $flag = array_filter($order->statuses_json, function($ar) {
            return $ar['value'] == Status::PAID OR $ar['value'] == Status::SENT;
        });
        if($flag){
            foreach ($order->items as $item){
                $item->modification->returnInStock($item->quantity);
                $this->modifications->save($item->modification);
            }
        }
    }

    public function checkoutInStock($order)
    {
        $flag = array_filter($order->statuses_json, function($ar) use ($order) {
            return $ar['value'] !== $order->current_status AND in_array($ar['value'], Order::SOLD_LIST);
        });
        if(!$flag){
            foreach ($order->items as $item){
                $item->modification->checkoutInStock($item->quantity);
                $this->modifications->save($item->modification);
            }
        }
    }
}
