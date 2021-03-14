@extends('admin.vinograd.analytica.dashboard')

@section('title', 'Admin | Аналитика по методу доставки')
@section('key', 'Admin | Аналитика по методу доставки')
@section('desc', 'Admin | Аналитика по методу доставки')

@section('content')
    <div class="col">
        <h2>Аналитика по методу доставки -</h2>
        @if (!request('status'))
            <h3>Выполненные заказы <small>{!! $titleDate !!}</small></h3>
        @elseif (request('status') == 7)
            <h3>Предварительные заказы <small>{!! $titleDate !!}</small></h3>
        @elseif (request('status') == 1)
            <h3>Новые заказы <small>{!! $titleDate !!}</small></h3>
        @endif
        <div class="card">
            <div class="card-header">
                <a href="{{route('dashboard.deliverys', array_merge(request()->query(), ['status' => '']))}}" class="btn btn-info">В выполненных заказах</a>
                <a href="{{route('dashboard.deliverys', array_merge(request()->query(), ['status' => 1]))}}" class="btn btn-success">В новых заказах</a>
                <a href="{{route('dashboard.deliverys', array_merge(request()->query(), ['status' => 7]))}}" class="btn btn-warning">В предварительных заказах</a>

                <form action="?" method="GET">
                    <div class="input-group input-group-sm mt-3">
                        <input name="from" id="periodpickerstart" type="text" />
                        <input name="to" id="periodpickerend" type="text" />
                        @if(request('status'))
                            <input name="status" type="hidden" value="{{request('status')}}" />
                        @endif
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Показать</button>
                        </div>
                    </div>
                </form>

                <div class="card-tools">
                    <h3 class="card-title">Итого: <b>{{$totalCost}}</b> руб</h3>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="example1" class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Модификация</th>
                        <th>Колличество</th>
                        <th>Стоимость</th>
{{--                        <th>Стоимость</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($deliverys as $deliveryName => $items)
                        <tr>
                            <td rowspan="{{count($items)}}">
                                {{$deliveryName}}<br>
                                <b>{{(collect($items)->sum('cost'))}} руб</b>
                            </td>
                        @foreach($items as $name => $item)

                        @if(!$loop->first)
                            <tr>
                        @endif
                            <td>{{$name}}</td>
                            <td><b>{{$item['allQuantity']}}</b> шт</td>
{{--                            <td><b>{{$item->price}}</b> руб</td>--}}
                            <td><b>{{$item['cost']}}</b> руб</td>
{{--                                    <td>--}}
{{--                                        <a class="btn btn-block btn-outline-secondary btn-sm" href="{{route('dashboard.orders_as_modification', ['product_id' => $modification->product_id, 'modification_id' => $modification->modification_id, request()->getQueryString()])}}" role="button">Показать в заказах</a>--}}
{{--                                    </td>--}}

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




{{--                    @foreach($deliverys as $modification)--}}
{{--                        <tr>--}}
{{--                            <td>{{$modification->name}}</td>--}}
{{--                            <td>{{$modification->allQuantity}} шт</td>--}}
{{--                            <td>{{$modification->price}} руб.</td>--}}
{{--                            <td>{{$modification->cost}} руб.</td>--}}
{{--                        </tr>--}}

{{--                    @endforeach--}}
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
            </div>
        </div>
    </div>
@endsection
