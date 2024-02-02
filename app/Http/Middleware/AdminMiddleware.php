<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session_id() == '') {
            @session_start();
        }

        if(is_admin())
        {
            $_SESSION['isLoggedIn'] = true;
            return $next($request);
        }
        abort(404);
    }
}
