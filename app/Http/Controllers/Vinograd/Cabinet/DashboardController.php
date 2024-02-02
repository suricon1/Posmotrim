<?php

namespace App\Http\Controllers\Vinograd\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vinograd\UserDeliveryRequest;
use App\Status\Status;
use App\Models\Site\User;
use App\Models\Vinograd\Order\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

    public function __construct()
    {
        View::share ('domain', 'cabinet');
    }

    public function index()
    {
        $user = Auth::user();
        return view('cabinet.index', [
            'user' => $user,
            'orders' => $user->orders()->orderBy('current_status')->paginate(30)
//            'orders' => Order::getAllUserOrders($user->id)
        ]);
    }

    public function show($order_id)
    {
        $order = Order::with('items.product', 'items.modification.property')->findOrFail($order_id);
        return view('cabinet.order_view', ['order' => $order]);
    }

    public function destroy (Order $order)
    {
        try {
            if(!$order->user_id || $order->user_id != Auth::id()) {
                throw new \RuntimeException('Такого заказа не существует!');
            }
            $order->statuses->transitionTo(Status::createStatus(Status::CANCELLED_BY_CUSTOMER, $order));
            $order->save();
            return redirect()->back();
        } catch  (\RuntimeException $e) {
            return redirect()->route('vinograd.cabinet.home')->withErrors([$e->getMessage()]);
        }
    }

    public function update(UserDeliveryRequest $request)
    {
        $user = Auth::user();
        $user->edit($request->all());
        return redirect(route('vinograd.cabinet.home'));
    }
}
