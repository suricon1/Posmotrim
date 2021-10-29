@extends('admin.layouts.layout')

@section('title', 'Admin | Печать. Избранные номера заказов')
@section('key', 'Admin | Печать. Избранные номера заказов')
@section('desc', 'Admin | Печать. Избранные номера заказов')

@section('header-title', 'Печать. Избранные номера заказов')

@section('body-print', ' onload=window.print();')

@section('content')

    <div class="col">
        <div class="card">
            <div class="card-body table-responsive">
                <table id="example1" class="table table-sm table-condensed">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Модификация</th>
                        <th>Колличество</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $productName => $modifications)
                        <tr>
                            <td rowspan="{{$modifications->count()}}">{{$productName}}</td>
                        @foreach($modifications as $modification)

                            @if(!$loop->first)
                                <tr>
                                    @endif

                                    <td>{{$modification->modification_name}}</td>
                                    <td><b>{{$modification->allQuantity}}</b> шт</td>

                                    @if(!$loop->last)
                                </tr>
                                @endif

                        @endforeach

                                </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
