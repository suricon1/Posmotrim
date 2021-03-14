@extends('admin.layouts.layout')

@section('title', 'Admin | Отправить трек код. Заказ № ' . $order->id)
@section('key', 'Admin | Отправить трек код. Заказ № ' . $order->id)
@section('desc', 'Admin | Отправить трек код. Заказ № ' . $order->id)

@section('header-title', 'Отправить трек код. Заказ № ' . $order->id)

@section('content')
    <div class="col-6">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Отправить трек код</h3>
            </div>
            <div class="card-body">
                {{Form::open(['route'=>['orders.sent.status.mail', $order->id]])}}
                <div class="input-group input-group-sm">
                    <input name="track_code" type="text" class="form-control">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-info btn-flat">Отправить</button>
                    </span>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
