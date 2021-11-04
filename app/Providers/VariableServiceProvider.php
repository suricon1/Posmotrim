<?php

namespace App\Providers;

use App\Models\Vinograd\Order\Order;
use App\UseCases\OrderService;
use Illuminate\Support\ServiceProvider;
use View;

class VariableServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(OrderService $service)
    {
        View::share('quantity_orders', $service->quantityOrders());
    }
}
