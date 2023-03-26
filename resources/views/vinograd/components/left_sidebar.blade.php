<div class="plantmore-address">
    <h2 class="contact-title text-center">Контакты</h2>
    <ul>
        <li>
            <i class="fa fa-phone"></i>
            <img src="{{Storage::url('pics/img/velcom.png')}}">
            <a href="tel:{{config('main.phone 1')}}" rel="nofollow">{{config('main.phone 1')}}</a>

        </li>
        <li class="pl-2"><a href="viber://add?number=375291565956"><img src="{{Storage::url('pics/img/viber.png')}}"> Viber</a></li>
        <li>
            <i class="fa fa-envelope-o"></i>
            <a href="mailto:{{config('main.admin_email')}}?subject=Вопрос по винограду">{{config('main.admin_email')}}</a>
        </li>
        <li><a href="{{route('vinograd.contactForm')}}"><i class="fa fa-pencil"></i> Форма обратной связи</a></li>
        <li>
            <i class="fa fa-youtube-play text-danger"></i>
            <a href="https://www.youtube.com/channel/UC5-E2vxUNeMUqAYSDCFO23w" target="_blank" rel="nofollow">Наш YouTube канал</a>
        </li>
        <li><a href="https://zen.yandex.ru/id/5c57c7f3ea64bc00ac1eb86e" target="_blank" rel="nofollow"><img src="{{Storage::url('pics/img/logo/yandex-zen.png')}}"> Наш Дзен канал</a></li>
    </ul>
{{--    <div class="working-time">--}}
{{--        <h3><strong>Working hours</strong></h3>--}}
{{--        <p><strong>Monday – Saturday</strong>: &nbsp;08AM – 22PM</p>--}}
{{--    </div>--}}
</div>

<div class="sidebar-layout mb-5">
    <div class="category-menu">
        <div class="category-heading">
            <h2 class="categories-toggle"><span>Категории</span> &#9013;</h2>
        </div>
        <div id="cate-toggle" class="category-menu-list">
            <ul>
                <li><a href="{{route('vinograd.category')}}">Все сорта</a></li>

                @foreach($categorys as $category)
                <li>
                    <a href="{{route('vinograd.category.category', ['slug' => $category->slug])}}">{{$category->name}}</a>
                    <span>({{$category->category_count}})</span>
                </li>
                @endforeach
{{--                <li class="rx-child"><a href="#">Скрытый пункт</a></li>--}}
{{--                <form action="{{route('vinograd.category.filter')}}" class="rx-child p-3">--}}
{{--                {{Form::open(['route' => 'vinograd.category.filter', 'class' => 'rx-child p-3'])}}--}}
                {{Form::open(['route' => 'vinograd.category.filter', 'class' => 'p-3'])}}

                    <div class="shop-sidebar mt-5">
                        <h3>Селекционеры</h3>
                        <div class="categori-checkbox">
                            <ul>
                                @foreach($selections as $selection)
                                <li>
                                    <input class="cat_fil" name="selection[]" type="checkbox" value="{{$selection->id}}"
                                        @if(request('selection'))
                                        {{in_array($selection->id, request('selection')) ? 'checked' : ''}}
                                        @endif
                                    >
                                    <a href="{{route('vinograd.category.selection', ['slug' => $selection->slug])}}">{{$selection->name}}</a>
                                    <span class="count">({{$selection->selection_count}})</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="shop-sidebar">
                        <h3>Страны</h3>
                        <div class="categori-checkbox">
                            <ul>
                                @foreach($countrys as $country)
                                <li>
                                    <input class="cat_fil" name="country[]" type="checkbox" value="{{$country->id}}"
                                        @if(request('country'))
                                        {{in_array($country->id, request('country')) ? 'checked' : ''}}
                                        @endif
                                    >
                                    <a href="{{route('vinograd.category.country', ['slug' => $country->slug])}}">{{$country->name}}</a>
                                    <span class="count">({{$country->country_count}})</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="price-slider-amount">
                        <button id="btn" disabled>Показать</button>
                    </div>
                <script>
                    window.addEventListener('DOMContentLoaded', function() {
                        const inputs = document.querySelectorAll('.cat_fil');
                        inputs.forEach(item => {
                            item.addEventListener('change', (e) => {
                                const count = document.querySelectorAll("input[class='cat_fil']:checked").length;
                                document.querySelector('#btn').disabled = count ? false : true;
                            });
                        });
                    });
                </script>
                {{--                </form>--}}
                {{Form::close()}}
{{--                <li class="rx-parent">--}}
{{--                    <a class="rx-default"><span class="cat-thumb  fa fa-plus"></span>Еще больше категорий</a>--}}
{{--                    <a class="rx-show"><span class="cat-thumb  fa fa-minus"></span>Скрыть</a>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
</div>

{{--@if($featured->count())--}}
{{--<div class="sidebar-layout mb-5">--}}
{{--    <div class="featured-product">--}}
{{--        <div class="sidebar-title text-center">--}}
{{--            <h3>Рекомендуем</h3>--}}
{{--        </div>--}}
{{--        <div class="sidebar-product-active">--}}
{{--            <div class="product-item">--}}

{{--                @foreach($featured as $item)--}}
{{--                <div class="single-product product-list">--}}
{{--                    <div class="list-col-4">--}}
{{--                        <div class="product-img img-full">--}}
{{--                            <a href="{{route('vinograd.product', ['slug' => $item->slug])}}">--}}
{{--                                <img src="{{asset($item->getImage('400x400'))}}" alt="">--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="list-col-8">--}}
{{--                        <div class="product-content">--}}
{{--                            <h2><a href="{{route('vinograd.product', ['slug' => $item->slug])}}">{{$item->name}}</a></h2>--}}
{{--                            <div class="product-price">--}}
{{--                                <div class="price-box">--}}

{{--                                    @forelse($item->modifications as $modification)--}}
{{--                                        <span><strong>{{$modification->property->name}}</strong> - {{$modification->price}}руб</span><br>--}}
{{--                                    @empty--}}
{{--                                        <p class="text-danger">Нет в наличии</p>--}}
{{--                                    @endforelse--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                @if($loop->iteration % 3 == 0 && !$loop->last)--}}
{{--            </div>--}}
{{--            <div class="product-item">--}}
{{--                @endif--}}

{{--                @endforeach--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endif--}}

<div class="sidebar-layout mb-5">
    <div class="sidebar-banner single-banner">
        <div class="banner-img">
            @include('components.reklama.google_left_sitebar')
        </div>
    </div>
</div>

{{--<div class="sidebar-layout">--}}
{{--    <div class="sidebar-title text-center">--}}
{{--        <h3>Popular Tags</h3>--}}
{{--    </div>--}}
{{--    <div class="product-tag">--}}
{{--        <ul>--}}
{{--            <li><a href="index-5.html#">accesories</a></li>--}}
{{--            <li><a href="index-5.html#">blouse</a></li>--}}
{{--            <li><a href="index-5.html#">clothes</a></li>--}}
{{--            <li><a href="index-5.html#">digital</a></li>--}}
{{--            <li><a href="index-5.html#">fashion</a></li>--}}
{{--            <li><a href="index-5.html#">handbag</a></li>--}}
{{--            <li><a href="index-5.html#">laptop</a></li>--}}
{{--            <li><a href="index-5.html#">men</a></li>--}}
{{--            <li><a href="index-5.html#">women</a></li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</div>--}}
