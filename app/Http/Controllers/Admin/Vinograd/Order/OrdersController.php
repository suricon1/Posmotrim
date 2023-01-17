<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\Http\Requests\Admin\Vinograd\Order\SendReplyMailRequest;
use App\Models\Vinograd\Currency;
use App\Models\Vinograd\DeliveryMethod;
use App\Models\Vinograd\Order\CustomerData;
use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\OrderItem;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\UseCases\OrderService;
use Illuminate\Http\Request;

class OrdersController extends AppOrdersController
{
    public function index(Request $request, $status = false)
    {
        $query = Order::status($status);

        if (!empty($request->get('id'))) {
            $query->orWhere('id', $request->get('id'));
        }
        if (!empty($request->get('email'))) {
            $query->orWhere('customer', 'like', '%' . $request->get('email') . '%');
        }
        if (!empty($request->get('phone'))) {
            $query->orWhere('customer', 'like', '%' . preg_replace("/[^\d]/", '', $request->get('phone')) . '%');
        }

        $orders = $query->orderBy('current_status')->orderBy('id', 'desc')->paginate(30)->appends($request->all());
        return view('admin.vinograd.order.index',
        [
            'orders' => $orders,
            'currency' => Currency::all()->keyBy('code')->all(),
            'statusesList' => OrderService::getArrayStasusesList($orders)
        ]);
    }

    public function create(OrderService $service)
    {
        $order = $service->createNewOrder();
        return redirect()->route('orders.delivery.edit', $order->id);
        //return redirect()->route('orders.edit', $order->id);
    }

    public function store(Request $request){}

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.show', [
            'order' => $order,
            'other_orders' => OrderService::getOtherOrders($order), //  Получить другие заказы клиента
            'items' => OrderItem::getOrderSortedByItems($order),
            'statusesList' => OrderService::getOrderStasusesList($order),
            'currency' => Currency::where('code', $order->currency)->first(),
            'currencys' => Currency::orderBy('code')->pluck('name', 'code')->all()
        ]);
    }

    public function edit(Request $request, ProductRepository $productRep, OrderRepository $orderRep, $id)
    {
        $order = Order::with('items')->findOrFail($id);
        try {
            $orderRep->isCompleted($order);
            return view('admin.vinograd.order.edit', [
                'order' => $order,
                'items' => OrderItem::getOrderSortedByItems($order),
                'products' => $productRep->getSortProductByModifications($request, '', null, 500),
                'deliverys' => DeliveryMethod::pluck('name', 'id')->all()
            ]);
        } catch  (\RuntimeException $e) {
            return redirect()->route('orders.show', $order->id)->withErrors([$e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {}

    public function destroy(OrderService $service, $id)
    {
        try {
            $service->remove($id);
            return redirect()->route('orders.index');
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function sendReplyMail(SendReplyMailRequest $request, OrderService $service)
    {
        $order = Order::find($request->order_id);
        $service->sendReplyMail($order, $request);
        $service->saveCorrespondence($order->id, $request->message);
        return redirect()->back();
    }

    public function currencyUpdate(Request $request, OrderRepository $orderRep)
    {
        $this->validate($request, [
            'order_id' => 'required|exists:vinograd_orders,id',
            'currency' => 'required|exists:vinograd_currency,code'
        ]);
        try {
            $order = $orderRep->get($request->order_id);
            $order->currency = $request->currency;
            $orderRep->save($order);
            return back();
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }






    public function temp()
    {
        $orders = Order::all();
        dd($orders);
        foreach ($orders as $order){
            $customer = new CustomerData($order->customer['phone'], $order->customer['name'], $order->customer['email']);
            $order->customer['phone'] = $customer;
            $order->save();
        }
        return "Обновление телефонов заказчиков.";
    }
}
