@extends('layouts.base')

@section('favicon', '/img/logo/site-favicon.ico')

@section('header')
    <header>
        <div class="header-container">
            <div class="header-area @yield('header-absolute') header-sticky pt-30 pb-30">
                <div class="container-fluid pl-50 pr-50">
                    <div class="row">
                        <!--Header Logo Start-->
                        <div class="col-lg-3 col-md-3">
                            <div class="logo-area">
                                <a href="{{route('vinograd.home')}}">
                                    <img src="/img/logo/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <!--Header Logo End-->
                        <!--Header Menu And Mini Cart Start-->
                        <div class="col-lg-9 col-md-9 text-lg-right">

                            {{--@isset($headerMenu)--}}
                                {!! $headerMenu ?? '' !!}
                            {{--@endisset--}}

                            <!--Header Option Start-->
                            <div class="header-option">
                                <div class="mini-cart-search">
                                    <div class="header-search">
                                        <div class="search-box">
                                            <a href="index.html#"><i class="fa fa-search"></i></a>
                                            <div class="search-dropdown">
                                                <form action="{{ route('search') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input name="search" id="search" placeholder="Что ищем...?" type="text" autocomplete="off" class=" who">
                                                    {{--<input name="search" id="search" placeholder="Что ищем...?" value="" onblur="if(this.value==''){this.value='Search product...'}" onfocus="if(this.value=='Search product...'){this.value=''}" type="text">--}}
                                                    <button type="submit"><i class="fa fa-search"></i></button>
                                                </form>
                                                <ul class="search_result"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="currency">
                                        <div class="currency-box">
                                            <a href="#" onclick="return false;" style="pointer-events: none">
                                                @guest
                                                <i class="fa fa-user-o"></i>
                                                @else
                                                    <img width="40" class="rounded-circle" src="{{Auth::user()->getImage()}}">
                                                @endguest
                                            </a>
                                            <div class="currency-dropdown">
                                                <ul class="menu-top-menu">

                                                    @guest
                                                        <li><a href="#" data-toggle="modal" data-target="#login-modal">Вход</a></li>
                                                        <li><a href="{{ route('register') }}">Регистрация</a></li>
                                                    @else
                                                        <li><h4>{{ Auth::user()->name }}</h4></li>
                                                        @admin
                                                            <li><a href="{{ route('dashboard') }}">Админка</a></li>
                                                        @endadmin
{{--                                                        <li><a href="{{route('cabinet.home')}}">Кабинет</a></li>--}}
                                                        {{--<li><a href="wishlist.html">Wishlist</a></li>--}}
                                                        {{--<li><a href="cart.html">Shopping cart</a></li>--}}
                                                        {{--<li><a href="checkout.html">Checkout</a></li>--}}

                                                        <li>
                                                            <a href="{{ route('logout') }}"
                                                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                                                Выход
                                                            </a>

                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                {{ csrf_field() }}
                                                            </form>
                                                        </li>
                                                    @endguest

                                                </ul>
                                                @admin
                                                <div class="switcher">
                                                    <div class="language">
                                                        <div class="switcher-menu">
                                                            <ul>
                                                                <li><a href="#">Добавить</a>
                                                                    <ul class="switcher-dropdown">
                                                                        <li><a target="_blank" href="{{route('posts.create')}}">Новый Пост</a></li>
                                                                        <li><a target="_blank" href="{{route('countri.create')}}">Новую Страну</a></li>
                                                                        <li><a target="_blank" href="{{route('city.create')}}">Новый Город</a></li>
                                                                        <li><a target="_blank" href="{{route('tags.create')}}">Новый Тэг</a></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endadmin
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Header Option End-->
                        </div>
                        <!--Header Menu And Mini Cart End-->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <!--Mobile Menu Area Start-->
                            <div class="mobile-menu d-lg-none"></div>
                            <!--Mobile Menu Area End-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('footer')
    <div class="social-link-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="social-link">
                        <li><a href="contact-2.html#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="contact-2.html#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="contact-2.html#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="contact-2.html#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="contact-2.html#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="contact-2.html#"><i class="fa fa-skype"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection