<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\UseCases\Dashboard\DashboardService;
use Illuminate\Http\Request;
use View;

class SelectOrdersController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('dashboard_select_orders_active', ' active');
    }

    public function selectOrdersByNumbers (Request $request, DashboardService $service)
    {
        $ids = $service->StringToArray($request->ids);

        return view('admin.vinograd.analytica.select_orders_by_numbers', [
            'orders' => $service->getSelectOrdersByNumbers($ids),
            'select_numbers' => $service->ArrayToString($ids)
        ]);
    }

    public function selectOrders(DashboardService $service, $ids)
    {
        $ids = $service->StringToArray($ids);

        return view('admin.vinograd.analytica.print.select_orders', [
            'orders' => $service->getSelectOrdersByNumbers($ids),
            'select_numbers' => $service->ArrayToString($ids)
        ]);
    }
}
