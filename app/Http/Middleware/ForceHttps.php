<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    public function handle($request, Closure $next)
    {
//        $app_url = env('APP_URL');
//
//        if ( !$request->secure() && substr($app_url, 0, 8) === 'https://' ) {
//            return redirect()->secure($request->getRequestUri());
//        }

//        if (!$request->secure()) {
//            return redirect()->secure($request->getRequestUri());
//        }

//        if (empty($_SERVER['HTTPS']) && env('APP_ENV') === 'prod') {
//            return redirect()->secure($request->getRequestUri());
//        }

//        $request->setTrustedProxies([$request->getClientIp()], Request::HEADER_X_FORWARDED_ALL);
//
//        if (!$request->secure() && env('APP_ENV') === 'prod') {
//            return redirect()->secure($request->getRequestUri());
//        }

//        if (!$request->secure() && App::environment() === 'prod') {
////            return redirect()->secure($request->getRequestUri());


//        if (isset($_SERVER['HTTPS']) &&
//            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
//            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
//            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
//            dd('https://');
//        }
//        else {
//            dd('http://');
//        }
        //dd(env('APP_ENV'), App::environment(), $request->secure(), $request->isSecure(), $request->getRequestUri(), $_SERVER);

        return $next($request);
    }
}