@extends('admin.layouts.layout')

@section('title', 'Admin | Заказ № ' . $order->id)
@section('key', 'Admin | Заказ № ' . $order->id)
@section('desc', 'Admin | Заказ № ' . $order->id)

@section('header')
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
@endsection

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
            <h3 class="card-title">
                @if($order->isCreatedByAdmin())
                    <span class="fa fa-check text-danger"></span>
                @endif
                Заказ № {{$order->id}}
            </h3>
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
                        <a href="{{route('orders.repeat.create', $order->id)}}" class="btn btn-outline-success btn-sm" onclick="return confirm('Создать новый заказ для этого покупателя?!')"><i class="fa fa-plus"></i></a>
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
                        <b>Создан:</b> {{getRusDate($order->created_at)}}<br>
                        <b>Закрыт:</b> {{$order->completed_at}}<br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr class="ba">
                                <th>Название</th>
                                <th>Кол-во</th>
                                <th>Цена за шт.</th>
                                <th>Всего</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($items as $item)
                                <tr class="{{$item->availability < 0 ? 'table-danger' : ''}}">
                                    <td>
                                        <strong>{{$item->product_name}}</strong><br>
                                        {{$item->modification_name}}
                                    </td>
                                    <td>{{$item->quantity}} шт.</td>
                                    <td>{{$item->price}} руб</td>
                                    <td>{{$item->getCost()}} руб</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th><h5>Общее колличество</h5></th>
                                <td>
                                    @foreach ($quantityByModifications as $name => $value)
                                        <p>{{$name}}: <strong>{{$value}}</strong> шт</p>
                                    @endforeach
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
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
                                @isset($order->delivery['weight'])
                                    <h5>Вес заказа:</h5>
                                    <p>{{$order->delivery['weight'] / 1000}} кг.</p>
                                @endisset
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
                                            <td>
                                                {{$order->cost}} руб <br>
                                                ({{mailCurr($currency, $order->cost)}} {{$currency->sign}})
                                            </td>
                                        </tr>
                                        @if($order->delivery['cost'])
                                            <tr>
                                                <th style="width:50%">Стоимость доставки:</th>
                                                <td>
                                                    {{$order->delivery['cost']}} руб <br>
                                                    ({{mailCurr($currency, $order->delivery['cost'])}} {{$currency->sign}})
                                                </td>
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
                        @if(!$order->print_count)
                        <a href="{{route('orders.print.order', ['id' => $order->id])}}" target="_blank" class="print btn btn-primary" data-order_id="{{$order->id}}">
                            <i class="fa fa-print"></i>
                            Распечатать заказ
                        </a>
                        @else
                        <a href="{{route('orders.print.order', ['id' => $order->id])}}" target="_blank" class="print btn btn-danger" data-order_id="{{$order->id}}">
                            <i class="fa fa-print"></i>
                            Распечатан {{$order->print_count}} раз
                        </a>
                        @endif
                        @if($order->delivery['method_id'] == 2)
                        <a href="{{route('orders.print.nalozhka_blanck', ['id' => $order->id])}}" target="_blank" class="btn btn-primary">
                            <i class="fa fa-print"></i>
                            Наложенный платеж бланк
                        </a>
                        <a href="{{route('orders.print.nalozhka_sticker', ['id' => $order->id])}}" target="_blank" class="btn btn-primary">
                            <i class="fa fa-print"></i>
                            Наложенный платеж Наклейка
                        </a>
                        <a href="{{route('orders.print.declared_sticker', ['id' => $order->id])}}" target="_blank" class="btn btn-primary">
                            <i class="fa fa-print"></i>
                            По РБ без наложки наклейка
                        </a>
                        @endif
                        @if($order->delivery['method_id'] == 5)
                        <a href="{{route('orders.print.small_package_sticker', ['id' => $order->id])}}" target="_blank" class="btn btn-primary">
                            <i class="fa fa-print"></i>
                            Мелкий пакет наклейка
                        </a>
                        @endif
                        @if($order->delivery['method_id'] == 5)
                            <a href="{{route('orders.print.small_package_sticker_2', ['id' => $order->id])}}" target="_blank" class="btn btn-primary">
                                <i class="fa fa-print"></i>
                                Мелкий пакет наклейка 2
                            </a>
                        @endif
                        @if($order->delivery['method_id'] == 6)
                            <a href="{{route('orders.print.postal_belarus_sticker', ['id' => $order->id])}}" target="_blank" class="btn btn-primary">
                                <i class="fa fa-print"></i>
                                По РБ без наложки наклейка
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if($other_orders)
        <div class="card-footer  text-muted">
            <p>Предыдущие заказы</p>
            <table id="example1" class="table table-bordered table-striped">
                <tbody>

                @foreach($other_orders as $other_order)
                    <tr>
                        <td>
                            {{$other_order->id}}
                            @if($other_order->isCreatedByAdmin())
                                <span class="fa fa-check text-danger"></span>
                            @endif
                        </td>
                        <td>{{$other_order->delivery['method_name']}}</td>
                        <td>{{getRusDate($other_order->created_at)}}</td>
                        <td> {{$other_order->cost}} бел. руб</td>
                        <td>{{$other_order->customer['name']}}</td>
                        <td>{{$other_order->admin_note}}</td>
                        <td>{!! $other_order->statuses->name($other_order->current_status) !!}</td>
                        <td>
                            <div class="btn-group" id="nav">
                                <a class="btn btn-outline-secondary btn-sm" href="{{route('orders.show', ['order' => $other_order->id])}}" role="button"><i class="fa fa-eye"></i></a>
                                @if($other_order->isNew() AND $order->isNew())
{{--                                    {{dd($order->id, $other_order->id)}}--}}
                                    <a class="btn btn-outline-primary btn-sm" href="{{route('orders.merge', ['order_id' => $order->id, 'merge_order_id' => $other_order->id])}}" role="button"><i class="fa fa-compress"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
        @endif
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
                            <td>{!! $order->statuses->name($status['value']) !!}</td>
{{--                            <td>{!! $order::statusName($status['value']) !!}</td>--}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<div class="col-md-6">
    @if($order->statuses->allowedTransitions)
{{--    @if($statusesList)--}}
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Управление статусами</h3>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'orders.set_status', 'data-name' => 'status']) !!}
                {!! Form::hidden('order_id', $order->id) !!}
                <div class="input-group">
                    <select name="status" class="custom-select" id="inputGroupSelect04">
                        <option selected disabled hidden>Выбрать статус</option>
                        @foreach($order->statuses->allowedTransitions as $key => $value)
{{--                        @foreach($statusesList as $key => $value)--}}
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-success">Изменить статус</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        @if($order->isAllowedDateBuild())
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Дата выдачи/отправки</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-calendar"></i>
                          </span>
                        </div>
                        {!! Form::text('build', $order->getDateBuild(), ['class' => 'form-control float-right', 'data-build' => 'build', 'data-order_id' => $order->id]) !!}
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>
<div class="col-md-6">
    @if($order->statuses->allowedTransitions)
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
                {!! Form::open(['route' => 'orders.admin.note.edit', 'method' => 'post']) !!}
                {!! Form::hidden('order_id', $order->id) !!}
                <textarea name="admin_note" class="form-control" rows="3" placeholder="Enter ...">{{$order->admin_note}}</textarea>
                <button type="submit" class="btn btn-success">Сохранить примечание</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</div>
