<?php

use App\Http\Controllers\Admin\AppAjaxController;
use App\Http\Controllers\Admin\Blog\PostsController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Dashboard\DeliverysDashboardController;
use App\Http\Controllers\Admin\Dashboard\ModificationsDashboardController;
use App\Http\Controllers\Admin\Dashboard\OrderedsDashboardController;
use App\Http\Controllers\Admin\Dashboard\SelectOrdersController;
use App\Http\Controllers\Admin\Vinograd\CategorysController;
use App\Http\Controllers\Admin\Blog\CategorysController as BlogCategorysController;
use App\Http\Controllers\Admin\Vinograd\CommentsController;
use App\Http\Controllers\Admin\Blog\CommentsController as BlogCommentsController;
use App\Http\Controllers\Admin\Vinograd\DeliverysController;
use App\Http\Controllers\Admin\Vinograd\MailsController;
use App\Http\Controllers\Admin\Vinograd\ModificationsController;
use App\Http\Controllers\Admin\Vinograd\Order\OrderPrintsController;
use App\Http\Controllers\Admin\Vinograd\Order\OrdersController;
use App\Http\Controllers\Admin\Vinograd\Order\OrdersDeliveryController;
use App\Http\Controllers\Admin\Vinograd\Order\OrdersItemController;
use App\Http\Controllers\Admin\Vinograd\Order\OrdersNoteController;
use App\Http\Controllers\Admin\Vinograd\Order\OrdersStatusController;
use App\Http\Controllers\Admin\Vinograd\Order\OrdersTreckCodeController;
use App\Http\Controllers\Admin\Vinograd\PagesController;
use App\Http\Controllers\Admin\Vinograd\PreOrdersController;
use App\Http\Controllers\Admin\Vinograd\ProductsController;
use App\Http\Controllers\Admin\Vinograd\SlidersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['admin'])->group(callback: function () {
    Route::group(['prefix' => 'admin'], function() {

        Route::post('/ckeditor-upload-image', [AppAjaxController::class, 'upload']);

        Route::group(['prefix' => 'analytics', 'as' => 'dashboard.'], function() {
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/sorts', 'index')->name('sorts');
                Route::get('/orders_as_modification/{product_id}/{modification_id}/{price}', 'allOrdersAsModfication')->name('orders_as_modification');
            });

            Route::controller(OrderedsDashboardController::class)->group(function () {
                Route::get('/ordereds_as_modification/{product_id}/{modification_id}/{price}', 'allOrderedsAsModfication')->name('ordereds_as_modification');
                Route::get('/ordereds', 'index')->name('ordereds');
            });

            Route::get('/select_orders', [SelectOrdersController::class, 'selectOrdersByNumbers'])->name('select_orders');
            Route::get('/modifications', [ModificationsDashboardController::class, 'index'])->name('modifications');
            Route::get('/deliverys', [DeliverysDashboardController::class, 'index'])->name('deliverys');

            Route::group(['as' => 'print.'], function() {
                Route::get('/print/{ids}', [SelectOrdersController::class, 'selectOrders'])->name('select_orders');
            });
        });

        Route::group(['prefix'=>'vinograd'], function() {
            Route::resources([
                '/sliders' => SlidersController::class,
                '/mails' => MailsController::class
            ]);

            Route::controller(PreOrdersController::class)->group(function () {
                Route::get('/orders/pre_order_create', 'preCreate')->name('orders.pre.create');
                Route::get('/orders/pre_order_edit/{order_id}', 'preEdit')->name('orders.pre.edit');
                Route::post('/orders/pre_add_item/{order_id}', 'addItem')->name('orders.pre.add.item');
                Route::post('/orders/pre_update_item/{order_id}', 'updateItem')->name('orders.pre.update.item');
                Route::post('/orders/pre_delete_item/{order_id}', 'deleteItem')->name('orders.pre.delete.item');
            });

            Route::controller(OrdersController::class)->group(function () {
                Route::get('/orders','index')->name('orders.index');
                Route::get('/orders/status/{status}', 'index')->name('orders.index.status');
                Route::get('/orders/create', 'create')->name('orders.create');
                Route::post('/orders', 'store')->name('orders.store');
                Route::get('/orders/{order}', 'show')->name('orders.show');
                Route::get('/orders/{order}/edit', 'edit')->name('orders.edit');
                Route::patch('/orders/{order}', 'update')->name('orders.update');
                Route::delete('/orders/{order}','destroy')->name('orders.destroy');
                Route::post('/orders/currency-update', 'currencyUpdate')->name('orders.currency_update');
                Route::post('/orders/send-reply-mail', 'sendReplyMail')->name('orders.send_reply_mail');
                Route::get('/orders/merge/{order_id}/{merge_order_id}', 'merge')->name('orders.merge');
                Route::get('/orders/repeat_order_create/{order_id}', 'repeatCreate')->name('orders.repeat.create');

                Route::get('/ajax/build', 'setBuildDate')->name('orders.ajax.build');
            });

            Route::controller(ProductsController::class)->group(function () {
                Route::get('/products','index')->name('products.index');
                Route::get('/products/create', 'create')->name('products.create');
                Route::post('/products', 'store')->name('products.store');
                Route::get('/products/{product}', 'show')->name('products.show');
                Route::get('/products/{product}/edit', 'edit')->name('products.edit');
                Route::patch('/products/{product}', 'update')->name('products.update');
                Route::delete('/products/{product}','destroy')->name('products.destroy');
                Route::get('/products/show_by_status/{status}', 'showByStatus')->name('products.show_by_status');
                Route::get('/products/toggle/{id}', 'toggle')->name('products.toggle');
                Route::post('/products/modification/add', 'modificationAdd')->name('products.modification.add');
                Route::post('/products/modification/edit', 'modificationEdit')->name('products.modification.edit');
                Route::post('/products/modification/delete', 'modificationDelete')->name('products.modification.delete');
                Route::get('/products/modification/set_to_zero', 'setToZero')->name('products.modification.set_to_zero');
            });

            Route::controller(CategorysController::class)->group(function () {
                Route::get('/categorys','index')->name('categorys.index');
                Route::get('/categorys/create', 'create')->name('categorys.create');
                Route::post('/categorys', 'store')->name('categorys.store');
                Route::get('/categorys/{category}', 'show')->name('categorys.show');
                Route::get('/categorys/{category}/edit', 'edit')->name('categorys.edit');
                Route::patch('/categorys/{category}', 'update')->name('categorys.update');
                Route::delete('/categorys/{category}','destroy')->name('categorys.destroy');
                Route::get('/categorys/create/{model}', 'create')->name('categorys.create');
                Route::get('/categorys/{id}/edit/{model}', 'edit')->name('categorys.edit');
            });

            Route::controller(ModificationsController::class)->group(function () {
                Route::get('/modifications','index')->name('modifications.index');
                Route::get('/modifications/create', 'create')->name('modifications.create');
                Route::post('/modifications', 'store')->name('modifications.store');
                Route::get('/modifications/{modification}', 'show')->name('modifications.show');
                Route::get('/modifications/{modification}/edit', 'edit')->name('modifications.edit');
                Route::patch('/modifications/{modification}', 'update')->name('modifications.update');
                Route::delete('/modifications/{modification}','destroy')->name('modifications.destroy');
                Route::get('/modifications/toggle/{id}', 'toggle')->name('modifications.toggle');
            });

            Route::controller(DeliverysController::class)->group(function () {
                Route::get('/deliverys','index')->name('deliverys.index');
                Route::get('/deliverys/create', 'create')->name('deliverys.create');
                Route::post('/deliverys', 'store')->name('deliverys.store');
                Route::get('/deliverys/{delivery}', 'show')->name('deliverys.show');
                Route::get('/deliverys/{delivery}/edit', 'edit')->name('deliverys.edit');
                Route::patch('/deliverys/{delivery}', 'update')->name('deliverys.update');
                Route::delete('/deliverys/{delivery}','destroy')->name('deliverys.destroy');
                Route::get('/deliverys/toggle/{id}', 'toggle')->name('deliverys.toggle');
            });

            Route::controller(PagesController::class)->group(function () {
                Route::get('/pages','index')->name('pages.index');
                Route::get('/pages/create', 'create')->name('pages.create');
                Route::post('/pages', 'store')->name('pages.store');
                Route::get('/pages/{page}', 'show')->name('pages.show');
                Route::get('/pages/{page}/edit', 'edit')->name('pages.edit');
                Route::patch('/pages/{page}', 'update')->name('pages.update');
                Route::delete('/pages/{page}','destroy')->name('pages.destroy');
                Route::get('/pages/toggle/{id}', 'toggle')->name('pages.toggle');
                Route::get('/pages/up/{id}', 'moveUp')->name('pages.move.up');
                Route::get('/pages/down/{id}', 'moveDown')->name('pages.move.down');
            });

            Route::group(['prefix' => 'orders', 'as' => 'orders.'], function() {
                Route::controller(OrdersTreckCodeController::class)->group(function () {
                    Route::post('/set-ajax-treck_code', 'setAjaxTreckCode')->name('set_ajax_treck_code');
                    Route::post('/set_track_code/{order_id}', 'setTrackCode')->name('set.track_code');
                    Route::get('/track_code_form/{order}', 'trackCodeForm')->name('track_code_form');
                    Route::post('/sent-status-mail', 'sentStatusMail')->name('sent.status.mail');
                });

                Route::controller(OrdersItemController::class)->group(function () {
                    Route::post('/add_item/{order_id}', 'addItem')->name('add.item');
                    Route::post('/update_item/{order_id}', 'updateItem')->name('update.item');
                    Route::post('/delete_item/{order_id}', 'deleteItem')->name('delete.item');
                });

                Route::controller(OrdersDeliveryController::class)->group(function () {
                    Route::get('/delivery_edit/{order_id}', 'deliveryEdit')->name('delivery.edit');
                    Route::post('/delivery_update/{order_id}', 'deliveryUpdate')->name('delivery.update');
                });

                Route::controller(OrdersStatusController::class)->group(function () {
                    Route::post('/set-status', 'setStatus')->name('set_status');
                    Route::post('/set-ajax-status', 'setAjaxStatus')->name('set_ajax_status');
                });

                Route::controller(OrdersNoteController::class)->group(function () {
                    Route::post('/admin_note_edit', 'noteEdit')->name('admin.note.edit');
                    Route::get('/ajax/admin_note_edit', 'ajaxNoteEdit')->name('ajax.admin.note.edit');//TODO
                });

                Route::group(['as' => 'print.'], function() {
                    Route::controller(OrderPrintsController::class)->group(function () {
                        Route::get('/print/{id}', 'order')->name('order');
                        Route::get('/print/nalozhka_blanck/{id}', 'nalozhkaBlanck')->name('nalozhka_blanck');
                        Route::get('/print/nalozhka_sticker/{id}', 'nalozhkaSticker')->name('nalozhka_sticker');
                        Route::get('/print/declared_sticker/{id}', 'declaredSticker')->name('declared_sticker');
                        Route::get('/print/postal_belarus_sticker/{id}', 'postalBelarusSticker')->name('postal_belarus_sticker');
                        Route::get('/print/small_package_sticker/{id}', 'smallPackageSticker')->name('small_package_sticker');
                        Route::get('/print/small_package_sticker_2/{id}', 'smallPackageSticker_2')->name('small_package_sticker_2');

                        Route::get('/ajax/ajax_print_order', 'ajaxOrder')->name('ajax.print.order');

                        Route::get('/ajax/ajax_print_build', 'ajaxOrdersBuildDate')->name('ajax.orders.build');
                    });
                });
            });

//                Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function() {
//                    Route::get('/admin_note_edit', 'OrdersNoteController@ajaxNoteEdit')->name('note.edit');
//                    Route::get('/ajax_print', 'OrderPrintsController@ajaxOrder')->name('print.order');
//                    Route::get('/build', 'OrdersController@setBuildDate')->name('build');
//                });
//            });

            Route::controller(CommentsController::class)->group(function () {
                Route::get('/comments', 'index')->name('vinograd.comments.index');
                Route::get('/comments/toggle/{id}', 'toggle')->name('vinograd.comments.toggle');
                Route::delete('/comments/{id}/destroy', 'destroy')->name('vinograd.comments.destroy');
                Route::get('/comments/{id}/edit', 'edit')->name('vinograd.comments.edit');
                Route::patch('/comments/update', 'update')->name('vinograd.comments.update');
            });
        });

        Route::group(['prefix'=>'blog', 'as' => 'blog.'], function() {

            Route::controller(PostsController::class)->group(function () {
                Route::post('/blog-content-editable', 'contentEditable')->name('content.editable');
                Route::get('/posts','index')->name('posts.index');
                Route::get('/posts/create', 'create')->name('posts.create');
                Route::post('/posts', 'store')->name('posts.store');
                Route::get('/posts/{post}', 'show')->name('posts.show');
                Route::get('/posts/{post}/edit', 'edit')->name('posts.edit');
                Route::patch('/posts/{post}', 'update')->name('posts.update');
                Route::delete('/posts/{post}','destroy')->name('posts.destroy');
                Route::get('/posts/toggle/{id}', 'toggle')->name('posts.toggle');
            });
//admin.blog.comments.edit
            Route::controller(BlogCommentsController::class)->group(function () {
                Route::get('/comments','index')->name('comments.index');
                Route::get('/comments/create', 'create')->name('comments.create');
                Route::post('/comments', 'store')->name('comments.store');
                Route::get('/comments/{comments}', 'show')->name('comments.show');
                Route::get('/comments/{comments}/edit', 'edit')->name('comments.edit');
                Route::patch('/comments/{comments}', 'update')->name('comments.update');
                Route::delete('/comments/{comments}','destroy')->name('comments.destroy');
                Route::get('/comments/toggle/{id}', 'toggle')->name('comments.toggle');//TODO
            });

            Route::controller(BlogCategorysController::class)->group(function () {
                Route::get('/categorys','index')->name('categorys.index');
                Route::get('/categorys/create', 'create')->name('categorys.create');
                Route::post('/categorys', 'store')->name('categorys.store');
                Route::get('/categorys/{category}', 'show')->name('categorys.show');
                Route::get('/categorys/{category}/edit', 'edit')->name('categorys.edit');
                Route::patch('/categorys/{category}', 'update')->name('categorys.update');
                Route::delete('/categorys/{category}','destroy')->name('categorys.destroy');
            });
//            Route::resource('categorys', 'CategorysController')->names('blog.categorys');


//            Route::get('/comments/toggle/{id}', 'CommentsController@toggle')->name('blog.comments.toggle');

        });
    });
});
