@extends('admin.vinograd.analytica.dashboard')

@section('title', 'Admin | Что заказано')
@section('key', 'Admin | Что заказано')
@section('desc', 'Admin | Что заказано')

@section('content')
    <div class="col">
        <h2>Что заказано -</h2>
{{--        <h3><small>{!! $titleDate !!}</small></h3>--}}
        @if (!request('status'))
            <h3>Все заказы <small>{!! $titleDate !!}</small></h3>
        @elseif (request('status') == 7)
            <h3>Предварительные заказы <small>{!! $titleDate !!}</small></h3>
        @elseif (request('status') == 1)
            <h3>Новые заказы <small>{!! $titleDate !!}</small></h3>
        @elseif (request('status') == 8)
            <h3>Сформированные заказы <small>{!! $titleDate !!}</small></h3>
        @endif
        <div class="card">
            <div class="card-header">
                <a href="{{route('dashboard.ordereds', array_merge(request()->query(), ['status' => '']))}}" class="btn btn-info">Все</a>
                <a href="{{route('dashboard.ordereds', array_merge(request()->query(), ['status' => 1]))}}" class="btn btn-success">В новых заказах</a>
                <a href="{{route('dashboard.ordereds', array_merge(request()->query(), ['status' => 7]))}}" class="btn btn-warning">В предварительных заказах</a>
                <a href="{{route('dashboard.ordereds', array_merge(request()->query(), ['status' => 8]))}}" class="btn btn-default">В сформированных заказах</a>

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
                        <th>Цена</th>
                        <th>Стоимость</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($ordereds as $productName => $modifications)
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
                                        <a class="btn btn-block btn-outline-secondary btn-sm" href="{{route('dashboard.ordereds_as_modification', ['product_id' => $modification->product_id, 'modification_id' => $modification->modification_id, 'price' => $modification->price, request()->getQueryString()])}}" role="button">Показать в заказах</a>
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
            </div>
            <div class="card-footer text-right">
            </div>
        </div>
    </div>
@endsection