@if($order->correspondences->isNotEmpty())
<div class="col-md-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Отправленные письма</h3>
        </div>
        @foreach($order->correspondences as $correspondence)
        <div class="card">
            <div class="card-header">
                {{getRusDate($correspondence->created_at)}}
            </div>
            <div class="card-body">
                <p class="card-text">{!! nl2br($correspondence->message, true) !!}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@if($order->customer['email'])
<div class="col-md-12">
    <div class="card card-primary card-outline">
        {!! Form::open(['route' => 'orders.send_reply_mail']) !!}
        {!! Form::hidden('order_id', $order->id) !!}
        <div class="card-header">
            <h3 class="card-title">Написать письмо заказчику</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="compose-subject">Тема письма</label>
                <input name="subject" class="form-control" value="Уточнение Вашего заказа на сайте: {{config('app.name')}}" id="compose-subject">
            </div>
{{--            <div class="form-group form-check">--}}
{{--                <input name="add_cart" type="checkbox" class="form-check-input" id="exampleCheck1">--}}
{{--                <label class="form-check-label" for="exampleCheck1">Прикрепить к письму корзину заказа</label>--}}
{{--            </div>--}}
            <div class="form-row align-items-center">

                <div class="col-auto">
                    <div class="form-check mb-2">
                        <input name="add_cart" type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Прикрепить к письму корзину заказа</label>
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary mb-2"
                            data-name="insert"
                            data-text="
