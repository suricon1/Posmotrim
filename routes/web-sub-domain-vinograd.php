<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\SubsController;
use App\Http\Controllers\Vinograd\AjaxController;
use App\Http\Controllers\Vinograd\AuthController;
use App\Http\Controllers\Vinograd\Cabinet\DashboardController;
use App\Http\Controllers\Vinograd\Cabinet\WishlistController;
use App\Http\Controllers\Vinograd\CartController;
use App\Http\Controllers\Vinograd\CheckoutController;
use App\Http\Controllers\Vinograd\CommentController;
use App\Http\Controllers\Vinograd\CompareController;
use App\Http\Controllers\Vinograd\ContactController;
use App\Http\Controllers\Vinograd\SearchController;
use App\Http\Controllers\Vinograd\VinogradController;
use App\Http\Middleware\CartEmpty;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'vinograd.'], function() {
    Route::controller(VinogradController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/product/{slug}.html', 'product')->name('product');
        Route::get('/sitemap.html', 'siteMap')->name('sitemap');
        Route::get('/currency/{currency}', 'currency')->name('currency');
        Route::get('/price', 'price')->name('price');
        Route::get('/page/{slug}.html', 'page')->name('page')->where(['slug'=>'[a-z0-9_-]*']);
        Route::get('/category.html', 'category')->name('category');
        Route::get('/category/page-{page}.html', 'category')->where(['page'=>'[0-9]*'])->name('category.page');
        Route::get('/category/{slug}.html', 'categorySlug')->name('category.category');
        Route::get('/category/{slug}/page-{page}.html', 'categorySlug')->where(['slug'=>'[a-z0-9_-]*', 'page'=>'[0-9]*'])->name('category.category.page');
        Route::get('/country/{slug}.html', 'country')->name('category.country');
        Route::get('/country/{slug}/page-{page}.html', 'country')->where(['slug'=>'[a-z0-9_-]*', 'page'=>'[0-9]*'])->name('category.country.page');
        Route::get('/selection/{slug}.html', 'selection')->name('category.selection');
        Route::get('/selection/{slug}/page-{page}.html', 'selection')->where(['slug'=>'[a-z0-9_-]*', 'page'=>'[0-9]*'])->name('category.selection.page');
        Route::post('/category_filter.html', 'categoryFilter')->name('category.filter');
    });

    Route::controller(CompareController::class)->group(function () {
        Route::group(['prefix'=>'compare', 'as' => 'compare.'], function() {
            Route::get('/', 'index')->name('index');
            Route::post('/add', 'add')->name('add');
            Route::post('/delete', 'remove')->name('delete');
        });
    });

    Route::controller(ContactController::class)->group(function () {
        Route::get('/contact.html', 'contactForm')->name('contactForm');
        Route::post('/contact.html', 'store')->name('contactStore');
    });

    Route::controller(CommentController::class)->group(function () {
        //Route::post('/comment', 'store')->name('comment.add');
        Route::post('/ajax/comment', 'ajaxStore')->name('ajax-comment.add');
    });

    Route::match(['get', 'post'],'/search', [SearchController::class, 'index'])->name('search');

    Route::controller(CartController::class)->group(function () {
        Route::group(['prefix'=>'cart', 'as' => 'cart.'], function() {
            Route::get('/', 'index')->name('ingex');
            Route::post('/add/', 'addToCart')->name('add');
            Route::post('/remove', 'remove')->name('remove');
            Route::post('/quantity', 'quantity')->name('quantity');
        });
    });

    Route::middleware(['auth'])->group(function () {
        Route::controller(CommentController::class)->group(function () {
            Route::post('/ajax/comment-edit', 'ajaxEdit');
            Route::post('/ajax/comment-delete', 'ajaxDelete');
        });

        Route::group(['prefix'=>'cabinet', 'as' => 'cabinet.'], function() {
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/', 'index')->name('home');
                Route::get('/order-view/{order_id}', 'show')->name('order.view')->where(['order_id'=>'[0-9]*']);
                Route::post('/order-destroy/{order}', 'destroy')->name('order.destroy');
                Route::post('/delivery-update', 'update')->name('delivery.update');
            });

            Route::group(['prefix'=>'wishlist', 'as' => 'wishlist.'], function() {
                Route::controller(WishlistController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/add/{id}', 'addToWishlist')->name('add')->where('id','[0-9]*');
                    Route::post('/delete', 'deleteFromWishlist')->name('delete');
                });
            });
        });
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

