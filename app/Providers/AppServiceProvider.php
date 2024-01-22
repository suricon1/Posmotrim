<?php

namespace App\Providers;

use App\cart\Cart;
use App\cart\cost\calculator\SimpleCost;
use App\cart\storage\SessionStorage;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Vinograd\Comment;
use App\Models\Vinograd\Contact;
use App\Models\Vinograd\Currency;
use App\Models\Vinograd\Page;
use App\Models\Vinograd\WishlistItem;
use App\Repositories\ProductRepository;
use App\UseCases\CartService;
use App\UseCases\LookService;
use Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(CartService $service)
    {
        view()->composer('layouts.vinograd-left', function($view) use ($service) {
            $view->with('categorys', ProductRepository::getAllCategorysOfCountProducts());
            $view->with('categorys_blog_menu', BlogCategory::active()->pluck('name', 'slug')->all());
            $view->with('pages', Page::active()->orderBy('sort')->pluck('name', 'slug')->all());
            $view->with('cart', $service->getCart());
            $view->with('currency', Currency::where('code', '<>', realCurr()->code)->get());
            $view->with('userWishlistItemsCount', Auth::user() ? WishlistItem::userWishlistItemsCount(Auth::user()->id) : false);
        });

        $this->getLooksProduct();
        $this->siteSidebar();
        $this->adminSidebar();
        $this->paginationPattern();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Cart::class, function () {
            return new Cart(new SessionStorage('cart'), new SimpleCost());
        });
    }

    private function getLooksProduct()
    {
        view()->composer('vinograd.components.look-product', function($view) {
            $view->with('looks', LookService::getLookProducts());
        });
    }

    //  Сайт Бар на сайте
    private function siteSidebar()
    {
        view()->composer('vinograd.components.left_sidebar', function($view) {
            //$view->with('featured', ProductRepository::getFeatured());
            $view->with('countrys', ProductRepository::getAllCountrysOfCountProducts());
            $view->with('selections', ProductRepository::getAllSelectionsOfCountProducts());
        });
    }

    //  Сайт Бар в админке
    private function adminSidebar()
    {
        view()->composer('admin.components.sidebar', function($view) {
            $view->with('new_contact', Contact::where('mark_as_read', 1)->count());
            $view->with('new_comment_product', Comment::getNewCommentsCount('product_id'));
            $view->with('new_comment_post', Comment::getNewCommentsCount('post_id'));
        });
    }

    //  Паттерны в пагинатор
    private function paginationPattern()
    {
        view()->composer('components.pagination', function($view) {
            $view->with('pattern', [
                '~/page-\d+\.html\?page=1~',
                '~/page-\d+\.html\?page=(\d+)~',
                '~.html\?page=1~',
                '~.html\?page=(\d+)~',
                '~/page-\d+\?page=1~',
                '~/page-\d+\?page=(\d+)~',
                '~\?page=1~',
                '~\?page=(\d+)~'
            ]);
            $view->with('replace', [
                '.html',
                '/page-$1.html',
                '.html',
                '/page-$1.html',
                '',
                '/page-$1',
                '',
                '/page-$1'
            ]);
        });
    }
}
