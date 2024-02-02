<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\Models\Vinograd\Order\Order;
use App\Status\Status;
use App\UseCases\OrderService;
use App\UseCases\StatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersTreckCodeController extends AppOrdersController
{
    public function setTrackCode(Request $request, OrderService $service)
    {
        $this->validate($request, [
            'track_code' => 'required|regex:/^[A-Za-z]{2}[0-9]{9}[A-Za-z]{2}$/i',
            'order_id' => 'required|exists:vinograd_orders,id'
        ],[
            'track_code.regex' => 'Код должен иметь формат: "VV380205975BY"'
        ]);
        try {
            $service->setTrackCode($request->order_id, $request->track_code);
            return redirect()->route('orders.show', $request->order_id);
        } catch  (\RuntimeException $e) {
            return redirect()->route('orders.show', $request->order_id)->withErrors([$e->getMessage()]);
        }
    }

    private function textInfo($order, $track_code)
    {
        if(!$order->customer['email']){
            $phone = $order->customer['phone'];
            return
<<<EOD
    <div>
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

    public function setAjaxTreckCode (Request $request, OrderService $OrderService, StatusService $statusService)
    {
        $v = Validator::make($request->all(), [
            'track_code' => ['required', 'regex:/^[A-Za-z]{2}[0-9]{9}(BY|by)$/'],
            'order_id' => 'required|exists:vinograd_orders,id'
        ],[
            'track_code.regex' => 'Код должен иметь формат: "VV380205975BY"'
        ]);
        if ($v->fails()) {
            return ['errors' => $v->errors()];
        }

        $order = Order::find($request->order_id);
        try {
            $statusService->setStatus($request->order_id, Status::SENT, $request->track_code);
            $OrderService->sendCodeMail($order, $request->track_code);
            return [
                'success' => $order->statuses->name(Status::SENT),
                'info' => $this->textInfo($order, $request->track_code)
            ];
        } catch  (\RuntimeException $e) {
            return ['errors' => [$e->getMessage()]];
        }
    }

    public function sentStatusMail(Request $request, OrderService $OrderService, StatusService $statusService)
    {
        $v = Validator::make($request->all(), [
            'track_code' =>  'required|regex:/^[A-Za-z]{2}[0-9]{9}[A-Za-z]{2}$/',
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
            return redirect()->route('orders.show', $request->order_id)->with('status', $this->textInfo($order, $request->track_code));
        } catch  (\RuntimeException $e) {
            return redirect()->route('orders.show', $order->id)->withErrors([$e->getMessage()]);
        }
    }
}
