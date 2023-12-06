<?php

namespace App\UseCases;

use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\Status;
use App\Repositories\ItemRepository;
use App\Repositories\ModificationRepository;
use App\Repositories\OrderRepository;
use DB;
use Illuminate\Support\Facades\Redirect;

class StatusService
{
    private $orders;
    private $items;
    private $modifications;

    public function __construct
    (
        OrderRepository $orders,
        ItemRepository $items,
        ModificationRepository $modifications
    )
    {
        $this->orders = $orders;
        $this->items = $items;
        $this->modifications = $modifications;
    }

    public function setStatus($order_id, $status, $track_code = null)
    {
        return DB::transaction(function () use ($order_id, $status, $track_code)
        {
            $order = Order::find($order_id);
            if ($status == $order->current_status) {
                throw new \RuntimeException('Этот статус уже установлен!');
            }
            $statusList = OrderService::getOrderStasusesList($order);
            if(!$statusList || !array_key_exists($status, $statusList)) {
                throw new \RuntimeException('Статус не пригоден для этого заказа!');
            }
            $order->addStatus($status);
            $order->setTrackCode($track_code);
            $this->orders->save($order);

            if ($order->isCancelled() || $order->isCancelledByCustomer()) {
                $this->returnQuantity($order);
                $this->returnInStock($order);
            }
            if ($order->isPaid() || $order->isSent() || $order->isCompleted()) {
                $this->checkoutInStock($order);
            }
            if ($order->isNew()) {
                $this->checkoutQuantity($order);
            }
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

    private function returnQuantity($order)
    {
        foreach ($order->items as $item){
            $item->modification->returnQuantity($item->quantity);
            $this->modifications->save($item->modification);
        }
    }

    private function checkoutQuantity($order)
    {
        foreach ($order->items as $item){
            $item->modification->checkout($item->quantity, true);
            $this->modifications->save($item->modification);
        }
    }

    private function returnInStock ($order)
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

    private function checkoutInStock($order)
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
