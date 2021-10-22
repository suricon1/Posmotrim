<?php

namespace App\UseCases;

use App\cart\Cart;
use App\Mail\Admin\OrderAddMail;
use App\Models\Vinograd\Modification;
use App\Models\Vinograd\Order\CustomerData;
use App\Models\Vinograd\Order\DeliveryData;
use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\OrderItem;
use App\Models\Vinograd\Order\Status;
use App\Notifications\OrderCustomerMail;
use App\Notifications\OrderReplyCustomerMail;
use App\Notifications\SendCodeMail;
use App\Repositories\DeliveryMethodRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Auth;
use DB;
use Illuminate\Http\Request;
use Mail;

class OrderService
{
    private $cart;
    private $orders;
    private $products;
    private $users;
    private $deliveryMethods;

    public function __construct(
        Cart $cart,
        OrderRepository $orders,
        ProductRepository $products,
        UserRepository $users,
        DeliveryMethodRepository $deliveryMethods
    )
    {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->products = $products;
        $this->users = $users;
        $this->deliveryMethods = $deliveryMethods;
    }

    public function createNewOrder($status = Status::NEW)
    {
        $order = Order::create(
            Auth::id(),
            new DeliveryData(
                $this->deliveryMethods->get(1)
             ),
            new CustomerData(),
            0,
            null,
            $status
        );
        $order->save();
        return $order;
    }

    public function checkout($request): Order
    {
        return DB::transaction(function() use ($request)
        {
            $user_id = (Auth::check()) ? Auth::id() : null;
            $delivery = $this->deliveryMethods->get($request->input('delivery.method'));

            $order = Order::create(
                $user_id,
                new DeliveryData(
                    $delivery,
                    $request->input('delivery.index'),
                    $request->input('delivery.address')
                ),
                new CustomerData(
                    //$this->orders->formatPhone($request->input('customer.phone')),
                    $request->input('customer.phone'),
                    $request->input('customer.name'),
                    $request->input('customer.email')
                ),
                $this->cart->getCost()->getTotal(),
                $request->note,
                Status::NEW
            );
            $this->orders->save($order);

            foreach ($this->cart->getItems() as $item)
            {
                $modification = $item->getModification();
                $modification->checkout($item->getQuantity(), false);
                if (!$modification->save()) {
                    throw new \RuntimeException('Saving error.');
                }

                $orderItem = OrderItem::create(
                    $order->id,
                    $modification,
                    $item->getPrice(),
                    $item->getQuantity()
                );
                if (!$orderItem->save()) {
                    throw new \RuntimeException('Saving error.');
                }
            }

            $this->cart->clear();
            return $order;
        });
    }

    public function addItem(Request $request, $order_id, $pre = false)
    {
        return DB::transaction(function() use ($request, $order_id, $pre)
        {
            $order = Order::with('items')->find($order_id);
            $modification = Modification::with('product')->find($request->modification_id);

            $modification->checkout($request->quantity, $pre);
            if (!$modification->save()) {
                throw new \RuntimeException('Saving error.');
            }

            $order->cost += $request->quantity * $modification->price;
            $this->orders->save($order);

            //  Добавляем уже имеющийся продукт
            foreach ($order->items as $item){
                if($item->modification_id == $modification->id){
                    $item->quantity += $request->quantity;
                    if (!$item->save()) {
                        throw new \RuntimeException('Saving error.');
                    }
                    return;
                }
            }

            //  Добавляем новый продукт
            $orderItem = OrderItem::create(
                $order->id,
                $modification,
                $modification->price,
                $request->quantity
            );
            if (!$orderItem->save()) {
                throw new \RuntimeException('Saving error.');
            }
        });
    }

