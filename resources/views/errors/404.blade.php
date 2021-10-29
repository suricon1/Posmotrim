{{--@extends('layouts.site')--}}
@extends('layouts.vinograd-left')

@section('title', '404 | ОШИБКА! Нет такой страницы')
@section('key', '404 | ОШИБКА! Нет такой страницы')
@section('desc', '404 | ОШИБКА! Нет такой страницы')

@section('header-top-area', '')

@section('content')
    <!--Error 404 Area Start-->
    <div class="error-404-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-wrapper text-center">
                        <div class="error-text">
                            <h1>404</h1>
                            <h2>Opps! Такой страницы не существует!</h2>
                            <p>Страница не существует, удалена, или временно недоступна.</p>
                        </div>
                        <div class="search-error">
                            <form action="404.html#">
                                <input placeholder="Поиск по сайту ..." type="text">
                                <button><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="error-button">
                            <a href="{{ route('vinograd.home') }}">Перейти на главную страницу</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Error 404 Area End-->
@endsection
