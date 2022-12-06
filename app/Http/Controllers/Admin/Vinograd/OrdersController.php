<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Http\Requests\Admin\Vinograd\Order\SendReplyMailRequest;
use App\Http\Requests\Vinograd\CheckoutRequest;
use App\Models\Vinograd\Currency;
use App\Models\Vinograd\DeliveryMethod;
use App\Models\Vinograd\Order\CustomerData;
use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\OrderItem;
use App\Models\Vinograd\Order\Status;
use App\Repositories\ItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\UseCases\NumberToStringService;
use App\UseCases\OrderService;
use App\UseCases\StatusService;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View;

class OrdersController extends Controller
{
    public function __construct()
    {
        View::share ('orders_open', ' menu-open');
        View::share ('orders_active', ' active');
        View::share ('order_active', ' active');
    }

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

    public function sendReplyMail(SendReplyMailRequest $request, OrderService $service)
    {
        $order = Order::find($request->order_id);
        $service->sendReplyMail($order, $request);
        $service->saveCorrespondence($order->id, $request->message);
        return redirect()->back();
    }

    public function setStatus(Request $request, StatusService $statusService)
    {
        $this->validate($request, [
            'status' =>  'required|in:1,2,3,4,5,6,7,8',
            'order_id' => 'required|exists:vinograd_orders,id'
        ]);

        $order = Order::findOrFail($request->order_id);
        if ($request->status == Status::SENT){
            return view('admin.vinograd.order.add_treck_code', [
                'order' => $order
            ]);
        }
        try {
            $statusService->setStatus($request->order_id, $request->status);
            return redirect()->back();
        } catch  (\RuntimeException $e) {
            return redirect()->route('orders.show', $order->id)->withErrors([$e->getMessage()]);
        }
    }

    public function setAjaxStatus(Request $request, StatusService $statusService)
    {
        $v = Validator::make($request->all(), [
            'status' =>  'required|in:1,2,3,4,5,6,7,8',
            'order_id' => 'required|exists:vinograd_orders,id'
        ]);
        if ($v->fails()) {
            return ['errors' => $v->errors()];
        }

        $order = Order::find($request->order_id);
        if ($request->status == Status::SENT){
            return ['success' => [
                'code_form' => view('admin.vinograd.order.components.treck_code_form', ['id' => $order->id])->render()]
            ];
        }
        try {
            $statusService->setStatus($request->order_id, $request->status);
            return ['success' => [
                'status' => $order->statusName($request->status)]
            ];
        } catch  (\RuntimeException $e) {
            return ['errors' => [$e->getMessage()]];
        }
    }

    public function setAjaxTreckCode (Request $request, OrderService $OrderService, StatusService $statusService)
    {
        $v = Validator::make($request->all(), [
            'track_code' =>  'required',
            'order_id' => 'required|exists:vinograd_orders,id'
        ]);
        if ($v->fails()) {
            return ['errors' => $v->errors()];
        }

        $order = Order::find($request->order_id);
        try {
            $statusService->setStatus($request->order_id, Status::SENT, $request->track_code);
            $OrderService->sendCodeMail($order, $request->track_code);
            return ['success' => $order->statusName(Status::SENT)];
        } catch  (\RuntimeException $e) {
            return ['errors' => [$e->getMessage()]];
        }
    }

    public function sentStatusMail(Request $request, OrderService $OrderService, StatusService $statusService)
    {
        $v = Validator::make($request->all(), [
            'track_code' =>  'required',
            'order_id' => 'required|exists:vinograd_orders,id'
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($v->fails()) {
            return view('admin.vinograd.order.add_treck_code', [
                'order' => $order
            ])->withErrors($v);
        }
        try {
            $statusService->setStatus($request->order_id, Status::SENT, $request->track_code);
            $OrderService->sendCodeMail($order, $request->track_code);
            return redirect()->route('orders.show', $request->order_id);
        } catch  (\RuntimeException $e) {
            return redirect()->route('orders.show', $order->id)->withErrors([$e->getMessage()]);
        }
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
                'products' => $productRep->getSortProductByModifications($request, '', null, 200),
                'deliverys' => DeliveryMethod::pluck('name', 'id')->all()
            ]);
        } catch  (\RuntimeException $e) {
            return redirect()->route('orders.show', $order->id)->withErrors([$e->getMessage()]);
        }
    }

    public function setTrackCode(Request $request, OrderService $service)
    {
        $this->validate($request, [
            'order_id' => 'required|exists:vinograd_orders,id',
            'track_code' =>  'required'
        ]);
        try {
            $service->setTrackCode($request->order_id, $request->track_code);
            return redirect()->route('orders.show', $request->order_id);
        } catch  (\RuntimeException $e) {
            return redirect()->route('orders.show', $request->order_id)->withErrors([$e->getMessage()]);
        }
    }

    public function addItem(Request $request, OrderService $service, $order_id)
    {
        $this->validate($request, [
            'modification_id' =>  'required|exists:vinograd_product_modifications,id',
            'quantity' => ['required', 'integer', 'regex:/^[1-9]\d*$/']
        ]);
        try {
            $service->addItem($request, $order_id);
            return redirect()->route('orders.edit', $order_id)->with('status', 'Изменения сохранены');
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function updateItem(Request $request, OrderService $service, $order_id)
    {
        $this->validate($request, [
            'item_id' =>  'required|exists:vinograd_order_items,id',
            'quantity' => ['required', 'integer', 'regex:/^[0-9]\d*$/']
        ]);

        try {
            if ($request->quantity == 0){
                return $service->deleteItem($request, $order_id)
                    ? redirect()->route('orders.edit', $order_id)->with('status', 'Изменения сохранены')
                    : redirect()->route('orders.index')->with('status', 'Изменения сохранены');
            }
            $service->updateItem($request, $order_id);
            return redirect()->route('orders.edit', $order_id)->with('status', 'Изменения сохранены');
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function currencyUpdate(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|exists:vinograd_orders,id',
            'currency' => 'required|exists:vinograd_currency,code'
        ]);
        try {
            $order = Order::findOrFail($request->order_id);
            $order->currency = $request->currency;
            $order->save();
            return back();
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function deleteItem(Request $request, OrderService $service, $order_id)
    {
        $this->validate($request, [
            'item_id' =>  'required|exists:vinograd_order_items,id'
        ]);

        try {
            return $service->deleteItem($request, $order_id)
                ? redirect()->route('orders.edit', $order_id)->with('status', 'Изменения сохранены')
                : redirect()->route('orders.index')->with('status', 'Изменения сохранены');
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function deliveryEdit(Request $request, OrderService $service, $order_id)
    {
        return view('admin.vinograd.order.delivery_update', [
            'order' => Order::findOrFail($order_id),
            'delivery' => DeliveryMethod::where('id', $request->delivery_id ?: 1)->first()
        ]);
    }

    public function deliveryUpdate(CheckoutRequest $request, OrderService $service, $order_id)
    {
        $order = Order::find($order_id);
        try {
            $service->deliveryUpdate($request, $order);
            return $order->current_status == Status::PRELIMINARY
                ? redirect()->route('orders.pre.edit', $order_id)->with('status', 'Метод доставки изменен!')
                : redirect()->route('orders.edit', $order_id)->with('status', 'Метод доставки изменен!');
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function adminNoteEdit(Request $request, OrderService $service, $order_id)
    {
        $this->validate($request, [
            'admin_note' =>  'required|string',
        ]);

        try {
            $service->adminNoteEdit($request, $order_id);
            return back()->with('status', 'Примечание сохранено!');
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
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
