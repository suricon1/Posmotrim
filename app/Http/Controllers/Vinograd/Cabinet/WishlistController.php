<?php

namespace App\Http\Controllers\Vinograd\Cabinet;

use App\Http\Controllers\Controller;
use App\UseCases\WishlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    private $service;

    public function __construct(WishlistService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('cabinet.wishlist', [
            'products' => $this->service->getAllWishlistProduct()
        ]);
    }

    public function addToWishlist($id)
    {
        try {
            $this->service->add(Auth::user()->id, $id);
            return redirect()->back()->with('status', 'Товар добавлен в избранное!');
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function deleteFromWishlist(Request $request)
    {
        $this->validate($request, [
           'product_id' => 'required|integer|exists:vinograd_products,id'
        ]);
        try {
            $this->service->remove(Auth::user()->id, $request->get('product_id'));
            return redirect()->back()->with('status', 'Товар удален!');
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

}
