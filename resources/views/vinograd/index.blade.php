@extends('layouts.vinograd-left')

@section('title', 'Виноград в Минске, черенки винограда, саженцы винограда, купить в Минске. Интернет магазин черенков и саженцев виноградов в Минске')
@section('key', 'Виноград в Минске')
@section('desc', 'Виноград в Минске. Интернет магазин черенков и саженцев виноградов в Минске. Купить черенки и саженцы самых популярных и проверенных сортов винограда.')

@section('header-absolute', 'header-absolute')

@section('header-top-area', '')

@section('header-style')
    .is-body-sticky {
        margin-top: 0;
    }
@endsection

@section('head')
    <link rel="canonical" href="{{route('vinograd.home')}}"/>
@endsection

@section('slider')

    <div id="carousel" class="carousel slide d-inline-block  carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel" data-slide-to="0" class="active"></li>
            <li data-target="#carousel" data-slide-to="1"></li>
            <li data-target="#carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">

            @foreach($sliders as $slider)
            <div class="carousel-item{{$loop->iteration == 1 ? ' active' : ''}}"  data-interval="3000">
                <img class="img-fluid" src="{{$slider->getImage('1600x700')}}" alt="{{$slider->title}}">
                <div class="carousel-caption bg-opacity-white-50">
                    <h2>{!! $slider->title !!}</h2>
                    <p>{{$slider->text}}</p>
                </div>
            </div>
            @endforeach

        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev" rel="nofollow">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Предыдущий</span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next" rel="nofollow">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Следующий</span>
        </a>
    </div>

{{--    <!--Feature Area Start-->--}}
{{--    <div class="feature-area mt-4">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <!--Single Feature Start-->--}}
{{--                    <div class="single-feature mb-35">--}}
{{--                        <div class="feature-icon">--}}
{{--                            <span class="fa fa-rocket"></span>--}}
{{--                        </div>--}}
{{--                        <div class="feature-content">--}}
{{--                            <h3>Бесплатно доставим</h3>--}}
{{--                            <p>При заказе от 50р по Минску и от 200р по району</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--Single Feature End-->--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <!--Single Feature Start-->--}}
{{--                    <div class="single-feature mb-35">--}}
{{--                        <div class="feature-icon">--}}
{{--                            <span class="fa fa-phone"></span>--}}
{{--                        </div>--}}
{{--                        <div class="feature-content">--}}
{{--                            <h3>Гарантия качества</h3>--}}
{{--                            <p>все предложенные сорта мы выращиваем самостоятельно и тщательно следим за маркировкой</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--Single Feature End-->--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <!--Single Feature Start-->--}}
{{--                    <div class="single-feature mb-35">--}}
{{--                        <div class="feature-icon">--}}
{{--                            <span class="fa fa-repeat"></span>--}}
{{--                        </div>--}}
{{--                        <div class="feature-content">--}}
{{--                            <h3>Консультации</h3>--}}
{{--                            <p>на нашем Ютуб канале вы найдете все необходимую информацию по уходу за виноградом в доступном виде</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--Single Feature End-->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!--Feature Area End-->--}}

@endsection

@section('breadcrumb', '')

@section('left-content')
    <div class="product-layout">

        <div class="store-area">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h1>Выращивание винограда в Беларуси</h1>
                        <h3>Черенки и саженцы винограда</h3>
                    </div>
                </div>
            </div>
{{--            <div class="alert alert-warning" role="alert">--}}
{{--                По техническим причинам <strong>корзина</strong> временно не работает. По всем вопросам обращайтесь на Email сайта: <a href="mailto:{{config('main.admin_email')}}?subject=Вопрос по винограду"><u>{{config('main.admin_email')}}</u></a>, или в <a href="{{route('vinograd.contactForm')}}"><u>форму обратной связи</u></a>.--}}
{{--            </div>--}}
            <div class="row">
                <div class="col-12">
                    <div class="store-product-menu">
                        <ul class="nav justify-content-center mb-45">
                            @foreach($categorys as $category)
                            <li><a class="{{$loop->iteration == 1 ? ' active' : ''}}" data-toggle="tab" href="#{{$category->slug}}" rel="nofollow">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-12">
                    <div class="tab-content">
                        @foreach($products as $key => $value)
                        <div id="{{$key}}" class="tab-pane fade show{{$loop->iteration == 1 ? ' active' : ''}}">
                            <div class="row">
                                <div class="store-slider-active">
                                    <div class="col-xl-4 col-md-6">

                                        @foreach($value as $product)

                                            @include('vinograd.components.single-product-item', ['product' => $product])

                                            @if($loop->iteration % 2 == 0 && !$loop->last)
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                            @endif

                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a class="btn btn-success btn-lg btn-block" href="{{route('vinograd.category')}}" role="button">Перейти в каталог</a>
        </div>
        <div class="banner-area mt-5">
            <div class="row">
                <div class="col">
                    @include('components.reklama.google_index_one')
                </div>
{{--                <div class="col-md-6">--}}
{{--                    @include('components.reklama.google_index_bottom_1')--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    @include('components.reklama.google_index_bottom_2')--}}
{{--                </div>--}}
            </div>
        </div>

    </div>
