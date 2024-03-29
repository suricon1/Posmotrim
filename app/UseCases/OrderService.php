<?php

namespace App\UseCases;

use App\cart\Cart;
use App\Mail\Admin\OrderAddMail;
use App\Models\Vinograd\Modification;
use App\Models\Vinograd\Order\CustomerData;
use App\Models\Vinograd\Order\DeliveryData;
use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\OrderCorrespondence;
use App\Models\Vinograd\Order\OrderItem;
use App\Status\Status;
use App\Notifications\OrderCustomerMail;
use App\Notifications\OrderReplyCustomerMail;
use App\Notifications\SendCodeMail;
use App\Repositories\CorrespondenceRepository;
use App\Repositories\ItemRepository;
use App\Repositories\ModificationRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    private $cart;
    private $orders;
    private $statusService;
    private $items;
    private $modifications;
    private $correspondence;

    public function __construct(
        Cart $cart,
        OrderRepository $orders,
        StatusService $statusService,
        ItemRepository $items,
        ModificationRepository $modifications,
        CorrespondenceRepository $correspondence
    )
    {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->statusService = $statusService;
        $this->items = $items;
        $this->modifications = $modifications;
        $this->correspondence = $correspondence;
    }

    public function createNewOrder($status = Status::NEW)
    {
        $order = Order::create(
            Auth::id(),
            new DeliveryData(),
            new CustomerData(),
            0,
            null,
            $status
        );
        $order->save();
        return $order;
    }

    public function remove ($id)
    {
        $order = $this->orders->get($id);
        return DB::transaction(function() use ($order)
        {
            $this->statusService->remove($order);
            foreach ($order->items as $item) {
                $this->items->remove($item);
            }
            foreach ($order->correspondences as $correspondence) {
                $this->correspondence->remove($correspondence);
            }
            $this->orders->remove($order);
        });
    }

    public function mergeOrders($order_id, $merge_order_id)
    {
        $order = $this->orders->get($order_id);
        $merge_orders = $this->orders->get($merge_order_id);
        foreach ($merge_orders->items as $item){
            $res = null;
            foreach ($order->items as $order_item){
                if ($item->product_id == $order_item->product_id AND $item->modification_id == $order_item->modification_id){
                    $order_item->quantity += $item->quantity;
                    $res = $order_item;
                    break;
                } else {
                    $item->order_id = $order_id;
                    $res = $item;
                }
            }
            $this->items->save($res);
        }
        $this->remove($merge_order_id);
        $order = $this->orders->get($order_id);
        $this->newOrderCost($order, 0);
    }

    public function createRepeatOrder($id)
    {
        return DB::transaction(function() use ($id)
        {
            $rep_order = $this->orders->get($id);
            $new_order = $this->createNewOrder();

            $new_order->delivery = $rep_order->delivery;
            $new_order->customer = $rep_order->customer;
            $this->orders->save($new_order);
            return $new_order->id;
        });
    }

    private function newDeliveryData($request)
    {
        $per = new DeliveryData($request->input('delivery.method'));
        $per->setAddress($request->input('delivery.index'), $request->input('delivery.address'));
        $per->setWeight($this->cart->getWeight());
        return $per;
    }

    private function setDeliveryData($order)
    {
        $order = $this->orders->get($order->id);
        $per = new DeliveryData($order->delivery['method_id']);
        $per->setAddress($order->delivery['index'], $order->delivery['address']);
        $per->setWeight($order->getWeight());
        return $per;
    }

    private function updateDeliveryData($request, $order)
    {
        $delivery = new DeliveryData($request->input('delivery.method'));
        $delivery->setAddress(
            ($request->has('delivery.index')) ? $request->input('delivery.index') : $order->delivery['index'],
            ($request->has('delivery.address')) ? $request->input('delivery.address') : $order->delivery['address']
        );
        $delivery->setWeight($order->getWeight());
        return $delivery;
    }

    public function checkout($request): Order
    {
        return DB::transaction(function() use ($request)
        {
            $user_id = (Auth::check()) ? Auth::id() : null;
            $order = Order::create(
                $user_id,
                $this->newDeliveryData($request),
                new CustomerData(
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
                $modification = Modification::find($item->getModificationId());
                $modification->checkout($item->getQuantity(), false);
                $this->modifications->save($modification);

                $orderItem = OrderItem::create(
                    $order->id,
                    $modification,
                    $item->getPrice(),
                    $item->getQuantity()
                );
                $this->items->save($orderItem);
            }

            $this->cart->clear();
            return $order;
        });
    }

    public function addItem(Request $request, $order_id, $pre = false)
    {
        return DB::transaction(function() use ($request, $order_id, $pre)
        {
            $order = $this->orders->get($order_id);
            $modification = Modification::with('product')->find($request->modification_id);
            if(!$pre){
                $modification->checkout($request->quantity, false);
                $this->modifications->save($modification);
            }

            $order->cost += $request->quantity * $modification->price;

            $this->_addItems($order, $modification, $request);

            $order->delivery = $this->setDeliveryData($order);
            $this->orders->save($order);
        });
    }

    private function _addItems($order, $modification, $request)
    {
        //  Добавляем уже имеющийся продукт
        foreach ($order->items as $item){
            if($item->modification_id == $modification->id){
                $item->quantity += $request->quantity;
                $this->items->save($item);
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
        $this->items->save($orderItem);
    }

    public function updateItem(Request $request, $order_id, $pre = false)
    {
        return DB::transaction(function() use ($request, $order_id, $pre)
        {
            $order = $this->orders->get($order_id);
            foreach ($order->items as $item){
                if($item->id == $request->item_id){
                    if ($item->quantity == $request->quantity){
                        return;
                    }

                    if(!$pre) {
                        //  Уменьшаем
                        if ($item->quantity > $request->quantity) {
                            $item->modification->returnQuantity($item->quantity - $request->quantity);
                        } //  Добавляем
                        elseif ($item->quantity < $request->quantity) {
                            $item->modification->checkout($request->quantity - $item->quantity, false);
                        }
                    }

                    $item->quantity = $request->quantity;

                    $this->modifications->save($item->modification);
                    $this->items->save($item);
                    return $this->newOrderCost($order, 0);
                }
            }
        });
    }

    public function deleteItem(Request $request, $order_id, $pre = false)
    {
        return DB::transaction(function() use ($request, $order_id, $pre)
        {
            $order = $this->orders->get($order_id);
            foreach ($order->items as $item){
                if($item->id == $request->item_id){
                    if(!$pre) {
                        $item->modification->returnQuantity($item->quantity);
                        if ($order->isPaid() || $order->isSent()){
                            $item->modification->returnInStock($item->quantity);
                        }
                        $this->modifications->save($item->modification);
                    }
                    $this->items->remove($item);
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

        $order->delivery = $this->setDeliveryData($order);
        $this->orders->save($order);
        return true;
    }

    public function deliveryUpdate(Request $request, $order)
    {
        return DB::transaction(function() use ($request, $order)
        {
            $order->delivery = $this->updateDeliveryData($request, $order);
            $order->customer = new CustomerData(
                $request->input('customer.phone'),
                $request->input('customer.name'),
                $request->input('customer.email')
            );
            $this->orders->save($order);
        });
    }

    public function adminNoteEdit(Request $request)
    {
        return DB::transaction(function() use ($request)
        {
            $order = $this->orders->get($request->order_id);
            $order->admin_note = $request->admin_note;
            $this->orders->save($order);
        });
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
        $order->notify(new OrderReplyCustomerMail($order, $request));
//        return $order->notify(new OrderReplyCustomerMail($order, $request));
    }

    public function saveCorrespondence($orderId, $message)
    {
        OrderCorrespondence::create([
            'created_at' => time(),
            'message' => $message,
            'order_id' => $orderId
        ]);
    }

    public static function getOtherOrders($order)
    {
        $query = Order::where('id', '<>', $order->id);
        $query->where(function ($query) use ($order) {
            if ($order->customer['email']) {
                $query->where('customer', 'like', '%' . $order->customer['email'] . '%');
            }
            if ($order->customer['phone']) {
                $query->orWhere('customer', 'like', '%' . preg_replace("/[^\d]/", '', $order->customer['phone']) . '%');
            }
        });
        $orders = $query->orderBy('id', 'desc')->get();
        return $orders->isNotEmpty() ? $orders : false;
    }

    public static function getArrayStasusesList($orders)
    {
        $statuses = [];
        foreach ($orders as $order)
        {
            $statuses[$order->id] = $order->statuses->allowedTransitions;
        }
        return$statuses;
    }

    public function setTrackCode($order_id, $track_code)
    {
        return DB::transaction(function () use ($order_id, $track_code)
        {
            $order = $this->orders->get($order_id);
            $order->setTrackCode($track_code);
            $this->orders->save($order);
        });
    }

    public function setPrintCount($order_id)
    {
        return DB::transaction(function () use ($order_id)
        {
            $order = $this->orders->get($order_id);
            $order->setPrintCount();
            $this->orders->save($order);
            return $order->print_count;
        });
    }

    public function setDateBuild($order_id, $date_build)
    {
        return DB::transaction(function () use ($order_id, $date_build)
        {
            $order = $this->orders->get($order_id);
            $order->setDateBuild($date_build);
            $this->orders->save($order);
        });
    }

    public function quantityOrders ()
    {
        $res = Order::
            select('current_status AS status')->
            selectRaw('COUNT(current_status) AS quantity_orders')->
            whereNotIn('current_status', [Status::COMPLETED, Status::CANCELLED, Status::CANCELLED_BY_CUSTOMER])->
            groupBy('status')->
            get()->
            pluck('quantity_orders', 'status')->
            toArray();

        return array_replace(
            array_map(function() {
                return 0;
            }, Status::list()),
            $res);
    }

    public static function getInStockItemsCount($date)
    {
        return self::RawJoin()->
            select(
                'prod.id as product_id',
                'mod.id as modification_id'
            )->
            selectRaw('`prod_mod`.`in_stock` - SUM(`items`.`quantity`) as `availability`')->
            where('created_at', '<=', $date)->
            whereIn('current_status', [1, 8])->
            groupBy('product_id', 'modification_id', 'prod_mod.in_stock')->
            get();
    }

    public static function RawJoin ()
    {
        return Order::
            leftJoin('vinograd_order_items as items', function ($join) {
                $join->on('vinograd_orders.id', '=', 'items.order_id');
            })->
            rightJoin('vinograd_products as prod', function ($join) {
                $join->on('prod.id', '=', 'items.product_id');
            })->
            rightJoin('vinograd_product_modifications as prod_mod', function ($join) {
                $join->on('prod_mod.id', '=', 'items.modification_id');
            })->
            rightJoin('vinograd_modifications as mod', function ($join) {
                $join->on('mod.id', '=', 'prod_mod.modification_id');
            });
    }
}
