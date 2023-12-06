@extends('admin.layouts.layout')

@section('title', 'Admin | Распечатать заказ № ' . $order->id)
@section('key', 'Admin | Распечатать заказ № ' . $order->id)
@section('desc', 'Admin | Распечатать заказ № ' . $order->id)

@section('header-title', 'Распечатать заказ № ' . $order->id)

@section('body-print', ' onload=window.print();')

@section('content')

    @include('admin.vinograd.order.components.print_order')

@endsection
