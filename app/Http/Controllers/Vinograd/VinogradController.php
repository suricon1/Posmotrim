<?php

namespace App\Http\Controllers\Vinograd;

use App\Http\Requests\Vinograd\CategoryFilterRequest;
use App\Http\Requests\Vinograd\SortPostsRequest;
use App\Models\Blog\Post;
use App\Models\Vinograd\Category;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Vinograd\Comment;
use App\Models\Vinograd\Country;
use App\Models\Vinograd\Page;
use App\Models\Vinograd\Selection;
use App\Models\Vinograd\Slider;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\UseCases\LookService;
use Illuminate\Http\Request;

class VinogradController extends Controller
{
    public $productRep;

    public function __construct(ProductRepository $productRep)
    {
        $this->productRep = $productRep;
    }

    public function index(Request $request)
    {
        $categorys = Category::active()->get();

        return view('vinograd.index', [
            'products' => $this->productRep->getProductsByCategory($request, $categorys),
            'sliders' => Slider::all(),
            'categorys' => $categorys,
            'posts' => Post::orderByDesc('view')->active()->take(6)->get()
        ]);
    }

    public function product(LookService $service, $slug)
    {
        $product = $this->productRep->getProductBySlug($slug);
        $service->setCookieLook($product->id);   // Добавили в просмотренное

        return view('vinograd.product', [
            'product' => $product,
            'similar' => $this->productRep->getSimilarOnChunks($product->props),
            'comments' => Comment::getAllProductComments($product->id)
            ]);
    }

    public function category(SortPostsRequest $request, $page = '')
    {
        return view('vinograd.category', $this->temp($request, $page, false));
    }

    public function categorySlug(SortPostsRequest $request, $slug, $page = '')
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('vinograd.category', $this->temp($request, $page, $category));
    }

    public function country (SortPostsRequest $request, $slug, $page = '')
    {
        $category = Country::where('slug', $slug)->firstOrFail();
        return view('vinograd.category', $this->temp($request, $page, $category));
    }

    public function selection (SortPostsRequest $request, $slug, $page = '')
    {
        $category = Selection::where('slug', $slug)->firstOrFail();
        return view('vinograd.category', $this->temp($request, $page, $category));
    }

    public function categoryFilter(CategoryFilterRequest $request, $page = '')
    {
        $selections = $request->selection
            ? Selection::with('productsActive.modifications.property')->whereIn('id', $request->selection)->get()
            : [];
        $countrys = $request->country
            ? Country::with('productsActive.modifications.property')->whereIn('id', $request->country)->get()
            : [];

        return view('vinograd.filter', [
            'selections' => $selections,
            'countrys' => $countrys
        ]);
    }

    private function temp ($request, $page, $category)
    {
        return [
            'products' => $this->productRep->getSortProductByModifications($request, $page, $category),
            'category' => $category,
            'param' => $this->productRep->getParams($request),
            'grid_list' => $this->productRep->getGridList(),
            'ripening' => Category::$sortRipeningProducts,
            'sort' => Category::getSortArr(),
            'page' => $page
        ];
    }

    public function page($slug)
    {
        return view('vinograd.page', [
            'page' => Page::where('slug', $slug)->active()->firstOrFail()
        ]);
    }

    public function siteMap()
    {
        return view('vinograd.site_map', [
            'view' => cache()->remember('siteMapHTML', 30*24*60, function () {
                return view('vinograd.components.site_map', [
                    'categorys' => Category::with('products')->active()->get(),
                    'blogCategorys' => BlogCategory::with('postsActive')->active()->get(),
                    'pages' => Page::active()->get()
                ])->render();
            })
        ]);
    }

    public function currency($currency)
    {
        if (!in_array($currency, ['BYN', 'RUB', 'EUR', 'USD'])){
            return back();
        }
        Cookie::queue('cur_code', $currency, 86400);
        return back();
    }

    public function price()
    {
        return view('vinograd.price', [
            'categorys' => cache()->remember('priceListHTML', 30*24*60, function () {
                return Category::with([
                    'productsActive.modifications.property',
                    'productsActive.selection:id,name'
                ])->active()->get();
            })
        ]);
    }
}
