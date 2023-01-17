<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\Http\Controllers\Controller;
use View;

class AppOrdersController extends Controller
{
    public function __construct()
    {
        View::share ('orders_open', ' menu-open');
        View::share ('orders_active', ' active');
        View::share ('order_active', ' active');
    }

}
