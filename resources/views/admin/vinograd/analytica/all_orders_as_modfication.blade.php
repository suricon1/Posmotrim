@extends('admin.layouts.layout')

@section('title', 'Admin | Dashboard')
@section('key', 'Admin | Dashboard')
@section('desc', 'Admin | Dashboard')

@section('header')
    <link rel="stylesheet" href="/css/jquery.periodpicker.min.css">
@endsection

{{--@section('header-title', 'Dashboard')--}}

@section('content')
    <div class="col">
        <h3>{{$title}} -</h3>
        @if (!request('status'))
            <h2>Выполненные заказы <small>{!! $titleDate !!}</small></h2>
        @elseif (request('status') == 7)
            <h2>Предварительные заказы <small>{!! $titleDate !!}</small></h2>
        @elseif (request('status') == 1)
            <h2>Новые заказы <small>{!! $titleDate !!}</small></h2>
        @endif
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Доставка</th>
                        <th>Создан</th>
                        <th>Закрыт</th>
                        <th>Стоимость</th>
                        <th>Заказчик</th>
                        <th>Примечание</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->delivery['method_name']}}</td>
                            <td>{{getRusDate($order->created_at)}}</td>
                            <td>{{$order->completed_at}}</td>
                            <td>
                                {{$order->cost}} бел. руб
                                @if($order->currency !== 'BYN')
                                    <br>
                                    {{mailCurr($currency[$order->currency], $order->getTotalCost()) }} {{ $currency[$order->currency]->sign}}
                                @endif
                            </td>
                            <td>{{$order->customer['name']}}</td>
                            <td>{{$order->admin_note}}</td>
                            <td>{!! $order->statusName($order->current_status) !!}</td>
                            <td>
                                <div class="btn-group" id="nav">
                                    @if(!$order->isCompleted())
                                        @if($order->isPreliminsry())
                                            <a class="btn btn-outline-primary btn-sm" href="{{route('orders.pre.edit', $order->id)}}" role="button"><i class="fa fa-pencil"></i></a>
                                        @else
                                            <a class="btn btn-outline-primary btn-sm" href="{{route('orders.edit', $order->id)}}" role="button"><i class="fa fa-pencil"></i></a>
                                        @endif
                                    @endif
                                    <a class="btn btn-outline-secondary btn-sm" href="{{route('orders.show', $order->id)}}" role="button"><i class="fa fa-eye"></i></a>
                                    @if($order->isSent() && $order->isTrackCode())
                                        <a class="btn btn-outline-info btn-sm" href="{{config('main.tracking_post')}}{{$order->track_code}}" role="button" target="_blank"><i class="fa fa-truck"></i></a>
                                    @endif
                                    {{Form::open(['route'=>['orders.destroy', $order->id], 'method'=>'delete'])}}
                                    <button onclick="return confirm('Подтвердите удаление заказа!')" type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-remove"></i></button>
                                    {{Form::close()}}
                                </div>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-right">
                {{$orders->links()}}
            </div>
        </div>
@endsection
