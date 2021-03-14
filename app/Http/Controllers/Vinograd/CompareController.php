<?php

namespace App\Http\Controllers\Vinograd;

use App\Http\Controllers\Controller;
use App\Models\Vinograd\Product;
use App\UseCases\ProductService;
use Validator;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index(ProductService $service)
    {
        $compares = $service->getCompares();
        //dd(count($compares[0]));
        return view('vinograd.compare', [
            'compares' => $compares
        ]);
    }

    public function add(Request $request, ProductService $service)
    {
        $v = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:vinograd_products,id'
        ]);
        if ($v->fails()) {
            return ['errors' => $v->errors()];
        }

        return [
            'succes' => view('vinograd.components._compare', ['compares' => $service->addCompare($request->product_id)])->render(),
            'quantity' => $service->quantityCompares()
        ];
    }

    public function remove(Request $request, ProductService $service)
    {
        $v = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:vinograd_products,id'
        ]);
        if ($v->fails()) {
            return ['errors' => $v->errors()];
        }

        return [
            'succes' => view('vinograd.components._compare-table', ['compares' => $service->removeCompare($request->product_id)])->render(),
            'quantity' => $service->quantityCompares()
        ];
    }
}
