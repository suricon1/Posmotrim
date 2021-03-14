@extends('layouts.vinograd-left')

@section('title', 'Авторизация на сайте'.config('app.name'))
@section('key', 'Авторизация на сайте'.config('app.name'))
@section('desc', 'Авторизация на сайте'.config('app.name'))

@section('head')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('breadcrumb-content')
    <li class="active">Вход на сайт</li>
@endsection

@section('left-content')
    <div class="form-group errors"></div>

    @include('components.login-form')
@endsection
