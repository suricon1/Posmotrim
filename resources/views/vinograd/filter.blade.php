@extends('layouts.vinograd-left')

@section('title', 'Сорта винограда выбранных категорий')
@section('key', 'Сорта винограда выбранных категорий')
@section('desc', 'Сорта винограда выбранных категорий')

@section('head')
    {{Html::meta('robots', 'noindex, nofollow')}}
@endsection

@section('breadcrumb-content')
    <li class="active">Сорта винограда выбранных категорий</li>
@endsection

@section('left-content')

    @foreach($selections as $selection)
        <h2 class="mb-5">{{$selection->title}}</h2>
        @include('vinograd.components.product-grid-view', ['products' => $selection->productsActive])
    @endforeach
    @foreach($countrys as $country)
        <h2 class="mb-5">{{$country->title}}</h2>
        @include('vinograd.components.product-grid-view', ['products' => $country->productsActive])
    @endforeach

@endsection