Здравствуйте, {{$order->customer['name']}}.
Заказ принят.
Оплата на карту 4916 9896 9547 3511 до 07/27, (через интернет-банкинг Перевод с карты на карту).
Просьба после оплаты прислать подтверждающее письмо, в нем достаточно указать номер вашего заказа.
Саму оплату я вижу, но не вижу имя отправителя денежных средств.
Отправка после оплаты в течение нескольких рабочих дней.
После отправки высылаем трек-номер для отслеживания.
Обращаем ваше внимание, что заказ будет действителен в течение 5 календарных дней.
Если в течение этого срока мы не получаем от вас никакой обратной связи, то отменяем заказ.
Надеемся на ваше понимание.

"
                    >Реквизиты Беларусь</button>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary mb-2"
                            data-name="insert"
                            data-text="
Здравствуйте, {{$order->customer['name']}}.
Проверьте, пожалуйста, заказ.
Отправляем по предоплате.
Номер карты: 2204120108204575 (карта Российского банка).
Срок действия: 12/27
Просьба после оплаты прислать подтверждающее письмо, в нем достаточно указать номер вашего заказа.
Саму оплату я вижу, но не вижу имя отправителя денежных средств.
Отправка после оплаты в течение нескольких рабочих дней.
После отправки мы высылаем трек-номер для отслеживания.
P.S.
Обращаем ваше внимание, что заказ будет действителен в течение 5 календарных дней.
Если в течение этого срока мы не получаем от вас никакой обратной связи, то отменяем заказ.
Надеемся на ваше понимание.

"
                    >Реквизиты Россия</button>
                </div>
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

@section('scripts')
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>

    <script>
        const order_id = {{$order->id}};

        const print_url = '{{route('orders.print.ajax.print.order')}}';
        const build_url = '{{route('orders.ajax.build')}}';

        window.addEventListener('DOMContentLoaded', function() {

            const getData = async (data, url ) => {

                const res = await fetch(url + searchParams(data));
                return await res.json();
            }

            function searchParams(data) {
                let search = window.location.search
                    ? window.location.search + '&'
                    : '?';
                return data
                    ? search + new URLSearchParams(data).toString()
                    : search;
            }

            const print_button = document.querySelector(".print");
            print_button.addEventListener('click', (e) => {
                e.preventDefault();

                let data = {
                    order_id: order_id
                    // order_id: print_button.getAttribute("data-order_id")
                }
                getData(data, print_url)
                    .then(data => {
                        if (data.success) {
                            const printCSS = '<link rel="stylesheet" href="/css/adminlte.min.css">';
                            const windowPrint = window.open('','','left=50,top=50,width=1000,height=800,toolbar=0,scrollbars=1,status=0');
                            windowPrint.document.write(printCSS);
                            windowPrint.document.write(data.success.print_order);
                            windowPrint.document.close();
                            windowPrint.focus();
                            windowPrint.print();
                            windowPrint.close();

                            print_button.innerHTML = data.success.print_count;
                            print_button.classList.remove('btn-primary');
                            print_button.classList.add('btn-danger');

                        } else if (data.errors) {
                            errors_list(data.errors);
                        } else {
                            errors_list('Неизвестная ошибка. Повторите попытку, пожалуйста!');
                        }
                    }).catch((xhr) => {
                        console.log(xhr);
                    });
            });

            function errors_list(data) {
                $(function() {
                    toastr.error(get_list(data));
                });
            }
            function get_list(data) {
                let temp = '';
                if((typeof data) != 'string'){
                    for (var error in data) {
                        temp = temp + '<li>' + data[error] + "</li>";
                    }
                }else{
                    temp = '<li>' + data + "</li>";
                }
                return temp;
            }

            const textarea = document.querySelector('textarea[name=message]');
            const buttons = document.querySelectorAll('button[data-name=insert]');
            buttons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();

                    const text = e.target.getAttribute('data-text');
                    textarea.value += text;
                });
            });

            @include('admin.vinograd.order.components.scripts.data-picker')

        });
    </script>

@endsection
