@extends('admin.layouts.layout')

@section('title', 'Admin | Список заказов')
@section('key', 'Admin | Список заказов')
@section('desc', 'Admin | Список заказов')

@section('header-title', 'Список заказов')

@section('content')

    <div class="col">

        <div class="card card-default collapsed-card">
            <div class="card-header">
                <button type="button" class="btn btn-tool" data-widget="collapse">
                    <h3 class="card-title"><i class="fa fa-angle-right"></i>Поиск и сортировка</h3>
                </button>
            </div>
            <div class="card-body" style="display: none;">
                <form action="?" method="GET">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="formGroupExampleInput">№ Заказа</label>
                                <input type="text" class="form-control" id="formGroupExampleInput" name="id"
                                       value="{{ request('id') }}">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="inputGroupSelect1">Email</label>
                                <input type="text" class="form-control" id="inputGroupSelect1" name="email"
                                       value="{{ request('email') }}">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="inputGroupSelect1">Телефон</label>
                                <input type="text" class="form-control" id="inputGroupSelect1" name="phone"
                                       value="{{ request('phone') }}">
                            </div>
                            <div class="form-group float-right">
                                <button type="submit" class="btn btn-primary">Найти</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9">
                        <h4>Показать заказы:</h4>
                        <a href="{{route('orders.index')}}" class="btn btn-outline-dark btn-sm">Все</a>
                        @foreach(statusList() as $status => $name)
                            {{ Html::linkRoute('orders.index.status', $name, ['status' => $status], ['class' => 'btn-sm btn btn-' . statusColor($status)]) }}
                        @endforeach
                    </div>
                    <div class="col-3">
                        <h4>Создать заказ:</h4>
                        <a href="{{route('orders.create')}}" class="btn btn-success btn-sm">Новый</a>
                        <a href="{{route('orders.pre.create')}}" class="btn btn-warning btn-sm">Предварительный</a>
                    </div>
                </div>

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
            <div class="card-footer">
                {{$orders->links()}}
            </div>
        </div>

    </div>

@endsection