@endsection

@section('category-content')
    @if($posts)
    <div class="blog-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-35">
                        <span>Наши статьи про выращивание винограда и не только</span>
                        <h3>Рекомендуем почитать</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="blog-slider-active">
                    @foreach($posts as $post)
                    <div class="col-md-4">
                        <div class="single-blog">
                            <div class="blog-img img-full">
                                <a href="{{route('blog.post', ['slug' => $post->slug])}}">
                                    <img src="{{ asset($post->getImage('660x495')) }}" alt="{{$post->name}}">
                                </a>
                            </div>
                            <div class="blog-content">
                                <div class="post-date">{{getRusDate($post->date_add)}}</div>
                                <h3 class="post-title"><a href="{{route('blog.post', ['slug' => $post->slug])}}">{{$post->name}}</a></h3>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="our-service-area service-bg pt-120">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title2 mb-70">
                        <h3>Наши преимущества</h3>
                        <p>Почему покупать у нас выгодно и удобно!</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="single-service mb-85">
                        <div class="service-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="service-info">
                            <h3>УДОБНОЕ МЕСТОРАСПОЛОЖЕНИЕ</h3>
                            <p>Мы удобно расположены. Вы самостоятельно можете забрать свой заказ в удобное для Вас время.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="single-service mb-85">
                        <div class="service-icon">
                            <i class="fa fa-truck"></i>
                        </div>
                        <div class="service-info">
                            <h3>БЕСПЛАТНАЯ ДОСТАВКА</h3>
                            <p>Мы бесплатно доставим Ваши черенки либо саженцы по городу Минску при заказе от 50р, а при заказе от 200р - по Минскому району</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single-service mb-85">
                        <div class="service-icon">
                            <i class="fa fa-thumbs-o-up"></i>
                        </div>
                        <div class="service-info">
                            <h3>ГАРАНТИЯ КАЧЕСТВА</h3>
                            <p>все предложенные сорта мы выращиваем самостоятельно и тщательно следим за маркировкой</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single-service mb-85">
                        <div class="service-icon">
                            <i class="fa fa-info"></i>
                        </div>
                        <div class="service-info">
                            <h3>КОНСУЛЬТАЦИЯ</h3>
                            <p>На нашем <a href="https://www.youtube.com/channel/UC5-E2vxUNeMUqAYSDCFO23w" rel="nofollow">Ютуб канале</a> вы найдете все необходимую информацию по уходу за виноградом в доступном виде</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="about-us-area-2 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-us-content-2">
                        <h2>Виноград это просто, полезно и надежно</h2>
                        <p>Виноград - многолетнее долговечное растение. Живет и плодоносит на садовых участках в среднем 50-60 лет. Однако известны и очень старые виноградные кусты с возрастом в 100 лет и более.</p>
                        <p>Виноград — ценный продукт, обладающий питательными и лечебными свойствами. В его ягодах содержится виноградный сахар, который состоит в основном из глюкозы и фруктозы, легко усвояемых организмом человека, а также органические кислоты (винная, яблочная, лимонная, янтарная и др.), белки, пектины, минеральные вещества (калий, кальций, фосфор, железо, медь, бром, йод и др.), витамины А, С, Р, В. В зависимости от содержания сахара 1 кг винограда может дать 700— 1200 кал дневного рациона.</p>
                        <p>Ягоды винограда хороши в свежем, сушеном, консервированном виде. Их используют для приготовления сока, компота, варенья, сиропа, повидла, джема, чурчхелы.</p>
                        <p> Виноград — прекрасное сырье для получения домашнего вина.</p>
                        <p>Рост и развитие виноградного куста зависят непосредственно от условий произрастания, сортовых особенностей и принятой технологии.</p>
                        <p>Культура винограда не только увлекательное и полезное занятие, но и наиболее надежная в отношении получения урожая. Виноград совсем без урожая хозяина никогда не оставит, даже когда сильные возвратные весенние заморозки убивают молодые побеги, из спящих почек вырвстут новые побеги и дадут урожай ягод. Правда, не такой обильный, как обычно, и на две-три недели он позже созреет.</p>
                        <p>Сегодня, с появлением все новых высококачественных сортов винограда с повышенной устойчивостью к болезням и морозам, открываются поистине чудесные возможности выращивать на своём участке вкусный и красивый виноград.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
