@extends('admin.vinograd.analytica.dashboard')

@section('title', 'Admin | Аналитика по сортам')
@section('key', 'Admin | Аналитика по сортам')
@section('desc', 'Admin | Аналитика по сортам')

@section('content')

    <div class="col">
        @if (!request('status'))
            <h2>Выполненные заказы <small>{!! $titleDate !!}</small></h2>
        @elseif (request('status') == 7)
            <h2>Предварительные заказы <small>{!! $titleDate !!}</small></h2>
        @elseif (request('status') == 1)
            <h2>Новые заказы <small>{!! $titleDate !!}</small></h2>
        @elseif (request('status') == 8)
            <h2>Сформированные заказы <small>{!! $titleDate !!}</small></h2>
        @endif
        <div class="card">
            <div class="card-header">
                <a href="{{route('dashboard.sorts', array_merge(request()->query(), ['status' => '']))}}" class="btn btn-info">Показать выполненные заказы</a>
                <a href="{{route('dashboard.sorts', array_merge(request()->query(), ['status' => 1]))}}" class="btn btn-success">Показать новые заказы</a>
                <a href="{{route('dashboard.sorts', array_merge(request()->query(), ['status' => 7]))}}" class="btn btn-warning">Показать предварительные заказы</a>
                <a href="{{route('dashboard.sorts', array_merge(request()->query(), ['status' => 8]))}}" class="btn btn-default">Показать сформированные заказы</a>

                @include('admin.vinograd.analytica._periodpicker', ['route' => 'dashboard.sorts'])

                <div class="card-tools">
                    <h3 class="card-title">Итого: <b>{{$totalCost}}</b> руб</h3>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="example1" class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Модификации</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($array as $productName => $modifications)
                        <tr>
                            <td rowspan="{{$modifications->count()}}">{{$productName}}</td>
                        @foreach($modifications as $modification)

                        @if(!$loop->first)
                            <tr>
                        @endif

                                    <td>{{$modification->modification_name}}</td>
                                    <td><b>{{$modification->allQuantity}}</b> шт</td>
                                    <td><b>{{$modification->price}}</b> руб</td>
                                    <td><b>{{$modification->cost}}</b> руб</td>
                                    <td>
                                        <a class="btn btn-block btn-outline-secondary btn-sm" href="{{route('dashboard.orders_as_modification', ['product_id' => $modification->product_id, 'modification_id' => $modification->modification_id, 'price' => $modification->price, request()->getQueryString()])}}" role="button">Показать в заказах</a>
                                    </td>

                                    @if(!$loop->last)
                                </tr>
                                @endif

                                @endforeach

                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"><h3>Нет продаж</h3></td>
                                    </tr>
                                @endforelse
                    </tbody>
                </table>

                <table id="example2" class="table table-condensed">
                </table>

            </div>
            <div class="card-footer text-right">
                <h3 class="card-title">Итого: <b>{{$totalCost}}</b> руб</h3>
            </div>
        </div>
    </div>

@endsection
