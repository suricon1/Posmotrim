<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\UseCases\Dashboard\DashboardService;
use Illuminate\Http\Request;
use View;

class DeliverysDashboardController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('dashboard_delivery_active', ' active');
    }

    public function index (Request $request, DashboardService $service)
    {
        $dateRange = $service->getDateRange($request);
        $status = $request->status;

        return view('admin.vinograd.analytica.deliverys_analytics', [
            'deliverys' => $service->getDataOnDeliveryAll($dateRange, $status),
            'totalCost' => $service->getTotalCostCompletedOrders($dateRange, $status),
            'titleDate' => $service->getTitleDate($dateRange)
        ]);
    }
}
