<?php

Route::group(['namespace' => 'Vinograd', 'as' => 'vinograd.'], function() {

    Route::get('/', 'VinogradController@index')->name('home');

    Route::get('/product/{slug}.html', 'VinogradController@product')->name('product');

    Route::get('/sitemap.html', 'VinogradController@siteMap')->name('sitemap');

    Route::get('/currency/{currency}', 'VinogradController@currency')->name('currency');

    Route::group(['prefix'=>'compare', 'as' => 'compare.'], function() {
        Route::get('/', 'CompareController@index')->name('index');
        Route::post('/add', 'CompareController@add')->name('add');
        Route::post('/delete', 'CompareController@remove')->name('delete');
    });

    Route::get('/price', 'VinogradController@price')->name('price');

    Route::get('/turbo.yml', 'TurboController@turbo')->name('turbo');

    Route::get('/page/{slug}.html', 'VinogradController@page')->name('page')->where(['slug'=>'[a-z0-9_-]*']);

    Route::get('/contact.html', 'ContactController@contactForm')->name('contactForm');
    Route::post('/contact.html', 'ContactController@store')->name('contactStore');

    Route::get('/category.html', 'VinogradController@category')->name('category');
    Route::get('/category/page-{page}.html', 'VinogradController@category')->where(['page'=>'[0-9]*'])->name('category.page');
    Route::get('/category/{slug}.html', 'VinogradController@categorySlug')->name('category.category');
    Route::get('/category/{slug}/page-{page}.html', 'VinogradController@categorySlug')->where(['slug'=>'[a-z0-9_-]*', 'page'=>'[0-9]*'])->name('category.category.page');

    Route::get('/country/{slug}.html', 'VinogradController@country')->name('category.country');
    Route::get('/country/{slug}/page-{page}.html', 'VinogradController@country')->where(['slug'=>'[a-z0-9_-]*', 'page'=>'[0-9]*'])->name('category.country.page');

    Route::get('/selection/{slug}.html', 'VinogradController@selection')->name('category.selection');
    Route::get('/selection/{slug}/page-{page}.html', 'VinogradController@selection')->where(['slug'=>'[a-z0-9_-]*', 'page'=>'[0-9]*'])->name('category.selection.page');

    Route::post('/category_filter.html', 'VinogradController@categoryFilter')->name('category.filter');

    //Route::post('/comment', 'CommentController@store')->name('comment.add');
    Route::post('/ajax/comment', 'CommentController@ajaxStore')->name('ajax-comment.add');

    Route::match(['get', 'post'],'/search', 'SearchController@index')->name('search');

    Route::group(['prefix'=>'cart', 'as' => 'cart.'], function() {
        Route::get('/', 'CartController@index')->name('ingex');
        Route::post('/add/', 'CartController@addToCart')->name('add');
        Route::post('/remove', 'CartController@remove')->name('remove');
        Route::post('/quantity', 'CartController@quantity')->name('quantity');
    });

    Route::group(['middleware'	=>	'auth'], function(){
        Route::post('/ajax/comment-edit', 'CommentController@ajaxEdit');
        Route::post('/ajax/comment-delete', 'CommentController@ajaxDelete');

        Route::post('/logout', 'AuthController@logout')->name('logout');

        Route::group(['namespace'=>'Cabinet', 'prefix'=>'cabinet', 'as' => 'cabinet.'], function() {
            Route::get('/', 'DashboardController@index')->name('home');
            Route::get('/order-view/{order_id}', 'DashboardController@show')->name('order.view')->where(['order_id'=>'[0-9]*']);
            Route::post('/order-destroy/{order_id}', 'DashboardController@destroy')->name('order.destroy')->where(['order_id'=>'[0-9]*']);
            Route::post('/delivery-update/{id}', 'DashboardController@update')->name('delivery.update')->where(['id'=>'[0-9]*']);

            Route::group(['prefix'=>'wishlist', 'as' => 'wishlist.'], function() {
                Route::get('/', 'WishlistController@index')->name('ingex');
                Route::get('/add/{id}', 'WishlistController@addToWishlist')->name('add')->where('id','[0-9]*');
                Route::post('/delete', 'WishlistController@deleteFromWishlist')->name('delete');
            });
        });
    });

    Route::group(['middleware'	=>	'guest'], function(){
        Route::get('/register', 'AuthController@registerForm')->name('register.form');
        Route::post('/register', 'AuthController@register')->name('register');
        Route::get('/user-verify/{token}', 'AuthController@verify')->name('register.verify');
        Route::get('/login','AuthController@loginForm')->name('login.form');
        Route::post('/login', 'AuthController@login')->name('login');
    });

    Route::group(['prefix'=>'checkout', 'as' => 'checkout.'], function() {
        Route::get('/delivery', 'CheckoutController@delivery')->name('delivery');
        Route::get('/delivery/{delivery_slug}', 'CheckoutController@deliveryForm')->name('deliveryForm');
        Route::post('/checkout', 'CheckoutController@checkout')->name('checkout');
    });

    Route::get('/ajax/login-form', 'AjaxController@loginForm')->name('ajax.login-form');
    Route::post('/ajax/login', 'AjaxController@login');

    Route::get('/ajax/grid-list', 'AjaxController@gridList')->name('ajax.grid-list');

    Route::get('/ajax/pre-order-form', 'AjaxController@preOrderForm')->name('ajax.pre-order-form');
    Route::post('/ajax/pre-order', 'AjaxController@preOrder')->name('ajax.pre-order');

    Route::get('/ajax/singleProduct', 'AjaxController@modalProduct');

    Route::get('/ajax/cart-ajax', 'AjaxController@cartAjax');
});

Route::post('/subscribe', 'SubsController@subscribe')->name('subscribers');
Route::get('/verify/{token}', 'SubsController@verify')->name('verify');


Route::group(['namespace' => 'Blog', 'prefix'=>'blog', 'as' => 'blog.'], function() {

    Route::get('/', 'BlogController@index')->name('home');
    Route::get('/page-{page}', 'BlogController@index')->where(['page'=>'[0-9]*'])->name('home.page');
    Route::get('/{slug}.html', 'BlogController@post')->where(['slug'=>'[a-z0-9_-]*'])->name('post');

    Route::get('/category/{slug}', 'BlogController@category')->where(['slug'=>'[a-z0-9_-]*'])->name('category');
    Route::get('/category/{slug}/page-{page}', 'BlogController@category')->where(['slug'=>'[a-z0-9_-]*', 'page'=>'[0-9]*'])->name('category.page');

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
