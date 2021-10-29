@extends('admin.layouts.layout')

@section('title', 'Admin | Распечатать заказ № ' . $order->id)
@section('key', 'Admin | Распечатать заказ № ' . $order->id)
@section('desc', 'Admin | Распечатать заказ № ' . $order->id)

@section('header-title', 'Распечатать заказ № ' . $order->id)

@section('body-print', ' onload=window.print();')

@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="invoice p-3 mb-3">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            {{config('app.name')}}<br>
                            <i class="fa fa-link"></i>&nbsp;&nbsp;&nbsp;{{config('app.url')}}<br>
                            <i class="fa fa-phone"></i>&nbsp;&nbsp;&nbsp;{{config('main.phone 1')}}<br>
                            <i class="fa fa-envelope-o"></i>&nbsp;&nbsp;&nbsp;{{config('main.admin_email')}}
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <strong>{{$order->customer['name']}}</strong><br>
                                <i class="fa fa-phone"></i> {{formatPhone($order->customer['phone'])}}<br>
                                <i class="fa  fa-envelope-o"></i> {{$order->customer['email']}}<br>
                                {{$order->delivery['index']}}<br>
                                {{$order->delivery['address']}}<br>

                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <b>Номер заказа:</b> {{$order->id}}<br>
                            <b>Дата заказа:</b> {{getRusDate($order->created_at)}}<br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Кол-во</th>
                                    <th>Цена за шт.</th>
                                    <th>Всего</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{$item->product_name}}</strong><br>
                                            {{$item->modification_name}}
                                        </td>
                                        <td>{{$item->quantity}} шт.</td>
                                        <td>{{$item->price}} бел. руб</td>
                                        <td>{{$item->getCost()}} бел. руб</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fa fa-truck"></i>
                                        Информация о доставке
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <h5>Доставка:</h5>
                                    <p>{{$order->delivery['method_name']}}</p>

                                    <h5>Стоимость доставки:</h5>
                                    <p>{{$order->delivery['cost']}} бел. руб</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fa fa-money"></i>
                                        Информация о стоимости заказа
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th style="width:50%">Стоимость:</th>
                                                <td>{{$order->cost}} бел. руб</td>
                                            </tr>
                                            @if($order->delivery['cost'])
                                                <tr>
                                                    <th style="width:50%">Стоимость доставки:</th>
                                                    <td>{{$order->delivery['cost']}} бел. руб</td>
                                                </tr>
                                            @endif
                                            {{--                            <tr>--}}
                                            {{--                                <th>Tax (9.3%)</th>--}}
                                            {{--                                <td>$10.34</td>--}}
                                            {{--                            </tr>--}}
                                            {{--                            <tr>--}}
                                            {{--                                <th>Shipping:</th>--}}
                                            {{--                                <td>$5.80</td>--}}
                                            {{--                            </tr>--}}
                                            <tr>
                                                <th>Итоговая стоимость:</th>
                                                <td>
                                                    {{$order->getTotalCost()}} бел. руб <br>
                                                    ({{mailCurr($currency, $order->getTotalCost())}} {{$currency->sign}})
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($order->note)

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-info"></i>
                        Примечание к заказу:
                    </h3>
                </div>
                <div class="card-body">
                    {{$order->note}}
                </div>
            </div>

            @endif
        </div>
    </div>

@endsection
