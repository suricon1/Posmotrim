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
        {{Form::open(['route' => 'vinograd.category.filter', 'class' => 'p-3', 'method' => 'GET'])}}
        <div id="cate-toggle" class="category-menu-list">
{{--                Вывод фильтров по новой методе--}}
            @foreach(filters() as $filter)
                {!! $filter !!}
            @endforeach
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
        </div>
        {{Form::close()}}
    </div>
</div>
<div class="sidebar-layout mb-5">
    <div class="sidebar-banner single-banner">
        <div class="banner-img">
            @include('components.reklama.google_left_sitebar')
        </div>
    </div>
</div>
