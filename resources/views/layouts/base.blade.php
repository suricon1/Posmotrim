<!doctype html>
<html class="no-js" lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title')</title>
    <meta name="keywords" content="@yield('key')" />
    <meta name="description" content="@yield('desc')" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="@yield('favicon')">
    <link rel="shortcut icon" type="image/svg+xml" href="/img/logo/logo.svg">

    <link rel="stylesheet" href="{{ mix('css/app.css', 'build') }}">
    <link rel="stylesheet" href="{{ mix('css/custom.css', 'build') }}">

    @yield('head')

    <style>
        #login-modal a {
            color: #4f8db3;
        }
        #login-modal p {
            font-weight: 300;
            margin-bottom: 20px;
        }
        @yield('header-style')
    </style>
    <script data-ad-client="ca-pub-2733726119160750" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    <!-- Yandex.RTB -->
    <script>window.yaContextCb=window.yaContextCb||[]</script>
    <script src="https://yandex.ru/ads/system/context.js" async></script>

</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" rel="nofollow">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="wrapper">

    @yield('header')

    @yield('slider')

    @yield('breadcrumb')

    @include('components.status')
    @include('components.errors')

    @yield('content')

    <footer>
        <div class="footer-container">
            @section('footer')
            <div class="footer-middle-area black-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="single-footer-widget mb-30">
                                <div class="footer-info">
                                    <div class="single-footer-widget mb-40">
                                        <ul class="link-widget">
                                            <li><a href="{{route('vinograd.contactForm')}}">Контакты</a></li>
                                            <li><a href="{{route('vinograd.sitemap')}}">Карта сайта</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="single-footer-widget mb-30">
                                <div class="footer-info">
                                    <div class="single-footer-widget mb-40">
                                        <ul class="link-widget">
                                            @foreach($pages as $slug => $name)
                                            <li><a href="{{route('vinograd.page', ['slug' => $slug])}}">{{$name}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="single-footer-widget mb-30">
                                <div class="footer-info">
                                    <div class="icon">
                                        <i class="fa fa-envelope-open-o"></i>
                                    </div>
                                    <p>Email:<br>{{config('main.admin_email')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="single-footer-widget mb-30">
                                <div class="footer-info">
                                    <div class="icon">
                                        <i class="fa fa-mobile"></i>
                                    </div>
                                    <p>Телефон:<br>{{config('main.phone 1')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @show
            <div class="footer-bottom-area black-bg pt-50 pb-50">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2">
                            <!-- Yandex.Metrika counter -->
                            <script type="text/javascript" >
                                (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                                    m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
                                (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

                                ym(54737767, "init", {
                                    clickmap:true,
                                    trackLinks:true,
                                    accurateTrackBounce:true,
                                    webvisor:true
                                });
                            </script>
                            <noscript><div><img src="https://mc.yandex.ru/watch/54737767" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
                            <!-- /Yandex.Metrika counter -->
                        </div>
                        <div class="col-md-10">

                            <div class="news-letter-form text-center mb-3">

                                {{Form::open(['route' => 'subscribers', 'class' => 'popup-subscribe-form validate'])}}
                                <div id="mc-form" class="mc-form subscribe-form" >
                                    <input id="mc-email" autocomplete="off" type="email" class="form-control" placeholder="Подписаться на новости сайта ..." name="email" value="{{old('email')}}">
                                    <button id="mc-submit">Подписаться <i class="fa fa-chevron-right"></i></button>
                                </div>
                                {{Form::close()}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="modal fade" id="open-modal" tabindex="-1" role="dialog" aria-hidden="true"></div>

    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true" data-url="{{ route('vinograd.ajax.login-form') }}">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Войти на сайт</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="login-modal-body">

                </div>
            </div>
        </div>
    </div>

@include('components.errorModal')
    <!-- Modal SuccesModal -->
    <div class="modal fade" id="SuccesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="Succes" class="alert alert-success" role="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal preOrder-->
    <div class="modal fade" id="preOrder" tabindex="-1" role="dialog" aria-labelledby="preOrderTitle" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content" id="pre-order-modal"></div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="compare" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content"></div>
        </div>
    </div>

</div>

<script src="{{ mix('js/app.js', 'build') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>

@yield('scripts')

</body>
</html>