    public function updateItem(Request $request, $order_id, $pre = false)
    {
        return DB::transaction(function() use ($request, $order_id, $pre)
        {
            $order = Order::with('items')->find($order_id);
            foreach ($order->items as $item){
                if($item->id == $request->item_id){
                    if ($item->quantity == $request->quantity){
                        return;
                    }

                    //  Уменьшаем
                    if ($item->quantity > $request->quantity){
                        $item->modification->returnQuantity($item->quantity - $request->quantity);
                    }
                    //  Добавляем
                    elseif($item->quantity < $request->quantity){
                        $item->modification->checkout($request->quantity - $item->quantity, $pre);
                    }

                    $item->quantity = $request->quantity;

                    if (!$item->modification->save()) {
                        throw new \RuntimeException('Saving error.');
                    }
                    if (!$item->save()) {
                        throw new \RuntimeException('Saving error.');
                    }
                    return $this->newOrderCost($order, 0);
                }
            }
        });
    }

    public function deleteItem(Request $request, $order_id)
    {
        return DB::transaction(function() use ($request, $order_id)
        {
            $order = Order::with('items')->find($order_id);
            foreach ($order->items as $item){
                if($item->id == $request->item_id){
                    $item->modification->returnQuantity($item->quantity);
                    if (!$item->modification->save()) {
                        throw new \RuntimeException('Saving error.');
                    }
                    $item->delete();
                    return $this->newOrderCost($order, $request->item_id);
                }
            }
        });
    }

    private function newOrderCost($order, $item_id)
    {
        $order->cost = array_sum(array_map(function ($item) use($item_id) {
            if ($item['id'] == $item_id) return 0;
            return $item['price'] * $item['quantity'];
        }, $order->items->toArray()));

        //  Удалить заказ при отсутствии товаров
//        if ($order->cost == 0){
//            $order->delete();
//            return false;
//        }

        $this->orders->save($order);
        return true;
    }

    public function deliveryUpdate(Request $request, $order)
    {
        $delivery = $this->deliveryMethods->get($request->input('delivery.method'));

        $order->delivery = new DeliveryData(
            $delivery,
            ($request->has('delivery.index')) ? $request->input('delivery.index') : $order->delivery['index'],
            ($request->has('delivery.address')) ? $request->input('delivery.address') : $order->delivery['address']
        );
        $order->customer = new CustomerData(
            $request->input('customer.phone'),
            //$this->orders->formatPhone($request->input('customer.phone')),
            $request->input('customer.name'),
            $request->input('customer.email')
        );
        $this->orders->save($order);
    }

    public function adminNoteEdit(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $order->admin_note = $request->admin_note;
        $this->orders->save($order);
    }

    public function sendMail($order)
    {
        Mail::to(config('main.admin_email'))->send(new OrderAddMail($order));

        if($order->customer['email']) {
            $order->notify(new OrderCustomerMail($order));
        }
    }

    public function sendCodeMail($order, $code)
    {
        if($order->customer['email']) {
            $order->notify(new SendCodeMail($order, $code));
        }
    }

    public function sendReplyMail(Order $order, Request $request)
    {
        return $order->notify(new OrderReplyCustomerMail($order, $request));
    }

    public static function getOrderStasusesList($order)
    {
        if ($order->isCancelled() || $order->isCancelledByCustomer() || $order->isCompleted()){
            return null;
        }

        $array = $order::statusList();
        unset($array[Status::CANCELLED_BY_CUSTOMER]);
        foreach ($order->statuses_json as $item){
            if(array_key_exists($item['value'], $array)){
                unset($array[$item['value']]);
            }
        }
        return $array;
    }

    public static function setStatus($order_id, $status, $track_code = null)
    {
        $order = Order::find($order_id);
        $order->addStatus($status);
        $order->setTrackCode($track_code);
        $order->save();

        if ($order->isCancelled() || $order->isCancelledByCustomer()) {
            self::returnQuantity($order);
        }
    }

    public function setTrackCode($order_id, $track_code)
    {
        $order = Order::find($order_id);
        $order->setTrackCode($track_code);
        $order->save();
    }

    public static function returnQuantity($order)
    {
        foreach ($order->items as $item){
            $modification = Modification::find($item->modification_id);
            $modification->returnQuantity($item->quantity);
            $modification->save();
        }
    }
}