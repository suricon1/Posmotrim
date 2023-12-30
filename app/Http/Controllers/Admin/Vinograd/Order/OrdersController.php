<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\Http\Requests\Admin\Vinograd\Order\SendReplyMailRequest;
use App\Models\Vinograd\Currency;
use App\Models\Vinograd\DeliveryMethod;
use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\OrderItem;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\UseCases\OrderService;
use Illuminate\Http\Request;
use Validator;

class OrdersController extends AppOrdersController
{
    private $orderRepository;

    public function __construct()
    {
        parent:: __construct();
        $this->orderRepository = app(OrderRepository::class);
    }

    public function index(Request $request, $status = false)
    {
        $orders = $this->orderRepository->getFilterOrders($request, $status);
        return view('admin.vinograd.order.index', [
            'orders' => $orders,
            'currency' => Currency::all()->keyBy('code')->all(),
            'statusesList' => OrderService::getArrayStasusesList($orders)
        ]);
    }

    public function create(OrderService $service)
    {
        $order = $service->createNewOrder();
        return redirect()->route('orders.delivery.edit', $order->id);
    }

    public function store(Request $request){}

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $items = OrderItem::getOrderSortedByItems($order);
        $quantityByModifications = OrderItem::getQuantityByModifications($items);

        return view('admin.vinograd.order.show', [
            'order' => $order,
            'other_orders' => OrderService::getOtherOrders($order), //  Получить другие заказы клиента
            'items' => $items,
            'quantityByModifications' => $quantityByModifications,
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

    public function merge(OrderService $service, $order_id, $merge_order_id)
    {
        try {
            $service->mergeOrders($order_id, $merge_order_id);
            return back();
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function repeatCreate (OrderService $service, $id)
    {
        try {
            $new_order_id = $service->createRepeatOrder($id);
            return redirect()->route('orders.edit', $new_order_id);
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

    public function setBuildDate(Request $request, OrderService $orderservice)
    {
        $v = Validator::make($request->all(), [
            'order_id' => 'required|exists:vinograd_orders,id'
        ]);
        if ($v->fails()) {
            return ['errors' => $v->errors()];
        }
        try{
            $orderservice->setDateBuild($request->order_id, $request->date_build);
            return ['success' => 'ok'];
        } catch  (\RuntimeException $e) {
            return ['errors' => [$e->getMessage()]];
        }
    }
}
