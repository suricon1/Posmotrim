@extends('layouts.vinograd-left')

@section('title', 'Кабинет - Просмотр заказа')
@section('key', 'Кабинет - Просмотр заказа')
@section('desc', 'Кабинет - Просмотр заказа')

@section('head')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('breadcrumb')
    <div class="breadcrumb-tow mb-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content breadcrumb-content-tow">
                        <ul>
                            <li><a href="{{route('vinograd.home')}}"><i class="fa fa-home"></i></a></li>
                            <li><a href="{{route('vinograd.cabinet.home')}}">Кабинет</a></li>
                            <li class="active">Просмотр заказа</li>
                        </ul>
                    </div>
                    <div class="breadcrumb-title">
                        <h1>Просмотр заказа № {{$order->id}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="my-account mb-5">
        <div class="container">
            <div class="table-content table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="plantmore-product-thumbnail"></th>
                        <th class="cart-product-name">Наименование</th>
                        <th class="plantmore-product-price">Цена за шт</th>
                        <th class="plantmore-product-quantity">Кол-во</th>
                        <th class="plantmore-product-subtotal">Сумма</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($order->items as $item)
                        <tr>

                            <td class="plantmore-product-thumbnail">
                                <a href="{{route('vinograd.product', ['slug' => $item->product->slug])}}">
                                    <img src="{{$item->product->getImage('100x100')}}" style="max-width: 100px">
                                </a>
                            </td>
                            <td class="plantmore-product-name">
                                <a href="{{route('vinograd.product', ['slug' => $item->product->slug])}}"><strong>{{$item->product->name}}</strong></a><br>{{$item->modification->property->name}}
                            </td>
                            <td class="plantmore-product-price">
                                <span class="amount">{{currency($item->price)}} {{signature()}}</span>
                            </td>
                            <td class="plantmore-product-quantity">
                                <span class="amount">{{$item->quantity}} шт.</span>
                            </td>
                            <td class="product-subtotal">
                                <span class="amount">{{currency($item->getCost())}} {{signature()}}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"><h3>Заказ пуст.</h3></td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-5 ml-auto">
                    <div class="cart-page-total">
                        <h2>Итоговая стоимость</h2>
                        <ul>
                            <li>Полная стоимость <span>{{currency($order->cost)}} {{signature()}}</span></li>
                            <li>Стоимость доставки: <span>{{currency($order->delivery['cost'])}} {{signature()}}</span></li>
                            <li>К оплате <span>{{currency($order->getTotalCost())}} {{signature()}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
