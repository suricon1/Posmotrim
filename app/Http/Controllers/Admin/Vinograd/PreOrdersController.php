<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Models\Vinograd\DeliveryMethod;
use App\Models\Vinograd\Order\Order;
use App\Status\Status;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\UseCases\OrderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;

class PreOrdersController extends Controller
{
    public function __construct()
    {
        View::share('orders_open', ' menu-open');
        View::share('orders_active', ' active');
        View::share('order_active', ' active');
    }

    public function preCreate(OrderService $service)
    {
        $order = $service->createNewOrder(Status::PRELIMINARY);
        return redirect()->route('orders.delivery.edit', $order->id);
        //return redirect()->route('orders.pre.edit', $order->id);
    }

    public function preEdit(ProductRepository $productRep, OrderRepository $orderRep, $id)
    {
        $order = Order::with('items')->findOrFail($id);
        try {
            $orderRep->isCompleted($order);
            return view('admin.vinograd.order.pre_edit', [
                'order' => $order,
                'products' => $productRep->getAllProducts(),
                'deliverys' => DeliveryMethod::pluck('name', 'id')->all()
            ]);
        } catch  (\RuntimeException $e) {
            return redirect()->route('orders.show', $order->id)->withErrors([$e->getMessage()]);
        }
    }

    public function addItem(Request $request, OrderService $service, $order_id)
    {
        $this->validate($request, [
            'modification_id' =>  'required|exists:vinograd_product_modifications,id',
            'quantity' => ['required', 'integer', 'regex:/^[1-9]\d*$/']
        ]);
        try {
            $service->addItem($request, $order_id, true);
            return redirect()->route('orders.pre.edit', $order_id)->with('status', 'Изменения сохранены');
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
                return $service->deleteItem($request, $order_id, true)
                    ? redirect()->route('orders.pre.edit', $order_id)->with('status', 'Изменения сохранены')
                    : redirect()->route('orders.index')->with('status', 'Изменения сохранены');
            }
            $service->updateItem($request, $order_id, true);
            return redirect()->route('orders.pre.edit', $order_id)->with('status', 'Изменения сохранены');
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
            return $service->deleteItem($request, $order_id, true)
                ? redirect()->route('orders.pre.edit', $order_id)->with('status', 'Изменения сохранены')
                : redirect()->route('orders.index')->with('status', 'Изменения сохранены');
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }
}
