<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview{{$dashboard_open ?? ''}}">
            <a href="#" class="nav-link{{$dashboard_active ?? ''}}">
                <i class="nav-icon fa fa-home"></i>
                <p>Аналитика<i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('dashboard.sorts')}}" class="nav-link{{$dashboard_sort_active ?? ''}}">
                        <p>По сортам</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('dashboard.modifications')}}" class="nav-link{{$dashboard_modification_active ?? ''}}">
                        <p>По модификациям</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('dashboard.ordereds')}}" class="nav-link{{$dashboard_ordered_active ?? ''}}">
                        <p>Заказано</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('dashboard.select_orders')}}" class="nav-link{{$dashboard_select_orders_active ?? ''}}">
                        <p>Избранные заказы</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('dashboard.deliverys')}}" class="nav-link{{$dashboard_delivery_active ?? ''}}">
                        <p>Метод доставки</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview{{$vinograd_open ?? ''}}">
            <a href="#" class="nav-link{{$vinograd_active ?? ''}}">
                <i class="nav-icon fa fa-folder"></i>
                <p>Виноград<i class="right fa fa-angle-left"></i>
                    @if($new_comment_product)
                        <span class="badge badge-danger right">{{$new_comment_product}}</span>
                    @endif
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('products.index')}}" class="nav-link{{$product_active ?? ''}}">
                        <p>Каталог сортов</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('modifications.index')}}" class="nav-link{{$modification_active ?? ''}}">
                        <p>Модификации</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('categorys.index')}}" class="nav-link{{$category_active ?? ''}}">
                        <p>Категории</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('vinograd.comments.index')}}" class="nav-link{{$vinograd_comment_active ?? ''}}">
                        <p>Комментарии
                            @if($new_comment_product)
                                <span class="badge badge-danger right">{{$new_comment_product}}</span>
                            @endif
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('sliders.index')}}" class="nav-link{{$slider_active ?? ''}}">
                        <p>Слайдер</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pages.index')}}" class="nav-link{{$page_active ?? ''}}">
                        <p>Страницы</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview{{$blog_open ?? ''}}">
            <a href="#" class="nav-link{{$blog_active ?? ''}}">
                <i class="nav-icon fa fa-folder"></i>
                <p>Блог<i class="right fa fa-angle-left"></i>
                    @if($new_comment_post)
                        <span class="badge badge-danger right">{{$new_comment_post}}</span>
                    @endif
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('posts.index')}}" class="nav-link{{$post_active ?? ''}}">
                        <p>Посты</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('blog.categorys.index')}}" class="nav-link{{$blog_categorys_active ?? ''}}">
                        <p>Категории</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('comments.index')}}" class="nav-link{{$blog_comment_active ?? ''}}">
                        <p>Комментарии
                            @if($new_comment_post)
                                <span class="badge badge-danger right">{{$new_comment_post}}</span>
                            @endif
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview{{$orders_open ?? ''}}">
            <a href="{{route('orders.index')}}" class="nav-link{{$orders_active ?? ''}}">
                <i class="nav-icon fa fa-circle-thin"></i>
                <p>
                    Заказы
                    @if($pre_orders)
                    <span class="badge badge-warning right">{{$pre_orders}}</span>
                    @endif
                    @if($new_orders)
                    <span class="badge badge-success right">{{$new_orders}}</span>
                    @endif
                </p>
            </a>
        </li>
        <li class="nav-item has-treeview{{$deliverys_open ?? ''}}">
            <a href="{{route('deliverys.index')}}" class="nav-link{{$deliverys_active ?? ''}}">
                <i class="nav-icon fa fa-circle-thin"></i>
                <p>Доставка</p>
            </a>
        </li>
        <li class="nav-item has-treeview{{$messages_open ?? ''}}">
            <a href="{{route('mails.index')}}" class="nav-link{{$messages_active ?? ''}}">
                <i class="nav-icon fa fa-circle-thin"></i>
                <p>
                    Сообщения
                    @if($new_contact)
                    <span class="badge badge-danger right">{{$new_contact}}</span>
                    @endif
                </p>
            </a>
        </li>
    </ul>
</nav>
