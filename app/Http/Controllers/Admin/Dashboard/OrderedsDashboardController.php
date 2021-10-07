<?php


namespace App\Http\Controllers\Admin\Dashboard;


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
}
