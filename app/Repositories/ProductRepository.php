<?php

namespace App\Repositories;

use App\Models\Vinograd\Category;
use App\Models\Vinograd\Modification;
use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Product;
use Cookie;

class ProductRepository
{
    public function get($id): Product
    {
        if (!$product = Product::find($id)) {
            throw new \DomainException('Такой товар не существует.');
        }
        return $product;
    }

    public function getProductBySlug($slug): Product
    {
        return Product::
            with('category:id,name,slug', 'country:id,name,slug', 'selection:id,name,slug', 'modifications.property')->
//            with(['modifications' => function ($query) {
//                $query->where('quantity', '>=', 0);
//            }])->
            where('slug', $slug)->
            active()->
            firstOrFail();
    }

    public function getAllProducts()
    {
        return Product::with('modifications', 'category')->active()->orderBy('name')->get();
    }

    public function getProductsForCompare($ids)
    {
        return Product::with('modifications', 'category')->active()->whereIn('id', $ids)->get();
    }

    public function getProductsByCategory($request, $categorys)
    {
        return cache()->remember('home_page', 30*24*60, function () use($request, $categorys) {
            foreach ($categorys as $category) {
                $products[$category->slug] = $this->getSortProductByModifications($request, null, $category, 10);
            }
            return $products;
        });
    }

    public function getSimilarOnChunks($props)
    {
        if(!array_key_exists('similar', $props) || !$props['similar']){
            return false;
        }

        $products = Product::query()
            ->select('id', 'slug', 'name')
            ->with('modifications.property')
            ->whereIn('id', $props['similar'])
            ->active()
            ->get();

        return array_filter([
            //  Делим коллекцию на chunk
            0 => $products->nth(3),
            1 => $products->nth(3, 1),
            2 => $products->nth(3, 2)
        ], function($item) {
            //  Возвращаем не пустые chunk
            return $item->isNotEmpty();
        });
    }

    public function getProductsByCategoryJsonSerialize($request, $categorys)
    {
        foreach ($categorys as $category)
        {
            $products[$category->slug] = $this->getSortProductByModifications($request, null, $category, $per_page = 10)->jsonSerialize();
        }
        return $products;
    }

    public function getModification($id)
    {
        if (!$modification = Modification::find($id)) {
            throw new \DomainException('Такой модификации не существует.');
        }
        return $modification;
    }

    public function isNotClosedOrders()
    {
        if(Order::whereIn('current_status', [1, 8])->exists()){
            throw new \DomainException('Еще есть не закрытые заказы!');
        }
    }

    public static function getFeatured()
    {
        return Product::with('modifications.property')->active()->where('is_featured', '1')->take(9)->get();
    }

    public function getParams($request)
    {
        if (!$request->get('ripening_by') && !$request->get('order_by')) return '';
        return  '?order_by='.$request->get('order_by').'&ripening_by='.$request->get('ripening_by');
    }

    public function getSort($request)
    {
        return($request->get('order_by'))
            ? current(array_column(Category::$sortProductList, $request->order_by))
            : false;
    }

    public function getGridList()
    {
        $grid_list = Cookie::get('grid_list');
        return $grid_list ?: 'small_list';
    }

    public function getSortProductByModifications($request, $page, $category = null, $per_page = '')
    {
        if (!$per_page) {
            $per_page = Cookie::get('example_length') ?: 21;
        }
        return Product::
            with('modifications.property')->
            leftJoin('vinograd_product_modifications AS modifications', function ($join) {
                $join->on('vinograd_products.id', '=', 'modifications.product_id')
                    ->where('modifications.quantity', '>', 0);
            })->
            selectRaw('vinograd_products.id, vinograd_products.name, vinograd_products.slug, vinograd_products.description,
                                                                Case COUNT(`modifications`.`id`) When 0 Then 0 Else 1 END AS `existence`')->
            active()->
            groupBy('vinograd_products.id', 'vinograd_products.name', 'vinograd_products.slug', 'vinograd_products.description', 'vinograd_products.ripening')->
            ripening($request)->
            sort($this->getSort($request))->
            category($request, $category)->
            paginate($per_page, ['*'], 'page', $page);
    }

    public static function getAllCategorysOfCountProducts()
    {
        return cache()->remember('categorys_category', 30*24*60, function () {
            return Product::leftJoin('vinograd_categorys AS category', function ($join) {
                        $join->on('vinograd_products.category_id', '=', 'category.id');
                    })
                ->selectRaw('category.id, category.name, category.slug, COUNT(`vinograd_products`.`id`) AS `count`')
                ->where('vinograd_products.status', 0)
                ->groupBy('category.name', 'category.id', 'category.slug')
                ->get()
                ->toArray();
        });
    }

    public function save(Product $product): void
    {
        if (!$product->modifications()->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function categoryExist($model, $id)
    {
        if (Product::where(strtolower($model) .'_id', $id)->exists()) {
            throw new \RuntimeException('Эту категорию нельзя удалить!');
        }
    }
}
