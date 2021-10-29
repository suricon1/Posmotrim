<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\Vinograd\Currency;
use App\Models\Vinograd\Modification;
use App\UseCases\Dashboard\DashboardService;
use Illuminate\Http\Request;
use View;

class DashboardController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('dashboard_sort_active', ' active');
    }

    public function index(Request $request, DashboardService $service)
    {
        $dateRange = $service->getDateRange($request);
        $status = $request->status;

        return view('admin.vinograd.analytica.sorts_analytics', [
            'array' => $service->getCompletedOrdersItemsArray($dateRange, $status),
            'totalCost' => $service->getTotalCostCompletedOrders($dateRange, $status),
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
}
