@extends('admin.layouts.layout')

@section('title', 'Admin | Отправить трек код. Заказ № ' . $order->id)
@section('key', 'Admin | Отправить трек код. Заказ № ' . $order->id)
@section('desc', 'Admin | Отправить трек код. Заказ № ' . $order->id)

@section('header-title', 'Отправить трек код. Заказ № ' . $order->id)

@section('content')
    <div class="col-6">
        @include('admin.vinograd.order.components.treck_code_form', ['id' => $order->id])
    </div>
@endsection
