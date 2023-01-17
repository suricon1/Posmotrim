@extends('admin.layouts.layout')

@section('title', 'Admin | Редактировать Заказ № ' . $order->id)
@section('key', 'Admin | Редактировать Заказ № ' . $order->id)
@section('desc', 'Admin | Редактировать Заказ № ' . $order->id)

@section('header-title', 'Редактировать Заказ № ' . $order->id)

@section('header')
    <link rel="stylesheet" href="/css/dataTables.bootstrap4.css">
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Заказанные позиции</h3>
                <div class="card-tools">
                    <div class="btn-group" id="nav">
                        <a class="btn btn-primary btn-sm" href="{{route('orders.show', $order->id)}}" role="button">Вернуться</a>
                    </div>
                </div>
            </div>
            <div class="card-body table-content table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="cart-product-name">Наименование</th>
                        <th class="plantmore-product-price">Цена за шт</th>
                        <th class="plantmore-product-quantity">Кол-во</th>
                        <th class="plantmore-product-subtotal">Сумма</th>
                        <th class="plantmore-product-remove"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($order->items as $item)
                        <tr>
                            <td class="plantmore-product-name">
                                <a href="{{route('vinograd.product', ['slug' => $item->product->slug])}}" target="_blank"><strong>{{$item->product->name}}</strong></a>
                                <br>{{$item->modification->property->name}}
                            </td>
                            <td class="plantmore-product-price"><span class="amount">{{$item->price}} руб</span></td>
                            <td class="plantmore-product-quantity">
                                {{Form::open(['route'=>['orders.update.item', $order->id]])}}
                                {{Form::hidden('item_id', $item->id)}}
                                <div class="input-group input-group-sm">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">шт: </span>
                                    </span>
                                    {{Form::number('quantity', $item->quantity, ['class' => 'form-control'])}}
                                    <span class="input-group-append">
                                        {{Form::button('<i class="fa fa-refresh"></i>', [
                                            'type' => 'submit',
                                            'class' => "btn btn-sm btn-outline-info btn-flat",
                                            'title' => 'Обновить'
                                        ])}}
                                    </span>
                                </div>
                                {{Form::close()}}
                            </td>
                            <td class="product-subtotal">
                                <span class="amount">{{$item->price * $item->quantity}} руб</span>
                            </td>
                            <td class="plantmore-product-remove">
                                {{Form::open(['route'=>['orders.delete.item', $order->id]])}}
                                {{Form::hidden('item_id', $item->id)}}
                                {{Form::button('<i class="fa fa-times"></i>', [
                                    'type' => 'submit',
                                    'class' => "btn btn-sm btn-outline-danger btn-flat",
                                    'title' => 'Удалить'
                                ])}}
                                {{Form::close()}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"><h3>Закажите что нибудь!</h3></td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
            <hr>
            <div class="card-footer bg-transparent">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive mt-2">
                            <table class="table">
                                <thead>
                                Информация о стоимости заказа
                                </thead>
                                <tbody>
                                <tr>
                                    <th style="width:50%">Стоимость:</th>
                                    <td>{{$order->cost}} руб</td>
                                </tr>
                                @isset($order->delivery['weight'])
                                <tr>
                                    <th style="width:50%">Вес заказа:</th>
                                    <td>{{$order->delivery['weight'] / 1000}} кг.</td>
                                </tr>
                                @endisset
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
                                    <td>{{$order->getTotalCost()}} руб</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 pt-3">
                        @if($order->items->isNotEmpty())
                            {!! Form::open(['route' => ['orders.delivery.edit', $order->id], 'method' => 'get']) !!}
                            <div class="input-group">
                                {{Form::select('delivery_id',
                                    $deliverys,
                                    $order->delivery['method_id'],
                                    [
                                        'class' => 'form-control'
                                    ])
                                }}
                                <div class="input-group-append">
                                    <button class="btn btn-success">Изменить способ доставки</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Добавить</h3>
            </div>
            <div class="card-body table-content table-responsive">
                <table id="example1" class="table">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($products as $product)
                        <tr>
                            <td class="plantmore-product-name">
                                <a href="{{route('vinograd.product', ['slug' => $product->slug])}}" target="_blank">{{$product->name}}</a>
                            </td>
                            <td class="plantmore-product-quantity">
                                @if($product->modifications->count() > 0)

                                    <div class="row">
                                        @foreach($product->modifications as $modification)
                                            <div class="col">{{$modification->property->name}}</div>
                                            <div class="col">В наличии: <strong>{{$modification->quantity}}</strong> шт</div>
                                            <div class="col">Стоимость: <strong>{{$modification->price}}</strong> руб</div>
                                            <div class="col">
                                                {{Form::open(['route'=>['orders.add.item', $order->id], 'style' => 'margin: 2px;'])}}
                                                {{Form::hidden('modification_id', $modification->id)}}
                                                <div class="input-group input-group-sm">
                                                    {{Form::number('quantity', 0, ['class' => 'form-control'])}}
                                                    <span class="input-group-append">
                                                        {{Form::button('Добавить', [
                                                            'type' => 'submit',
                                                            'class' => "btn btn-sm btn-outline-info btn-flat",
                                                            'title' => 'Добавить'
                                                        ])}}
                                                    </span>
                                                </div>
                                                {{Form::close()}}
                                            </div>
                                            <div class="w-100"></div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-danger">Нет в наличии</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')

    <script src="/js/jquery.dataTables.js"></script>
    <script src="/js/dataTables.bootstrap4.js"></script>

    <script>
        $(function () {
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": false,
                "stateSave": true,
                //"aaSorting": [[ 1, "asc" ]],
                "iDisplayLength": 20,
                "aLengthMenu": [[ 10, 20, 50, 100 ,-1],[10,20,50,100,"все"]],

                "language": {
                    "processing": "Подождите...",
                    "search": "Поиск:",
                    "lengthMenu": "Показывать по  _MENU_  записей",
                    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                    "infoEmpty": "Записи с 0 до 0 из 0 записей",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "infoPostFix": "",
                    "loadingRecords": "Загрузка записей...",
                    "zeroRecords": "Записи отсутствуют.",
                    "emptyTable": "В таблице отсутствуют данные",
                    "paginate": {
                        "first": "Первая",
                        "previous": "Предыдущая",
                        "next": "Следующая",
                        "last": "Последняя"
                    },
                }
            });
        });
    </script>

@endsection
