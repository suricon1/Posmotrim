<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Http\Controllers\Controller;
use App\Models\Vinograd\Currency;
use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\OrderItem;
use App\UseCases\NumberToStringService;
use View;

class OrderPrintsController extends Controller
{
    public function __construct()
    {
        View::share ('orders_open', ' menu-open');
        View::share ('orders_active', ' active');
        View::share ('order_active', ' active');
    }

    public function order($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.print.order', [
            'order' => $order,
            'items' => OrderItem::getOrderSortedByItem($order->id),
            'currency' => Currency::where('code', $order->currency)->first()
        ]);
    }

    public function nalozhkaBlanck (NumberToStringService $service, $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.print.nalozhka_blanck', [
            'order' => $order,
            'costToString' => $service->numberToRussian($order->cost),
            'costFormat' => $service->numberToCostFormat($order->cost)
        ]);
    }

    public function nalozhkaSticker (NumberToStringService $service, $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.print.nalozhka_sticker', [
            'order' => $order,
            'costToString' => $service->numberToRussian($order->cost),
            'costFormat' => $service->numberToCostFormat($order->cost)
        ]);
    }

    public function declaredSticker (NumberToStringService $service, $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.print.declared_sticker', [
            'order' => $order,
            'costToString' => $service->numberToRussian($order->cost),
            'costFormat' => $service->numberToCostFormat($order->cost)
        ]);
    }

    public function smallPackageSticker (NumberToStringService $service, $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.print.small_package_sticker', [
            'order' => $order,
            'costToString' => $service->numberToRussian($order->cost),
            'costFormat' => $service->numberToCostFormat($order->cost)
        ]);
    }

}
