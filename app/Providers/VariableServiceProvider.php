<?php

namespace App\Providers;

use App\UseCases\OrderService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
