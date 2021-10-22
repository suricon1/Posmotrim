@extends('admin.layouts.layout')

@section('title', 'Admin | Заказ № ' . $order->id)
@section('key', 'Admin | Заказ № ' . $order->id)
@section('desc', 'Admin | Заказ № ' . $order->id)

@section('header-title', 'Заказ № ' . $order->id)

@section('body-print', ' onload=window.print();')

@section('header')


    <style type="text/css">
        table td, table th {
            padding: 0
        }

        .c26 {
            padding: 0pt 5.8pt 0pt 5.8pt;
            border-left-color: #000000;
            vertical-align: top;
            border-left-width: 1pt;
            background-color: #ffffff;
            border-left-style: solid;
            width: 145pt;
            border-top-color: #000000;
        }

        .c13 {
            padding: 0pt 5.8pt 0pt 5.8pt;
            background-color: #ffffff;
            width: 373.9pt;
        }

        .c9 {
            color: #969394;
            font-weight: 400;
            text-decoration: none;
            vertical-align: baseline;
            font-size: 8pt;
            font-family: "Times New Roman";
            font-style: normal;
            font-size: 8pt;
            display: block;
            margin-top: -1px
        }

        .c5 {
            color: #000000;
            font-weight: 400;
            text-decoration: none;
            vertical-align: baseline;
            font-size: 7.5pt;
            font-family: "Times New Roman";
            font-style: normal
        }

        .c17 {
            color: #000000;
            font-weight: 700;
            text-decoration: none;
            vertical-align: baseline;
            /*font-size: 10pt;*/
            font-family: "Times New Roman";
            font-style: normal
        }

        .c12 {
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: center
        }

        .c0 {
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: left
        }

        .c4 {
            padding-top: 6pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: justify
        }

        .c7 {
            padding-top: 7pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: right
        }

        .c11 {
            display: block;
            border-bottom: 1px solid
        }

        .c22 {
            width: 100%;
            margin: 10px
        }

        .c1 {
            display: inline-block;
            text-align: center;
            border: 1px solid #000000;
            width: 16px;
            height: 16px;
        }

        .c2 {
            display: inline-block;
            border: 1px solid #000000;
            width: 100%;
            height: 25px
        }

        .c3 {
            display: inline-block;
            width: 100%;
            border-top: 1px solid #0c1923;
        }

        p {
            margin: 0 !important;
            font-size: 12pt;
            font-family: "Times New Roman"
        }
    </style>
@endsection

@section('content')

<table class="c22">
    <tbody>
    <tr>
        <td class="c13" colspan="1" rowspan="1">
            <p class="c0">
                <img alt="" src="{{Storage::url('pics/img/admin/print/nalozhka/image4.png')}}" style="width: 68.00px; height: 24.00px; margin-left: 0.00px; margin-top: 0.00px; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px);" title="">
                <span class="c17" style="margin-left: 60px;">ПОЧТОВЫЙ ДЕНЕЖНЫЙ ПЕРЕВОД</span>
            </p>
            <p class="c0 mb-2">
                НАЛОЖЕННЫЙ ПЛАТЕЖ<span class="c1 ml-3">V</span>
            </p>
            <div class="row text-center">
                <div class="col-3">
                    <span class="c2">{{$costFormat}}</span>
                    <span class="c9">(сумма цифрами)</span>
                </div>
                <div class="col-9">
                    <span class="c2">{{$costToString}}</span>
                    <span class="c9">(сумма: руб.- прописью, коп. - цифрами)</span>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-2">ПОЛУЧАТЕЛЬ</div>
                <div class="col-10">
                    <span class="c11">{{$order->customer['name']}}</span>
                    <span class="c9">(ФИО полностью или наименование юридического лица/ИП, телефон)</span>
                </div>
            </div>

            <div class="row">
                <div class="col-1">АДРЕС</div>
                <div class="col-11">
                    <span class="c11">{{$order->delivery['index']}} {{$order->delivery['address']}}</span>
                    <span class="c9">(почтовый код, адрес получателя (для юр. лица/ИП - банковские реквизиты: УНП, BIC, наименование банка, IBAN))</span>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-2">ОТПРАВИТЕЛЬ</div>
                <div class="col-10">
                    <span class="c11">{{$order->customer['name']}}</span>
                    <span class="c9">(ФИО полностью или наименование юридического лица/ИП, телефон)</span>
                </div>
            </div>

            <div class="row">
                <div class="col-1">АДРЕС</div>
                <div class="col-11">
                    <span class="c11">{{$order->delivery['index']}} {{$order->delivery['address']}}</span>
                    <span class="c9">(почтовый код, адрес получателя (для юр. лица/ИП - банковские реквизиты: УНП, BIC, наименование банка, IBAN))</span>
                </div>
            </div>
            <p class="c4 c5">
                Являетесь ли Вы иностранным публичным должностным лицом, должностным лицом публичных
                международных организаций, лицом, занимающим должность, включенную в определяемый
                Президентом Республики Беларусь перечень государственных должностей Республики Беларусь
            </p>
            <p class="c4">
                <span class="c1 ml-3"></span> Да
                <span class="c1 ml-3"></span> Нет
                <span style="display: inline-block; width: 150px; border-bottom: 1px solid; margin-left: 10px;"></span>
                <span class="c9" style="margin-left: 185px">(подпись)</span>
            </p>

            <div class="row">
                <div class="col-3 align-self-center">
                    Доставка на дом <span class="c1 ml-1"></span>
                </div>
                <div class="col-3 align-self-center">
                    Уведомление о получении
                </div>
                <div class="col-3 align-self-center">
                    <span class="c1"></span> простое<br>
                    <span class="c1"></span> заказное<br>
                    <span class="c1"></span> электронное
                </div>
                <div class="col-3 align-self-end" style="border-bottom: 1px solid;">
                    suricon@fex.net
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-8 text-center">
                    <span class="c9">(e-Mail)</span>
                </div>
            </div>
            <p class="c12 mt-2">
                <span class="c9 c3">(письменное сообщение)</span>
            </p>
            <p class="c12 mt-2">
                <span class="c9 c3">(назначение платежа (заполняется при отправке юр.лицом/ИП))</span>
            </p>
        </td>
        <td class="c26" colspan="1" rowspan="1">
            <p class="c7">
                <span class="c9">ф.ПС112</span>
            </p>
            <p class="c0" style="padding-top: 300px;">
                <span class="c9">Отметки отделения почтовой связи места приема</span>
            </p>
        </td>
    </tr>
    </tbody>
</table>
@endsection
