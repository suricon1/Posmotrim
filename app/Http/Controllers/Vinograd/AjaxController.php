<?php

namespace App\Http\Controllers\Vinograd;

use App\Http\Requests\Vinograd\GridListRequest;
use App\Http\Requests\Vinograd\PreOrderRequest;
use App\Models\Vinograd\Contact;
use App\Models\Vinograd\Product;
use App\Notifications\ContactMail;
use App\Repositories\ProductRepository;
use App\UseCases\CartService;
use Auth;
use Cookie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;

class AjaxController extends Controller
{
    protected $layout = false;

    public $productRep;

    public function __construct(ProductRepository $productRep)
    {
        $this->productRep = $productRep;
    }

    public function loginForm()
    {
        return view('components.login-form');
    }

    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email'	=>	'required|email',
            'password'	=>	'required'
        ]);
        if ($v->fails())
        {
            return ['errors' => $v->errors()];
        }

        if(Auth::attempt([
            'email'	=>	$request->get('email'),
            'password'	=>	$request->get('password')
        ], $request->filled('remember')))
        {
            return ['succes' =>'ok'];
        }
        return ['error' =>'<div class="alert alert-danger" id="error"> Неправильный логин или пароль</div>'];
    }


    public function modalProduct(Request $request)
    {
        $this->validate($request, [
                'product_id'	=>	'required|integer|exists:vinograd_products,id'
            ],
            [
                'product_id.required' => 'Произошла ошибка. Перегрузите страницу и повторите попытку.',
                'product_id.integer' => 'Произошла ошибка. Перегрузите страницу и повторите попытку.',
                'product_id.exists' => 'Произошла ошибка. Перегрузите страницу и повторите попытку.'
            ]);

        $product = Product::active()->find($request->get('product_id'));
        if(!$product){
            return ['error' =>'Произошла ошибка. Перегрузите страницу и повторите попытку.'];
        }

        return ['succes' => view('vinograd.components.modal-single-product', [
            'product' =>$product
        ])->render()];
    }

    public function gridList(GridListRequest $request)
    {
            if ($request->get('category')){
                $category = getModelName($request->get('model'))::where('id', $request->get('category'))->first();
                $products = $this->productRep->getSortProductByModifications($request, '', $category);
            }else{
                $products = $this->productRep->getSortProductByModifications($request, '');
            }
            Cookie::queue('grid_list', $request->get('grid_list'), 86400);
//            $path = '/' . $request->get('model') ?: 'category' . '/' . $request->get('category');

            return [
                'succes' => view('vinograd.components.product-'.$request->get('grid_list').'-view', [
                        'category' => ($request->get('category')) ? $category : false,
                        'products' => $products,
//                        'products' => $products->withPath($path),
                        'page' => $request->get('page'),
                        'param' => $this->productRep->getParams($request)
                    ])->render()];
    }

    public function preOrderForm()
    {
        $pre_order_id = Cookie::get('pre_order_id');
        $pre_order = ($pre_order_id) ? Contact::find($pre_order_id) : null;
        return view('components.pre-order', ['pre_order' => $pre_order]);
    }

    public function preOrder(PreOrderRequest $request)
    {
        try {
            $contact = Contact::find(Cookie::get('pre_order_id'));

            if($contact){
                $contact->name = $request->name;
                $contact->email = $request->email;
                $contact->phone = $request->phone;
                $contact->message = strip_tags($request->message);
                $contact->date_at = time();
                $contact->mark_as_read = 1;
                $contact->save();
            } else {
                $contact = Contact::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'message' => strip_tags($request->message),
                    'date_at' => time(),
                    'mark_as_read' => 1
                ]);
                Cookie::queue('pre_order_id', $contact->id, 86400);
            }
            $contact->notify(new ContactMail($contact));
            return ['succes' =>'ok'];

        } catch (\Exception $e) {
            return ['errors' => $e->getMessage()];
        }
    }

    public function exampleLength (Request $request)
    {
        $v = Validator::make($request->all(), [
            'example_length' => 'required|in:21,42,64'
        ]);
        if ($v->fails()) {
            return ['errors' => $v->errors()];
        }

        try {
            Cookie::queue('example_length', $request->example_length, 86400);
            return ['succes' =>'ok'];
        } catch (\Exception $e) {
            return ['errors' => $e->getMessage()];
        }
    }

    public function cartAjax(CartService $service, Request $request)
    {
        //$categorys = Category::active()->get();


        //return $this->productRep->getProductsByCategoryJsonSerialize($request, $categorys);

        $arr = [];
        $cart = $service->getCart();

        $arr['signature'] = signature();
        $arr['amount'] = $cart->getAmount();
        $arr['cost_total'] = currency($cart->getCost()->getTotal());
        foreach($cart->getItems() as $key => $item){
            $product = $item->getProduct();
            $modification = $item->getModification();

            $arr['items'][$key]['href'] = route('vinograd.product', ['slug' => $product->slug]);
            $arr['items'][$key]['src'] = asset($product->getImage('100x100'));
            $arr['items'][$key]['product_name'] = $product->name;
            $arr['items'][$key]['modification_name'] = $modification->name;
            $arr['items'][$key]['quantity'] = $item->getQuantity();
            $arr['items'][$key]['price'] = currency($item->getPrice());
            $arr['items'][$key]['id'] = $item->getId();
        }
        return $arr;
    }
}