//    Route::group(['middleware'	=>	'auth'], function(){
//        Route::post('/logout', 'AuthController@logout')->name('logout');
//    });

    Route::middleware(['guest'])->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('/register', 'registerForm')->name('register.form');
            Route::post('/register', 'register')->name('register');
            Route::get('/user-verify/{token}', 'verify')->name('register.verify');
            Route::get('/login','loginForm')->name('login.form');
            Route::post('/login', 'login')->name('login');
        });
    });

    Route::group(['middleware' => 'cart_empty', 'prefix'=>'checkout', 'as' => 'checkout.'], function() {
        Route::controller(CheckoutController::class)->group(function () {
            Route::get('/delivery', 'delivery')->name('delivery');
            Route::get('/delivery/{delivery_slug}', 'deliveryForm')->name('deliveryForm');
            Route::post('/checkout', 'checkout')->name('checkout');
        });
    });

    Route::controller(AjaxController::class)->group(function () {
        Route::get('/ajax/login-form', 'loginForm')->name('ajax.login-form');
        Route::post('/ajax/login', 'login');

        Route::get('/ajax/grid-list', 'gridList')->name('ajax.grid-list');

        Route::get('/ajax/example-length', 'exampleLength')->name('ajax.example-length');

        Route::get('/ajax/pre-order-form', 'preOrderForm')->name('ajax.pre-order-form');
        Route::post('/ajax/pre-order', 'preOrder')->name('ajax.pre-order');

        Route::get('/ajax/singleProduct', 'modalProduct');

        Route::get('/ajax/cart-ajax', 'cartAjax');
    });
});

Route::controller(SubsController::class)->group(function () {
    Route::post('/subscribe', 'subscribe')->name('subscribers');
    Route::get('/verify/{token}', 'verify')->name('verify');
});

//Route::group(['namespace' => 'Vinograd', 'middleware'	=>	'guest'], function(){
//    Route::get('/login','AuthController@loginForm')->name('login');    //  Разобраться с перенаправлением
//});

Route::group(['prefix'=>'blog', 'as' => 'blog.'], function() {
    Route::controller(BlogController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/page-{page}', 'index')->where(['page'=>'[0-9]*'])->name('home.page');
        Route::get('/{slug}.html', 'post')->where(['slug'=>'[a-z0-9_-]*'])->name('post');

        Route::get('/category/{slug}', 'category')->where(['slug'=>'[a-z0-9_-]*'])->name('category');
        Route::get('/category/{slug}/page-{page}', 'category')->where(['slug'=>'[a-z0-9_-]*', 'page'=>'[0-9]*'])->name('category.page');
    });
});


    //  Создает символьную ссылку на storage на продакшене
//    Route::get('/artisan/storage', function() {
//        $command = 'storage:link';
//        $result = Artisan::call($command);
//        return Artisan::output();
//    });

Route::get('/clear', function() {
    //Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Кэш очищен.";
});

//Route::get('/currency', function() {
//    Artisan::call('currency:exchange');
//    return "Обноваление курса валют.";
//});

/*
Route::get('/artisan/{cmd}', function($cmd) {
    $cmd = trim(str_replace("-",":", $cmd));
    $validCommands = ['cache:clear', 'optimize', 'route:cache', 'route:clear', 'view:clear', 'config:cache'];
    if (in_array($cmd, $validCommands)) {
        Artisan::call($cmd);
        return "<h1>Ran Artisan command: {$cmd}</h1>";
    } else {
        return "<h1>Not valid Artisan command</h1>";
    }
});
*/
