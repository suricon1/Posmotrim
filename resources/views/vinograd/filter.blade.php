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

    <div class="product-list-area">
        <div class="row">
            @foreach ($products as $product)
            <div class="col-md-6 mb-5">
                <div class="single-product product-list">
                    <h4>
                        <a href="{{route('vinograd.product', ['slug' => $product->slug])}}">{{$product->name}}</a>
                        <small class="text-muted">
                            (
                            @if($product->selection->id > 1)
                                <a href="{{route('vinograd.category.selection', ['slug' => $product->selection->slug])}}"> {{$product->selection->name}}</a>,
                            @endif
                            @if($product->country->id > 1)
                                <a href="{{route('vinograd.category.country', ['slug' => $product->country->slug])}}"> {{$product->country->name}}</a>
                            @endif
                            )
                        </small>
                    </h4>
                    <div class="list-col-4">
                        <div class="product-img img-full">
                            <a href="{{route('vinograd.product', ['slug' => $product->slug])}}">
                                <img src="{{asset($product->getImage('400x400'))}}" alt="{{$product->name}}">
                            </a>
                        </div>
                    </div>
                    <div class="list-col-8">
                        <div class="product-content">
                            <div class="product-price">
                                <div class="price-box">
                                    @forelse($product->modifications as $modification)
                                        <span style="white-space: nowrap;"><strong>{{$modification->property->name}}</strong> - {{currency($modification->price)}} {{signature()}}</span>
                                    @empty
                                        <span class="text-danger">Нет в наличии</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{$products->links()}}
    </div>




{{--    @foreach($selections as $selection)--}}
{{--        <h2 class="mb-5">{{$selection->title}}</h2>--}}
{{--        @include('vinograd.components.product-grid-view', ['products' => $selection->productsActive])--}}
{{--    @endforeach--}}
{{--    @foreach($countrys as $country)--}}
{{--        <h2 class="mb-5">{{$country->title}}</h2>--}}
{{--        @include('vinograd.components.product-grid-view', ['products' => $country->productsActive])--}}
{{--    @endforeach--}}

@endsection
