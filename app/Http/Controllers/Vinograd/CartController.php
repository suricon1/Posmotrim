<?php

namespace App\Http\Controllers\Vinograd;

use App\Repositories\ProductRepository;
use App\UseCases\CartService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CartController extends Controller
{
    private $products;
    private $service;

    public function __construct(CartService $service, ProductRepository $products)
    {
        $this->products = $products;
        $this->service = $service;
    }

    public function index()
    {
        return view('vinograd.cart', [
            'cart' => $this->service->getCart()
        ]);
    }

    public function addToCart(Request $request)
    {
        $v = Validator::make($request->all(), [
            'product_id'      => 'required|integer|exists:vinograd_products,id',
            'modification_id' => 'required|integer|exists:vinograd_product_modifications,id',
            'quantity'        => ['required', 'integer', 'regex:/^[1-9]\d*$/']
        ]);

        if ($v->fails()) {
            return ($request->ajax())
                //? ['errors' => $v->errors()]
                ? ['errors' => 'Что-то пошло не так. Перегрузите страницу и попробуйте снова.']
                : redirect()->back()->withErrors($v);
        }

        try {
            $product = $this->products->get($request->get('product_id'));
            $modification = $this->products->getModification($request->get('modification_id'));

            $this->service->add($product, $modification, $request->get('quantity'));
            //return redirect()->back()->with('status', 'Товар добавлен в корзину!');
            return ($request->ajax())
                ? ['succes' => view('vinograd.components.mini-cart', ['cart' => $this->service->getCart()])->render()]
                : redirect()->back()->with('status', 'Товар добавлен в корзину!');
        } catch (\DomainException $e) {
            return ($request->ajax())
                ? ['errors' => $e->getMessage()]
                : back()->withErrors([$e->getMessage()]);
            //return ['errors' => $e->getMessage()];
            //return back()->withErrors([$e->getMessage()]);
        }
    }


    public function quantity(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id'       => ['required', 'regex:/^[a-z0-9]*$/i'],
            'quantity' => ['required', 'integer', 'regex:/^[1-9]\d*$/']
        ]);
        if ($v->fails()) {
            return ($request->ajax())
                ? ['errors' => 'Что-то пошло не так. Перегрузите страницу и попробуйте снова.']
                : redirect()->back()->withErrors($v);
        }

        try {
            $this->service->set($request->get('id'), $request->get('quantity'));

            return ($request->ajax())
                ? ['succes' => [
                    'mini_cart' => view('vinograd.components.mini-cart', ['cart' => $this->service->getCart()])->render(),
                    'cart' => view('vinograd.components._cart', ['cart' => $this->service->getCart()])->render()
                    ]
                ]
                : redirect()->route('vinograd.cart.ingex')->with('status', 'Корзина обновлена!');
        } catch (\DomainException $e) {
            return ($request->ajax())
                ? ['errors' => $e->getMessage()]
                : back()->withErrors([$e->getMessage()]);
        }
    }

    public function remove(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => ['required', 'regex:/^[a-z0-9]*$/i']
        ]);
        if ($v->fails()) {
            return ($request->ajax())
                ? ['errors' => 'Что-то пошло не так. Перегрузите страницу и попробуйте снова.']
                : redirect()->back()->withErrors($v);
        }

        try {
            $this->service->remove($request->get('id'));
            return ($request->ajax())
                ? ['succes' => [
                    'mini_cart' => view('vinograd.components.mini-cart', ['cart' => $this->service->getCart()])->render(),
                    'cart' => view('vinograd.components._cart', ['cart' => $this->service->getCart()])->render()
                    ]
                ]
                : redirect()->back();
        } catch (\DomainException $e) {
            return ($request->ajax())
                ? ['errors' => $e->getMessage()]
                : back()->withErrors([$e->getMessage()]);
        }
    }
}
