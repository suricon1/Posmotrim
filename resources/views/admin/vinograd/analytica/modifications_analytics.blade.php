@extends('admin.vinograd.analytica.dashboard')

@section('title', 'Admin | Аналитика по модификациям')
@section('key', 'Admin | Аналитика по модификациям')
@section('desc', 'Admin | Аналитика по модификациям')

@section('content')
    <div class="col">
        <h2>Аналитика по модификациям -</h2>
        @if (!request('status'))
            <h3>Выполненные заказы <small>{!! $titleDate !!}</small></h3>
        @elseif (request('status') == 7)
            <h3>Предварительные заказы <small>{!! $titleDate !!}</small></h3>
        @elseif (request('status') == 1)
            <h3>Новые заказы <small>{!! $titleDate !!}</small></h3>
        @elseif (request('status') == 8)
            <h3>Сформированные заказы <small>{!! $titleDate !!}</small></h3>
        @endif
        <div class="card">
            <div class="card-header">
                <a href="{{route('dashboard.modifications', array_merge(request()->query(), ['status' => '']))}}" class="btn btn-info">В выполненных заказах</a>
                <a href="{{route('dashboard.modifications', array_merge(request()->query(), ['status' => 1]))}}" class="btn btn-success">В новых заказах</a>
                <a href="{{route('dashboard.modifications', array_merge(request()->query(), ['status' => 7]))}}" class="btn btn-warning">В предварительных заказах</a>
                <a href="{{route('dashboard.modifications', array_merge(request()->query(), ['status' => 8]))}}" class="btn btn-default">В сформированных заказах</a>

                @include('admin.vinograd.analytica._periodpicker', ['route' => 'dashboard.modifications'])

                <div class="card-tools">
                    <h3 class="card-title">Итого: <b>{{$totalCost}}</b> руб</h3>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Модификация</th>
                        <th>Колличество</th>
                        <th>Цена</th>
                        <th>Стоимость</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($modifications as $modification)
                        <tr>
                            <td>{{$modification->name}}</td>
                            <td>{{$modification->allQuantity}} шт</td>
                            <td>{{$modification->price}} руб.</td>
                            <td>{{$modification->cost}} руб.</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
            </div>
        </div>
    </div>
@endsection
