@extends('admin.layouts.layout')

@section('title', 'Admin | Заказ № ' . $order->id . '. Печать наклейки мелкий пакет 2')
@section('key', 'Admin | Заказ № ' . $order->id . '. Печать наклейки мелкий пакет 2')
@section('desc', 'Admin | Заказ № ' . $order->id . '. Печать наклейки мелкий пакет 2')

@section('header-title', 'Заказ № ' . $order->id . '. Печать наклейки мелкий пакет 2')

@section('body-print', ' onload=window.print();')

@section('header')
    <style type="text/css">
        .c11 {
            border-bottom: 1px solid
        }
        .c12 {
            border-right: 1px solid
        }
        .c1 {
            border: 1px solid
        }
        .c2 {
            display: inline-block;
            width: 100%;
        }
        .fs10 {
            font-size: 9px;
            margin-left: -5px !important;
        }
        .lh11 {
            line-height: 11px;
        }

        p {
            margin: 0 !important;
            font-size: 12pt;
            font-family: "Times New Roman"
        }
    </style>
@endsection

@section('content')


    <div class="row pt-3" style="width: 71%; background-color: #ffffff; border-bottom: #000000 solid 1px; margin: 0 auto;">
        <div class="col-6 c1">
            <div class="row" style="border-bottom: #000000 solid 1px">
                <div class="col-6 pb-3 c12">
                    <p>POSTAGE PAID/<br>Сбор взыскан</p>
                </div>
                <div class="col-6 pb-3">
                    <p class="text-bold">SMALL PACKAGE<br> МЕЛКИЙ ПАКЕТ</p>
                </div>
            </div>
            <p>От кого (Ф.И.О)/From:</p>
            <p class="c11 text-bold">
                {{config('main.admin_name')}}
            </p>
            <p>Адрес отправителя / Sender`s address:</p>
            <p class="c11 text-bold">
                {{config('main.admin_index')}}<br>{{config('main.admin_address')}}
            </p>
            <p>Кому (Ф.И.О) / To:</p>
            <p class="c11 text-bold">
                {{$order->customer['name']}}
            </p>
            <p>Адрес получателя / Addressee`s address:</p>
            <p class="c11 text-bold">
                {{$order->delivery['index']}}<br>{{$order->delivery['address']}}<br><span class="text-black-50">тел:</span> {{$order->customer['phone']}}
            </p>
            <p>Место для стикера / Place for sticker</p>
        </div>

        <div class="col-6 c1">
            <div class="c11 row">
                <div class="col-5">
                    <p class="text-bold fs10">
                        CUSTOMS DECLARATION<br>ТАМОЖЕННАЯ<br>ДЕКЛАРАЦИЯ
                    </p>
                </div>
                <div class="col-4">
                    <p class="lh11 fs10">
                        MAY BE OPENED<br>OFICCIALLY<br>Может быть вскрыто<br>в служебном порядке
                    </p>
                </div>
                <div class="col-3">
                    <p class="text-bold" style="font-size: x-large">
                        CN 22
                    </p>
                </div>
            </div>
            <div class="c11 row">
                <div class="col-8 c12">
                    <p class="lh11 fs10">
                        Designated operator<br>
                        Назначенный оператор
                    </p>
                    <p class="text-bold">
                        EUR Belpochta
                    </p>
                </div>
                <div class="col-4"></div>
            </div>
            <div class="c11 row">
                <div class="col-1 c12">
                    <p class="text-bold">V</p>
                </div>
                <div class="col-3 c12">
                    <p class="lh11 fs10">
                        Подарок/<br>Gift
                    </p>
                </div>
                <div class="col-1 c12"></div>
                <div class="col-7">
                    <p class="fs10">
                        Коммерческий образец/Commercial sample(s)
                    </p>
                </div>
            </div>
            <div class="c11 row">
                <div class="col-1 c12"></div>
                <div class="col-3 c12">
                    <p class="lh11 fs10">
                        Документы/<br>Documents
                    </p>
                </div>
                <div class="col-1 c12"></div>
                <div class="col-7">
                    <p class="fs10">
                        Возврат товара/Return goods
                    </p>
                </div>
            </div>
            <div class="c11 row">
                <div class="col-1 c12"></div>
                <div class="col-3 c12">
                    <p class="lh11 fs10">
                        Продажа товара/<br>Sale of goods
                    </p>
                </div>
                <div class="col-1 c12"></div>
                <div class="col-7">
                    <p class="fs10">
                        Прочее (просьба указать)/Others (please specify): <span class="c11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </p>
                </div>
            </div>

            <div class="c11 row">
                <div class="col-4 c12">
                    <p class="lh11 fs10">
                        Количество и подробное описание вложения<br>Quantity and detailed description (1)
                    </p>
                </div>
                <div class="col-2 c12">
                    <p class="lh11 fs10">
                        Вес (в кг)<br>Weight<br>(in kg) (2)
                    </p>
                </div>
                <div class="col-2 c12">
                    <p class="lh11 fs10">
                        Стоимость и валюта<br>Value and currency (3)
                    </p>
                </div>
                <div class="col-2 c12">
                    <p class="lh11 fs10">
                        Код ТНВЭД*<br>HS Tariff number (4)
                    </p>
                </div>
                <div class="col-2">
                    <p class="lh11 fs10">
                        Страна происхождения товара/Country of origin (5)
                    </p>
                </div>
            </div>
            <div class="c11 row" style="height: 80px">
                <div class="col-4 c12">
                    <p class="text-bold">Материалы для творчества</p>
                </div>
                <div class="col-2 c12"></div>
                <div class="col-2 c12">
                    <p class="text-bold">{{$cost}} RUB</p>
                </div>
                <div class="col-2 c12"></div>
                <div class="col-2"></div>
            </div>
            <div class="c11 row">
                <div class="col-6 c12">
                    <p class="lh11 fs10">
                        Общий вес (в кг)*<br>Total weight (in kg)<br>(6)
                    </p>
                </div>
                <div class="col-4 c12">
                    <p class="lh11 fs10">
                        Общая стоимость/<br>Total value<br>(7)
                    </p>
                </div>
                <div class="col-2 c12"></div>
            </div>
            <p class="lh11 fs10">
                I, the undersigned whose name and address are given on the item, certify that the particulars given in this Declaration are correct and that this item does not contain any dangerous article or articles prohibited by legislation or by postal or customs regulations.
            </p>
            <p class="lh11 fs10">
                Я, нижеподписавшийся (фамилия и адрес указаны на отправлении), подтверждаю, что приведенные в настоящей таможенной декларации сведения являются достоверными, и что в этом отправлении не содержится никаких опасных или запрещенных законодательством, или почтой, или таможенной регламентацией предметов.
            </p>
            <p class="lh11 fs10 mt-1">
                Date and sender`s signature<br>
                Дата и подпись отправителя (8)
                <span class="float-right fs10">{{$order->id}}</span>
            </p>
        </div>
    </div>

@endsection
