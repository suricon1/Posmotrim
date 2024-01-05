<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware'	=>	'admin'], function()
{
    Route::post('/ckeditor-upload-image', 'AppAjaxController@upload');

    Route::group(['prefix' => 'analytics', 'namespace' => 'Dashboard', 'as' => 'dashboard.'], function() {
        Route::get('/sorts', 'DashboardController@index')->name('sorts');
        Route::get('/orders_as_modification/{product_id}/{modification_id}/{price}', 'DashboardController@allOrdersAsModfication')->name('orders_as_modification');
        Route::get('/ordereds_as_modification/{product_id}/{modification_id}/{price}', 'OrderedsDashboardController@allOrderedsAsModfication')->name('ordereds_as_modification');

        Route::get('/ordereds', 'OrderedsDashboardController@index')->name('ordereds');
        Route::get('/select_orders', 'SelectOrdersController@selectOrdersByNumbers')->name('select_orders');
        Route::get('/modifications', 'ModificationsDashboardController@index')->name('modifications');
        Route::get('/deliverys', 'DeliverysDashboardController@index')->name('deliverys');

        Route::group(['as' => 'print.'], function() {
            Route::get('/print/{ids}', 'SelectOrdersController@selectOrders')->name('select_orders');
        });
    });

    Route::group(['prefix'=>'vinograd','namespace'=>'Vinograd'], function()
    {
        Route::get('/orders/pre_order_create', 'PreOrdersController@preCreate')->name('orders.pre.create');
        Route::get('/orders/pre_order_edit/{order_id}', 'PreOrdersController@preEdit')->name('orders.pre.edit');
        Route::post('/orders/pre_add_item/{order_id}', 'PreOrdersController@addItem')->name('orders.pre.add.item');
        Route::post('/orders/pre_update_item/{order_id}', 'PreOrdersController@updateItem')->name('orders.pre.update.item');
        Route::post('/orders/pre_delete_item/{order_id}', 'PreOrdersController@deleteItem')->name('orders.pre.delete.item');

        Route::resources([
            '/products' => 'ProductsController',
            '/categorys' => 'CategorysController',
            '/modifications' => 'ModificationsController',
            '/sliders' => 'SlidersController',
            '/pages' => 'PagesController',
            '/orders' => 'Order\OrdersController',
            '/deliverys' => 'DeliverysController',
            '/mails' => 'MailsController'
        ]);

        Route::get('/products/show_by_status/{status}', 'ProductsController@showByStatus')->name('products.show_by_status');

        Route::get('/categorys/create/{model}', 'CategorysController@create')->name('categorys.create');
        Route::get('/categorys/{id}/edit/{model}', 'CategorysController@edit')->name('categorys.edit');

        Route::group(['namespace'=>'Order'], function() {
            Route::group(['prefix' => 'orders', 'as' => 'orders.'], function() {
                Route::get('/status/{status}', 'OrdersController@index')->name('index.status');

                Route::post('/set-ajax-treck_code', 'OrdersTreckCodeController@setAjaxTreckCode')->name('set_ajax_treck_code');
                Route::post('/set_track_code/{order_id}', 'OrdersTreckCodeController@setTrackCode')->name('set.track_code');
                Route::post('/sent-status-mail', 'OrdersTreckCodeController@sentStatusMail')->name('sent.status.mail');

                Route::post('/currency-update', 'OrdersController@currencyUpdate')->name('currency_update');

                Route::post('/send-reply-mail', 'OrdersController@sendReplyMail')->name('send_reply_mail');

                Route::post('/add_item/{order_id}', 'OrdersItemController@addItem')->name('add.item');
                Route::post('/update_item/{order_id}', 'OrdersItemController@updateItem')->name('update.item');
                Route::post('/delete_item/{order_id}', 'OrdersItemController@deleteItem')->name('delete.item');

                Route::get('/delivery_edit/{order_id}', 'OrdersDeliveryController@deliveryEdit')->name('delivery.edit');
                Route::post('/delivery_update/{order_id}', 'OrdersDeliveryController@deliveryUpdate')->name('delivery.update');

                Route::post('/set-status', 'OrdersStatusController@setStatus')->name('set_status');
                Route::post('/set-ajax-status', 'OrdersStatusController@setAjaxStatus')->name('set_ajax_status');

                Route::post('/admin_note_edit', 'OrdersNoteController@noteEdit')->name('admin.note.edit');

                Route::get('/merge/{order_id}/{merge_order_id}', 'OrdersController@merge')->name('merge');

                Route::get('/repeat_order_create/{order_id}', 'OrdersController@repeatCreate')->name('repeat.create');



                Route::group(['as' => 'print.'], function() {
                    Route::get('/print/{id}', 'OrderPrintsController@order')->name('order');
                    Route::get('/print/nalozhka_blanck/{id}', 'OrderPrintsController@nalozhkaBlanck')->name('nalozhka_blanck');
                    Route::get('/print/nalozhka_sticker/{id}', 'OrderPrintsController@nalozhkaSticker')->name('nalozhka_sticker');
                    Route::get('/print/declared_sticker/{id}', 'OrderPrintsController@declaredSticker')->name('declared_sticker');
                    Route::get('/print/postal_belarus_sticker/{id}', 'OrderPrintsController@postalBelarusSticker')->name('postal_belarus_sticker');
                    Route::get('/print/small_package_sticker/{id}', 'OrderPrintsController@smallPackageSticker')->name('small_package_sticker');
                    Route::get('/print/small_package_sticker_2/{id}', 'OrderPrintsController@smallPackageSticker_2')->name('small_package_sticker_2');
                });
            });

            Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function() {
                Route::get('/admin_note_edit', 'OrdersNoteController@ajaxNoteEdit')->name('note.edit');
                Route::get('/ajax_print', 'OrderPrintsController@ajaxOrder')->name('print.order');
                Route::get('/build', 'OrdersController@setBuildDate')->name('build');
            });
        });

        Route::get('/products/toggle/{id}', 'ProductsController@toggle')->name('products.toggle');

        Route::post('/products/modification/add', 'ProductsController@modificationAdd')->name('products.modification.add');
        Route::post('/products/modification/edit', 'ProductsController@modificationEdit')->name('products.modification.edit');
        Route::post('/products/modification/delete', 'ProductsController@modificationDelete')->name('products.modification.delete');
        Route::get('/products/modification/set_to_zero', 'ProductsController@setToZero')->name('products.modification.set_to_zero');

        Route::get('/modifications/toggle/{id}', 'ModificationsController@toggle')->name('modifications.toggle');

        Route::get('/deliverys/toggle/{id}', 'DeliverysController@toggle')->name('deliverys.toggle');

        Route::get('/pages/toggle/{id}', 'PagesController@toggle')->name('pages.toggle');
        Route::get('/pages/up/{id}', 'PagesController@moveUp')->name('pages.move.up');
        Route::get('/pages/down/{id}', 'PagesController@moveDown')->name('pages.move.down');

        Route::get('/comments', 'CommentsController@index')->name('vinograd.comments.index');
        Route::get('/comments/toggle/{id}', 'CommentsController@toggle')->name('vinograd.comments.toggle');
        Route::delete('/comments/{id}/destroy', 'CommentsController@destroy')->name('vinograd.comments.destroy');
        Route::get('/comments/{id}/edit', 'CommentsController@edit')->name('vinograd.comments.edit');
        Route::put('/comments/update', 'CommentsController@update')->name('vinograd.comments.update');
    });

    Route::group(['prefix'=>'blog','namespace'=>'Blog'], function()
    {
        Route::post('/blog-content-editable', 'PostsController@contentEditable')->name('blog.content.editable');

        Route::resources([
            '/posts' => 'PostsController',
            '/comments' => 'CommentsController'
        ]);
        Route::resource('categorys', 'CategorysController')->names('blog.categorys');

        Route::get('/posts/toggle/{id}', 'PostsController@toggle')->name('posts.toggle');
        Route::get('/comments/toggle/{id}', 'CommentsController@toggle')->name('blog.comments.toggle');

    });
});
