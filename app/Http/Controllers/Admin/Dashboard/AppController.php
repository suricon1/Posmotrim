<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use View;

class AppController extends Controller
{
    public function __construct()
    {
        View::share ('dashboard_open', ' menu-open');
        View::share ('dashboard_active', ' active');
    }
}
