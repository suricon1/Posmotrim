@extends('admin.layouts.layout')

@section('title', 'Admin | Заказ № ' . $order->id)
@section('key', 'Admin | Заказ № ' . $order->id)
@section('desc', 'Admin | Заказ № ' . $order->id)

@section('header-title', 'Заказ № ' . $order->id)

@section('body-print', ' onload=window.print();')

@section('header')
    <style type="text/css">
        .c11 {
            border-bottom: 1px solid
        }
        .c12 {
            display: inline-block;
            width: 90px;
        }

        .c2 {
            display: inline-block;
            width: 100%;
        }

        p {
            margin: 0 !important;
            font-size: 12pt;
            font-family: "Times New Roman"
        }
    </style>
@endsection

@section('content')
    <div class="row p-4 pb-3" style="width: 71%; background-color: #ffffff; border-bottom: #000000 solid 1px">
        <div class="col-5">
            <span class="c2 mb-5 p-3 text-center">Место для стикера</span>
            <p>
                Nom et adresse de l`expediteur<br>
                Фамилия и адрес отправителя
            </p>
            <span class="c11">{{$order->customer['name']}}</span><br>
            <span class="c11">{{$order->delivery['index']}} {{$order->delivery['address']}}</span>
        </div>

        <div class="col-7 pl-5">
            <div class="row mt-3">
                <div class="col-5 align-self-center">
                    PETIT PAQUET<br>
                    МЕЛКИЙ ПАКЕТ
                </div>
                <div class="col-7">
                    <p>
                        <span>taxe perque:</span>
                        <span class="c11 c12"></span><br>
                        <span>Сбор взыскан:</span>
                    </p>
                    <p class="mt-5">
                        <span>Poids:</span>
                        <span class="c11 c12"></span><br>
                        <span>Вес:</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row p-4" style="width: 71%; background-color: #ffffff; height: 150px">
        <div class="col-5 align-self-center">
            (Место для наклеивания<br>таможенной декларации CN22)
        </div>
        <div class="col-7">
            <p>
                Nom et adresse du destinataire<br>
                Фамилия и адрес получателя
            </p>
            <span class="c11">{{$order->customer['name']}}</span><br>
            <span class="c11">{{$order->delivery['index']}} {{$order->delivery['address']}}</span>
        </div>
    </div>
@endsection
