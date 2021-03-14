@extends('layouts.vinograd-left')

@section('title', 'Корзина покупок')
@section('key', 'Корзина покупок')
@section('desc', 'Корзина покупок')

@section('head')
    {{Html::meta('robots', 'noindex, nofollow')}}
@endsection

@section('breadcrumb-content')
    <li class="active">Корзина покупок</li>
@endsection

@section('left-content')

    <div class="cart">
        @include('vinograd.components._cart', ['cart' => $cart])
    </div>

@endsection
