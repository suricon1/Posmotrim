<?php

namespace App\Http\Controllers\Vinograd;

use App\Http\Requests\Vinograd\CheckoutRequest;
use App\Models\Vinograd\DeliveryMethod;
use App\UseCases\CartService;
use App\UseCases\OrderService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CheckoutController extends Controller
{
    public $service;
    public $cartService;

    public function __construct(CartService $cartService, OrderService $service)
    {
        $this->cartService = $cartService;
        $this->service = $service;
        View::share ('cart', $cartService->getCart());
    }

    public function delivery()
    {
        return view('vinograd.checkout.delivery', [
                'deliverys' => DeliveryMethod::active()->filterCost($this->cartService->getCart()->getCost()->getTotal())->orderBy('sort')->get(),
                'cart' => $this->cartService->getCart()
            ]);
    }

    public function deliveryForm($delivery_slug)
    {
        return view('vinograd.checkout.checkoutForm', [
            'delivery' => DeliveryMethod::where('slug', $delivery_slug)->first()
        ]);
    }

    public function checkout(CheckoutRequest $request)
    {
        try {
            $order = $this->service->checkout($request);
            $this->service->sendMail($order);

            return redirect()->
                   route((Auth::user()) ? 'vinograd.cabinet.home' : 'vinograd.category')->
                   with('status', 'Заказ сохранен. № заказа: ' . $order->id . '. В ближайшее время мы с Вами свяжемся для уточнения деталей!')->
                   withErrors(['<h4>ВНИМАНИЕ! Если от нас в ближайшее время не поступит обратная связь, посмотрите письма в папке СПАМ</h4>']);

        } catch (\DomainException $e) {
            return redirect()->route('vinograd.cart.ingex')->withErrors([$e->getMessage()]);
        }
    }
}
