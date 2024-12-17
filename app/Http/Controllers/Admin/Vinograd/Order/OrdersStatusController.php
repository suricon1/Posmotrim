<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\Models\Vinograd\Order\Order;
use App\Status\Status;
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
            return redirect()->route('orders.track_code_form', $order);
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
                'status' => $order->statuses->name($request->status)]
            ];
        } catch  (\RuntimeException $e) {
            return ['errors' => [$e->getMessage()]];
        }
    }
}
