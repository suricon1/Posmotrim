@extends('layouts.vinograd-left')

@section('title', $product->meta['title'])
@section('key', $product->meta['keywords'])
@section('desc', $product->meta['description'])

@section('breadcrumb-content')
    <li><a href="{{route('vinograd.category.category', ['slug' => $product->category->slug])}}">{{$product->category->name}}</a></li>
    <li class="active">{{ $product->name }}</li>
@endsection

@section('left-content')

<div class="single-product-area mb-115">
    <h1>{{ $product->name }}</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="product-details-img-tab">
                    <div class="tab-content single-product-img">
                        <div class="tab-pane fade show active" id="product1">
                            <div class="product-large-thumb img-full">
                                <img src="{{ asset($product->getImage('700x700')) }}" alt="{{ $product->name }} виноград, купить черенки и саженцы сорта {{ $product->name }} в Минске">
                            </div>
                        </div>

                        @foreach($product->getGallery('700x700') as $image)
                        <div class="tab-pane fade" id="product{{$loop->iteration + 1}}">
                            <div class="product-large-thumb img-full">
                                <img src="{{Storage::url($image)}}" alt="{{ $product->name }} виноград, купить черенки и саженцы сорта {{ $product->name }} в Минске">
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="product-menu">
                        <div class="nav product-tab-menu">
                            <div class="product-details-img">
                                <a class="active" data-toggle="tab" href="#product1" rel="nofollow">
                                    <img src="{{ asset($product->getImage('100x100')) }}" alt="{{ $product->name }} виноград, черенки и саженцы.">
                                </a>
                            </div>

                        @foreach($product->getGallery('100x100') as $image)
                            <div class="product-details-img">
                                <a data-toggle="tab" href="#product{{$loop->iteration + 1}}" rel="nofollow">
                                    <img src="{{Storage::url($image)}}" alt="{{ $product->name }} виноград, черенки и саженцы.">
                                </a>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="product-details-content">
{{--                    <h1>{{ $product->name }}</h1>--}}
                    {{--<div class="single-product-price">--}}
                        {{--<span class="regular-price">Стоимость:</span>--}}
                        {{--<span class="price new-price">$66.00</span>--}}
                        {{--<span class="regular-price">${{ $product->price }}</span>--}}
                    {{--</div>--}}
                    {{--<div class="product-description">{!! $product->description !!} </div>--}}
                    {{--<h2>Основные характеристики</h2>--}}
                    <table class="table table-sm  table-hover">
                        <tbody>
                            <tr>
                                <th scope="row"><span class="stock in-stock"></span>Срок созревания</th>
                                <td>{{$product->category::getRipeningName($product->ripening)}} дней</td>
                            </tr>
                            <tr>
                                <th scope="row"><span class="stock in-stock"></span>Масса грозди</th>
                                <td>{{ $product->props['mass'] }} г</td>
                            </tr>
                            <tr>
                                <th scope="row"><span class="stock in-stock"></span>Окраска</th>
                                <td>{{ $product->props['color'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><span class="stock in-stock"></span>Вкус</th>
                                <td>{{ $product->props['flavor'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><span class="stock in-stock"></span>Устойчивость к морозу</th>
                                <td>{{ $product->props['frost'] }} &#8451;</td>
                            </tr>
{{--                            <tr>--}}
{{--                                <th scope="row"><span class="stock in-stock"></span>Устойчивость к болезням</th>--}}
{{--                                <td>средняя</td>--}}
{{--                            </tr>--}}
                            <tr>
                                <th scope="row"><span class="stock in-stock"></span>Цветок</th>
                                <td>{{ $product->props['flower'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><span class="stock in-stock"></span>Категориия</th>
                                <td>
                                    <a href="{{route('vinograd.category.category', ['slug' => $product->category->slug])}}"> {{$product->category->name}}</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><span class="stock in-stock"></span>Селекция</th>
                                <td>
                                @if($product->selection->id > 1)
                                    <a href="{{route('vinograd.category.selection', ['slug' => $product->selection->slug])}}"> {{$product->selection->name}}</a>,
                                @endif
                                @if($product->country->id > 1)
                                    <a href="{{route('vinograd.category.country', ['slug' => $product->country->slug])}}"> {{$product->country->name}}</a>
                                @endif
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <div class="single-product-quantity">
                        <ul class="list-group">
                            <h3>У нас в продаже</h3>
                            @forelse($product->modifications as $modification)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span style="max-width: 50%;"><strong>{{$modification->property->name}}</strong> - {{currency($modification->price)}} {{signature()}}<br>
                                    В наличии <strong>{{$modification->quantity}}</strong> шт.</span>
                                    <div>
                                        {{Form::open(['route'=>['vinograd.cart.add'], 'class' => 'add-quantity', 'data-action' => 'add-to-cart'])}}
                                        <div class="product-quantity">
                                            {{Form::number('quantity', 1)}}
                                            {{Form::hidden('product_id', $product->id)}}
                                            {{Form::hidden('modification_id', $modification->id)}}
                                        </div>
                                            <button class="product-btn"></button>
                                        {{Form::close()}}
                                    </div>
                            </li>
                            @empty
                                {!! config('main.empty_text_info') !!}
                            @endforelse
                        </ul>
                    </div>
                    <div class="single-feature mb-3 p-2">
                        <div class="feature-content">
                            <a href="{{route('vinograd.page', ['slug' => 'nashi-cherenki'])}}">
                                <span class="fa-stack fa-lg text-success">
                                  <i class="fa fa-circle-thin fa-stack-2x"></i>
                                  <i class="fa fa-info fa-stack-1x"></i>
                                </span>
                                Такие черенки мы продаем
                            </a>
                        </div>
                        <div class="feature-content ml-3">
                            <a href="https://www.youtube.com/channel/UC5-E2vxUNeMUqAYSDCFO23w" target="_blank" rel="nofollow">
                                <span class="fa-stack fa-lg text-success">
                                  <i class="fa fa-circle-thin fa-stack-2x"></i>
                                  <i class="fa fa-youtube fa-stack-1x text-danger"></i>
                                </span>
                                Наш YouTube канал
                            </a>
                        </div>
                    </div>
                    <div class="wishlist-compare-btn">
                        <a href="{{route('vinograd.cabinet.wishlist.add', ['id' => $product->id])}}" class="wishlist-btn" rel="nofollow">Отложить</a>
                        <a href="#" class="compare add-compare" data-product-id="{{$product->id}}" data-url="{{route('vinograd.compare.add')}}" data-action="add" rel="nofollow">В сравнение</a>
                    </div>
{{--                    <div class="product-meta">--}}
{{--                        <span class="posted-in">Категории:--}}
{{--                            <a href="{{route('vinograd.category.category', ['slug' => $product->category->slug])}}">{{$product->category->name}}</a>,--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                    <div class="single-product-sharing">--}}
{{--                        <h3>Мы в соцСетях</h3>--}}
{{--                        <ul class="socil-icon2">--}}
{{--                            <li><a href="#"><i class="fa fa-facebook" rel="nofollow"></i></a></li>--}}
{{--                            <li><a href="https://www.youtube.com/channel/UC5-E2vxUNeMUqAYSDCFO23w"><i class="fa fa-youtube-play" rel="nofollow"></i></a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-description-review-area mb-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-review-tab">
                    <ul class="nav dec-and-review-menu">
                        <li>
                            <a class="active" data-toggle="tab" href="#description" rel="nofollow">Описание</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#reviews" rel="nofollow">Отзывы ({{$product->commentsCount()}})</a>
                        </li>
                    </ul>
                    <div class="tab-content product-review-content-tab" id="myTabContent-4">
                        <div class="tab-pane fade active show" id="description">
                            <div class="single-product-description">
                                <h2>Виноград <strong>{{ $product->name }}</strong> Описание и характеристики сорта</h2>
                                <p>{!! $product->content !!}</p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="reviews">
                            <div class="review-page-comment comments-area" id="parent_coment">
                                <div class="comments-area mt-80" id="parent_coment">
                                    @if(count($comments) > 0)
                                        <a name="comments"></a>
                                        <h3>Коментарии:</h3>
                                        @include('components.comment-item', ['comments' => $comments])
                                    @else
                                        <h3 class="mt-5">Вы можете оставить первый комментарий!</h3>
                                    @endif
                                </div>
                            </div>
                            <div class="review-form-wrapper">
                                <div class="review-form" id="form_add_comment">
                                    @include('components.comment-form', ['product_id' => $product->id, 'url' => route('vinograd.ajax-comment.add')])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($similar)
<div>
    <div class="text-center mb-3">
        <h2 class="m-auto">Похожие сорта винограда</h2>
    </div>
    <div class="row">
        @foreach ($similar as $chunk)
            <div class="col">
                <div class="rc-product">
                    <ul>
                    @foreach ($chunk as $product)
                        <li>
                            <div class="rc-product-thumb img-full">
                                <a href="{{route('vinograd.product', ['slug' => $product->slug])}}">
                                    <img src="{{ asset($product->getImage('100x100')) }}" alt="{{ $product->name }} виноград">
                                </a>
                            </div>
                            <div class="rc-product-content">
                                <h6><a href="{{route('vinograd.product', ['slug' => $product->slug])}}">{{$product->name}}</a></h6>
                                <div class="rc-product-price">
                                @forelse($product->modifications as $modification)
                                    <span><strong>{{$modification->property->name}}</strong> - {{currency($modification->price)}} {{signature()}}</span>
                                @empty
                                    <span class="text-danger">Нет в наличии</span>
{{--                                        {!! config('main.empty_text_info') !!}--}}
                                @endforelse
                                </div>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

@endsection
