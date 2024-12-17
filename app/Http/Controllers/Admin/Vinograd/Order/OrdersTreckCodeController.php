<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\Http\Requests\Admin\Vinograd\Order\OrdersTreckCodeRequest;
use App\Models\Vinograd\Order\Order;
use App\Status\Status;
use App\UseCases\OrderService;
use App\UseCases\StatusService;
use Illuminate\Http\Request;
use RuntimeException;

class OrdersTreckCodeController extends AppOrdersController
{
    public function setTrackCode(OrdersTreckCodeRequest $request, OrderService $service)
    {
        try {
            $service->setTrackCode($request->order_id, $request->track_code);
            return redirect()->route('orders.show', $request->order_id);
        } catch  (RuntimeException $e) {
            return redirect()->route('orders.show', $request->order_id)->withErrors([$e->getMessage()]);
        }
    }

    private function textInfo($order, $track_code)
    {
        if(!$order->customer['email']){
            $phone = $order->customer['phone'];
            return
<<<EOD
    <div style="background-color: white; color: black; padding: 10px;">
        <h4>Для Вайбера</h4>
        <p>тел: $phone</p>
        <p>Здравствуйте.</p>
        <p>Ваш заказ отправлен.</p>
        <p>Код отслеживания: $track_code</p>
    </div>
EOD;
        }
        return null;
    }

    public function setAjaxTreckCode (OrdersTreckCodeRequest $request, OrderService $OrderService, StatusService $statusService)
    {
        $order = Order::find($request->order_id);
        try {
            $statusService->setStatus($request->order_id, Status::SENT, $request->track_code);
            $OrderService->sendCodeMail($order, $request->track_code);
            return [
                'success' => $order->statuses->name(Status::SENT),
                'info' => $this->textInfo($order, $request->track_code)
            ];
        } catch  (RuntimeException $e) {
            return ['errors' => [$e->getMessage()]];
        }
    }

    public function sentStatusMail(OrdersTreckCodeRequest $request, OrderService $OrderService, StatusService $statusService)
    {
        $order = Order::findOrFail($request->order_id);
        try {
            $statusService->setStatus($request->order_id, Status::SENT, $request->track_code);
            $OrderService->sendCodeMail($order, $request->track_code);
            return redirect()->route('orders.show', $request->order_id)->with('status', $this->textInfo($order, $request->track_code));
        } catch  (RuntimeException $e) {
            return redirect()->route('orders.show', $order->id)->withErrors([$e->getMessage()]);
        }
    }

    public function trackCodeForm (Order $order)
    {
        return view('admin.vinograd.order.add_treck_code', [
            'order' => $order
        ]);
    }
}
