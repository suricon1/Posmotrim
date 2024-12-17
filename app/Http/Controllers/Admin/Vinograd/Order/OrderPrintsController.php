<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\Models\Vinograd\Currency;
use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\OrderItem;
use App\Status\Status;
use App\UseCases\NumberToStringService;
use App\UseCases\OrderService;
use App\UseCases\StatusService;
use Illuminate\Http\Request;
use Validator;

class OrderPrintsController extends AppOrdersController
{
    public function order(StatusService $statusService, OrderService $orderService, $id)
    {
        $order = Order::findOrFail($id);
        $items = OrderItem::getOrderSortedByItems($order);
        $quantityByModifications = OrderItem::getQuantityByModifications($items);

        try {
            $orderService->setPrintCount($id);
            $statusService->setPrintStatus($id);

                return view('admin.vinograd.order.print.order', [
                    'order' => $order,
                    'items' => $items,
                    'quantityByModifications' => $quantityByModifications,
                    'currency' => Currency::where('code', $order->currency)->first()
                ]);
        } catch  (\RuntimeException $e) {
            return redirect()->route('orders.print.order', $id)->withErrors([$e->getMessage()]);
        }

    }

    public function ajaxOrder(Request $request, StatusService $statusService, OrderService $orderService)
    {
        $v = Validator::make($request->all(), [
            'order_id' => 'required|exists:vinograd_orders,id'
        ]);
        if ($v->fails()) {
            return ['errors' => $v->errors()];
        }
        $order = Order::findOrFail($request->order_id);
        $items = OrderItem::getOrderSortedByItems($order);
        $quantityByModifications = OrderItem::getQuantityByModifications($items);

        try {
            $count = $orderService->setPrintCount($request->order_id);
            $statusService->setPrintStatus($request->order_id);
            return [
                'success' => [
                    'print_order' => view('admin.vinograd.order.components.print_order', [
                            'order' => $order,
                            'items' => $items,
                            'quantityByModifications' => $quantityByModifications,
                            'currency' => Currency::where('code', $order->currency)->first()
                        ])->render(),
                    'print_count' => '<i class="fa fa-print"></i> Распечатан ' . $count . ' раз'
                ]
            ];
        } catch  (\RuntimeException $e) {
            return ['errors' => [$e->getMessage()]];
        }
    }

    public function ajaxOrdersBuildDate(Request $request, StatusService $statusService, OrderService $orderService)
    {
        $v = Validator::make($request->all(), [
            'date' => 'required'
        ]);
        if ($v->fails()) {
            return ['errors' => $v->errors()];
        }
        try {
            $orders = Order::where('date_build', $request->get('date'))->whereIn('current_status', Status::orderEditable())->get();
            $print_order = '';
            foreach ($orders as $order) {
                $items = OrderItem::getOrderSortedByItems($order);
                $quantityByModifications = OrderItem::getQuantityByModifications($items);

                $orderService->setPrintCount($order->id);
                $statusService->setPrintStatus($order->id);

                $print_order .= view('admin.vinograd.order.components.print_order', [
                    'order' => $order,
                    'items' => $items,
                    'quantityByModifications' => $quantityByModifications,
                    'currency' => Currency::where('code', $order->currency)->first()
                ])->render();
                $print_order .= '<div class="border border-dark"></div>';

            }
            return [
                'success' => [
                    'print_order' => $print_order
                ]
            ];
        } catch  (\RuntimeException $e) {
            return ['errors' => [$e->getMessage()]];
        }
    }

    public function nalozhkaBlanck (NumberToStringService $service, $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.print.nalozhka_blanck', [
            'order' => $order,
            'costToString' => $service->numberToRussian($order->getTotalCost()),
            'costFormat' => $service->numberToCostFormat($order->getTotalCost())
        ]);
    }

    public function nalozhkaSticker (NumberToStringService $service, $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.print.nalozhka_sticker', [
            'order' => $order,
            'costToString' => $service->numberToRussian($order->getTotalCost()),
            'costFormat' => $service->numberToCostFormat($order->getTotalCost())
        ]);
    }

    public function declaredSticker (NumberToStringService $service, $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.print.declared_sticker', [
            'order' => $order,
            'costToString' => $service->numberToRussian($order->getTotalCost()),
            'costFormat' => $service->numberToCostFormat($order->getTotalCost())
        ]);
    }

    public function postalBelarusSticker (NumberToStringService $service, $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.print.postal_belarus_sticker', [
            'order' => $order,
            'costToString' => $service->numberToRussian($order->getTotalCost()),
            'costFormat' => $service->numberToCostFormat($order->getTotalCost())
        ]);
    }

    public function smallPackageSticker (NumberToStringService $service, $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.vinograd.order.print.small_package_sticker', [
            'order' => $order,
            'costToString' => $service->numberToRussian($order->getTotalCost()),
            'costFormat' => $service->numberToCostFormat($order->getTotalCost())
        ]);
    }

    public function smallPackageSticker_2 (NumberToStringService $service, $id)
    {
        $order = Order::findOrFail($id);
        $currency = Currency::where('code', $order->currency)->first();
        return view('admin.vinograd.order.print.small_package_sticker_2', [
            'order' => $order,
            'cost' => ceil(mailCurr($currency, $order->getTotalCost()) / 100 * 30)
        ]);
    }
}
