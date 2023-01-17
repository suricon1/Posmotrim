<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\Http\Requests\Vinograd\CheckoutRequest;
use App\Models\Vinograd\DeliveryMethod;
use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\Status;
use App\UseCases\OrderService;
use Illuminate\Http\Request;

class OrdersDeliveryController extends AppOrdersController
{
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

}
