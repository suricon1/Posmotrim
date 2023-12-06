<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\Status;
use App\UseCases\OrderService;
use App\UseCases\StatusService;
use Illuminate\Http\Request;
use Validator;

class OrdersStatusController extends AppOrdersController
{
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
//
//            вывод на печать
//
//            if($request->status == Status::PAID) {
//                return redirect()->route('orders.print.nalozhka_blanck', [
//                    'order' => $order
//                ]);
//            }
//
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
}
