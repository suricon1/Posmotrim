@extends('admin.layouts.layout')

@section('title', 'Admin | Заказ № ' . $order->id . '. Печать наклейки, посылка по РБ')
@section('key', 'Admin | Заказ № ' . $order->id . '. Печать наклейки, посылка по РБ')
@section('desc', 'Admin | Заказ № ' . $order->id . '. Печать наклейки, посылка по РБ')

@section('header-title', 'Заказ № ' . $order->id . '. Печать наклейки, посылка по РБ')

@section('body-print', ' onload=window.print();')

@section('header')


    <style type="text/css">
        .c9 {
            color: #969394;
            font-size: 8pt;
            font-family: "Times New Roman";
            display: block;
            margin-top: -6px
        }

        .c11 {
            border-bottom: 1px solid
        }

        .c12 {
            display: inline-block;
            width: 42%;
            border-bottom: 1px solid;
        }

        .c2 {
            display: inline-block;
            border: 1px solid #000000;
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
    <div class="row p-2" style="width: 71%; background-color: #ffffff; margin: 0 auto;">
        <div class="col-5">
            <p class="text-center"> Отправитель</p>
            <span class="mr-2">ОТ КОГО:</span>
            <span class="c11">{{config('main.admin_name')}}</span>
            <br>

            <span class="mr-2">АДРЕС:</span>
            <span class="c11">{{config('main.admin_index')}} {{config('main.admin_address')}}</span>
            <br>

            <span class="mr-2">МОБ. ТЕЛ.:</span>
            <span class="c11">{{config('main.phone 1')}}</span>

            <span class="c2 mt-1 p-3 text-center">Место для стикера</span>
            <div class="row mt-3">
                <div class="col-3">ВЕС:</div>
                <div class="col-9">
                    <span class="c12"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-3">ПЛАТА:</div>
                <div class="col-9">
                    <span class="c12"></span>
                </div>
            </div>
            <p class="mt-3" style="font-size: 10px;">Упаковано по желанию отправителя.<br>Запрещенных к пересылке вложений нет. С требованиями к упаковке ознакомлен.</p>
            <span style="display: inline-block; width: 100px; border-bottom: 1px solid; margin-left: 160px;"></span>
            <span class="c9" style="margin-left: 185px">(подпись)</span>
        </div>

        <div class="col-7 pl-5">
            <span class="mr-2">Объявленная ценнность:</span>
            <span class="c12"></span>
            <br>
            <span class="c11 mt-3" style="display: block"></span>
            <span class="c9" style="text-align: center; margin-top: -2px">(сумма прописью)</span>

            <p style="text-align: right;"><span style="display: inline-block; width: 150px; height: 150px; border: 1px dashed;"></span></p>
            <span class="c9" style="text-align: right;">Оттиск КШ</span>

            <p class="text-center">Получатель</p>
            <span class="mr-2">КОМУ:</span>
            <span class="c11">{{$order->customer['name']}}</span>
            <br>

            <span class="mr-2">КУДА:</span>
            <span class="c11">{{$order->delivery['index']}} {{$order->delivery['address']}}</span>
            <br>

            <span class="mr-2">МОБ. ТЕЛ.:</span>
            <span class="c11">{{$order->customer['phone']}}</span>
            <p class="text-right">№ {{$order->id}}</p>
        </div>
    </div>
@endsection
