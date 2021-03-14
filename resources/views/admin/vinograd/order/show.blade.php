@extends('admin.layouts.layout')

@section('title', 'Admin | Заказ № ' . $order->id)
@section('key', 'Admin | Заказ № ' . $order->id)
@section('desc', 'Admin | Заказ № ' . $order->id)

@section('header-title', 'Заказ № ' . $order->id)

@section('content')

<div class="col-12">
    @if($order->note)
    <div class="callout callout-info">
        <h5><i class="fa fa-info"></i> Примечание:</h5>
        {{$order->note}}
    </div>
    @endif
{{--        d-flex justify-content-between--}}

    <div class="card card-outline card-primary">
        <div class="card-header border-transparent">
            <h3 class="card-title">Заказ № {{$order->id}}</h3>
            <div class="card-tools">
                <div class="btn-group" id="nav">
                    @if(!$order->isCompleted())
                        @if($order->isPreliminsry())
                        <a class="btn btn-primary btn-sm" href="{{route('orders.pre.edit', $order->id)}}" role="button">Редактировать</a>
                        @else
                        <a class="btn btn-primary btn-sm" href="{{route('orders.edit', $order->id)}}" role="button">Редактировать</a>
                        @endif
                    @endif
                    @if($order->isSent() && $order->isTrackCode())
                        <a class="btn btn-info btn-sm" href="https://www.belpost.by/Otsleditotpravleniye?number={{$order->track_code}}" role="button" target="_blank">Отслеживание</a>
                    @endif
                    {{Form::open(['route'=>['orders.destroy', $order->id], 'method'=>'delete'])}}
                    <button onclick="return confirm('Подтвердите удаление заказа!')" type="submit" class="btn btn-danger btn-sm">Удалить</button>
                    {{Form::close()}}
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="invoice p-3 mb-3">
                <div class="row invoice-info">
{{--                    <div class="col-sm-4 invoice-col">--}}
{{--                        {{Html::image(Storage::url('/pics/img/logo/logo_vinograd.png'))}}<br>--}}
{{--                        <i class="fa fa-phone"></i>&nbsp;&nbsp;&nbsp;<img src="{{Storage::url('pics/img/velcom.png')}}">&nbsp;&nbsp;&nbsp;{{config('main.phone 1')}}<br>--}}
{{--                        <i class="fa fa-envelope-o"></i>&nbsp;&nbsp;&nbsp;{{config('main.admin_email')}}--}}
{{--                    </div>--}}
                    <div class="col-sm-6 invoice-col">
                        <address>
                            <strong>{{$order->customer['name']}}</strong><br>
                            <i class="fa fa-phone"></i> {{formatPhone($order->customer['phone'])}}<br>
                            <i class="fa  fa-envelope-o"></i> {{$order->customer['email']}}<br>
                            {{$order->delivery['index']}}<br>
                            {{$order->delivery['address']}}<br>

                        </address>
                    </div>
                    <div class="col-sm-6 invoice-col">
                        <b>Номер заказа:</b> {{$order->id}}<br>
                        <b>Дата заказа:</b> {{getRusDate($order->created_at)}}<br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
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
                                    <td>{{$item->price}} руб</td>
                                    <td>{{$item->getCost()}} руб</td>
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
                                <p>{{$order->delivery['cost']}} руб</p>
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
                                            <td>{{$order->cost}} руб</td>
                                        </tr>
                                        @if($order->delivery['cost'])
                                            <tr>
                                                <th style="width:50%">Стоимость доставки:</th>
                                                <td>{{$order->delivery['cost']}} руб</td>
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
                                                {{$order->getTotalCost()}} руб <br>
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

                <div class="row no-print">
                    <div class="col-12">
                        <a href="{{route('orders.print', ['id' => $order->id])}}" target="_blank" class="btn btn-primary">
                            <i class="fa fa-print"></i>
                            Распечатать заказ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card card-outline card-primary">
        <div class="card-header border-transparent">
            <h3 class="card-title">История статусов</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order->statuses_json as $status)
                        <tr>
                            <td>{{getRusDate($status['created_at'])}}</td>
                            <td>{!! $order::statusName($status['value']) !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<div class="col-md-6">
    @if($statusesList)
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Управление статусами</h3>
            </div>
            <div class="card-body">
                {{--            <div class="row">--}}
                {{--                <div class="col-3">--}}
                {{--                    <div class="form-group">--}}
                {{--                        <label>Изменить статус</label>--}}
                {!! Form::open(['route' => 'orders.set_status']) !!}
                {!! Form::hidden('order_id', $order->id) !!}
                <div class="input-group">
                    <select name="status" class="custom-select" id="inputGroupSelect04">
                        <option selected disabled hidden>Выбрать статус</option>
                        @foreach($statusesList as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-success">Изменить статус</button>
                    </div>
                </div>
                {!! Form::close() !!}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="col-4">--}}
                {{--                    <input type="text" class="form-control" placeholder=".col-4">--}}
                {{--                </div>--}}
                {{--                <div class="col-5">--}}
                {{--                    <input type="text" class="form-control" placeholder=".col-5">--}}
                {{--                </div>--}}
                {{--            </div>--}}
            </div>
        </div>
    @endif
