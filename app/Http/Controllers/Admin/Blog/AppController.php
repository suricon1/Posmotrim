<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class AppController extends Controller
{
    public function __construct()
    {
        View::share ('blog_open', ' menu-open');
        View::share ('blog_active', ' active');
    }
}
