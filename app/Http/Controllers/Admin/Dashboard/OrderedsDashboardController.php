<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\Vinograd\Currency;
use App\Models\Vinograd\Modification;
use App\Models\Vinograd\Order\Order;
use App\UseCases\Dashboard\DashboardService;
use Illuminate\Http\Request;
use View;

class OrderedsDashboardController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('dashboard_ordered_active', ' active');
    }

    public function index (Request $request, DashboardService $service)
    {
        $dateRange = $service->getDateRange($request);

        return view('admin.vinograd.analytica.ordereds_analytics', [
            'ordereds' => $service->getCompletedOrdersItemsArray($dateRange, Order::ORDERED_LIST),
            'totalCost' => $service->getTotalCostCompletedOrders($dateRange, Order::ORDERED_LIST),
            'titleDate' => $service->getTitleDate($dateRange)
        ]);
    }

    public function allOrdersAsModfication(Request $request, DashboardService $service, $product_id, $modification_id, $price, $status = null)
    {
        $dateRange = $service->getDateRange($request);
        $status = $status ?: $request->status;
        $modification = Modification::with('product', 'property')->find($modification_id);

        return view('admin.vinograd.analytica.all_orders_as_modfication', [
            'orders' => $service->getAllOrdersAsModfication($dateRange, $status, $product_id, $modification_id, $price),
            'currency' => Currency::all()->keyBy('code')->all(),
            'titleDate' => $service->getTitleDate($dateRange),
            'title' => $modification->product->name . ' ' . $modification->property->name
        ]);
    }

    public function allOrderedsAsModfication(Request $request, DashboardService $service, $product_id, $modification_id, $price)
    {
        return $this->allOrdersAsModfication($request, $service, $product_id, $modification_id, $price, Order::ORDERED_LIST);
    }
}