</div>
<div class="col-md-6">
    @if($statusesList)
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Выбрать валюту</h3>
        </div>
        <div class="card-body">
{{--            <div class="row">--}}
{{--                <div class="col-3">--}}
{{--                    <div class="form-group">--}}
{{--                        <label>Изменить статус</label>--}}
            {!! Form::open(['route' => 'orders.currency_update']) !!}
            {!! Form::hidden('order_id', $order->id) !!}
            <div class="input-group">

                {{Form::select('currency',
                    $currencys,
                    $order->currency,
                    [
                        'class' => 'custom-select',
                        'id' => 'inputGroup-sizing-sm'
                    ])
                }}
                <div class="input-group-append">
                    <button class="btn btn-success">Изменить валюту</button>
                </div>
            </div>
            {!! Form::close() !!}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-4">--}}
{{--                    <input type="text" class="form-control" placeholder=".col-4">--}}
{{--                </div>--}}
{{--                <div class="col-5">--}}
{{--                    <input type="text" class="form-control" placeholder=".col-5">--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
    @endif
    @if($order->isSent() && $order->isTrackCode())
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Редактировать трек код</h3>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => ['orders.set.track_code', $order->id], 'method' => 'post']) !!}
                {!! Form::hidden('order_id', $order->id) !!}
                    <div class="input-group mt-2">
                        <input name="track_code" class="form-control" value="{{$order->track_code}}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success">Сохранить трек код</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    @endif
</div>
<div class="col-md-6">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Примечание</h3>
        </div>
        <div class="card-body">
            <div class="form-group mt-2">
                {!! Form::open(['route' => ['orders.admin.note.edit', $order->id], 'method' => 'post']) !!}
                <textarea name="admin_note" class="form-control" rows="3" placeholder="Enter ...">{{$order->admin_note}}</textarea>
                <button type="submit" class="btn btn-success">Сохранить примечание</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@if($order->customer['email'])
<div class="col-md-12">
    <div class="card card-primary card-outline">
        {!! Form::open(['route' => 'orders.send_reply_mail']) !!}
        {!! Form::hidden('order_id', $order->id) !!}
        <div class="card-header">
            <h3 class="card-title">Письмо заказчику</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="compose-subject">Тема письма</label>
                <input name="subject" class="form-control" value="Уточнение Вашего заказа на сайте: {{config('app.name')}}" id="compose-subject">
            </div>
            <div class="form-group form-check">
                <input name="add_cart" type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Прикрепить к письму корзину заказа</label>
            </div>
            <div class="form-group">
                <label for="compose-textarea">Сообщение</label>
                <textarea name="message" id="compose-textarea" class="form-control" style="height: 320px">
                </textarea>
            </div>
        </div>
        <div class="card-footer">
            <div class="float-right">
{{--                    <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Черновик</button>--}}
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Отправить</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endif

@endsection
