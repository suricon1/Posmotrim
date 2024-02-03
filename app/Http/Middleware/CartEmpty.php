<?php

namespace App\Http\Middleware;

use App\UseCases\CartService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartEmpty
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->cartService->getCart()->getItems()){
            return redirect()->route('vinograd.category')->withErrors(['error' => 'Корзина пуста.']);
        }

        return $next($request);
    }
}
