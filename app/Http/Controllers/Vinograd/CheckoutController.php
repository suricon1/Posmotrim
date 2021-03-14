<?php

namespace App\Http\Controllers\Vinograd;

use App\Http\Requests\Vinograd\CheckoutRequest;
use App\Models\Vinograd\DeliveryMethod;
use App\UseCases\CartService;
use App\UseCases\OrderService;
use Auth;
use App\Http\Controllers\Controller;
use View;

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
        if (!$this->cartService->getCart()->getItems()){
            return redirect()->route('vinograd.category')->withErrors(['error' => 'Корзина пуста.']);
        }
        return view('vinograd.checkout.delivery', [
                'deliverys' => DeliveryMethod::all(),
                'cart' => $this->cartService->getCart()
            ]);
    }

    public function deliveryForm($delivery_slug)
    {
        if (!$this->cartService->getCart()->getItems()){
            return redirect()->route('vinograd.category')->withErrors(['error' => 'Корзина пуста.']);
        }
        return view('vinograd.checkout.checkoutForm', [
            'delivery' => DeliveryMethod::where('slug', $delivery_slug)->first()
        ]);
    }

    public function checkout(CheckoutRequest $request)
    {
        if (!$this->cartService->getCart()->getItems()){
            return redirect()->route('vinograd.category')->withErrors(['error' => 'Корзина пуста.']);
        }
        try {
            $order = $this->service->checkout($request);
            $this->service->sendMail($order);

            //$route = (Auth::user()) ? 'vinograd.cabinet.home' : 'vinograd.category';
            return redirect()->
                    route((Auth::user()) ? 'vinograd.cabinet.home' : 'vinograd.category')->
                    with('status', 'Заказ сохранен. В ближайшее время мы с Вами свяжемся для уточнения деталей!');

//            if (Auth::user()){
//                return redirect()->route('vinograd.cabinet.home')->with('status', 'Заказ сохранен. В ближайшее время мы с Вами свяжемся для уточнения деталей!');
//
//                //return view('cabinet.index', ['order' => $order])->with('status', 'Заказ сохранен. В ближайшее время мы с Вами свяжемся для уточнения деталей!');
//            }
//            return redirect()->route('vinograd.category')->with('status', 'Заказ сохранен. В ближайшее время мы с Вами свяжемся для уточнения деталей!');

        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }
}
