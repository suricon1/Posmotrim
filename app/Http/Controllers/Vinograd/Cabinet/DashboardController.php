<?php

namespace App\Http\Controllers\Vinograd\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vinograd\UserDeliveryRequest;
use App\Models\Vinograd\Order\Status;
use App\UseCases\OrderService;
use App\UseCases\StatusService;
use Illuminate\Http\Request;
use App\Models\Site\User;
use App\Models\Vinograd\Order\Order;
use Auth;
use View;

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
            'orders' => Order::where('user_id', $user->id)->orderBy('current_status')->paginate(30)
        ]);
    }

    public function show($order_id)
    {
        $order = Order::with('items.product', 'items.modification.property')->findOrFail($order_id);
        return view('cabinet.order_view', ['order' => $order]);
    }

    public function destroy (StatusService $statusService, $order_id)
    {
        $order = Order::findOrFail($order_id);
        try {
            $statusService->setStatus($order_id, '6');
            return redirect()->back();
        } catch  (\RuntimeException $e) {
            return redirect()->route('orders.show', $order->id)->withErrors([$e->getMessage()]);
        }
    }

    public function update(UserDeliveryRequest $request, $id)
    {
        $user = User::find($id);

        $user->edit($request->all());
        return redirect(route('vinograd.cabinet.home'));
    }
}
