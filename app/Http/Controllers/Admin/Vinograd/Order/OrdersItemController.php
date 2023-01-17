<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\UseCases\OrderService;
use Illuminate\Http\Request;

class OrdersItemController extends AppOrdersController
{
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


}
