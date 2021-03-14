@extends('admin.layouts.layout')

@section('header')
    <link rel="stylesheet" href="/css/jquery.periodpicker.min.css">
@endsection

@section('content')
{{--    <div class="col-12 col-sm-6 col-md-3">--}}
{{--        <div class="info-box">--}}
{{--            <span class="info-box-icon bg-info elevation-1"><i class="fa fa-gear"></i></span>--}}

{{--            <div class="info-box-content">--}}
{{--                <span class="info-box-text">Новые заказы</span>--}}
{{--                <span class="info-box-number">20<small> шт</small></span>--}}
{{--                <span class="info-box-text">На сумму<span class="info-box-number">10 <small>руб</small></span></span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-12 col-sm-6 col-md-3">--}}
{{--        <div class="info-box mb-3">--}}
{{--            <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-google-plus"></i></span>--}}

{{--            <div class="info-box-content">--}}
{{--                <span class="info-box-text">Likes</span>--}}
{{--                <span class="info-box-number">41,410</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="clearfix hidden-md-up"></div>--}}

@endsection

@section('scripts')
    <script src="/js/jquery.periodpicker.full.min.js"></script>

    <script>
        $(function(){
            jQuery('#periodpickerstart').periodpicker({
                end: '#periodpickerend',
                // https://xdsoft.net/jqplugins/periodpicker/
                lang: 'ru',
                cells: [2, 6],
                startYear: {{date("Y")}},
                //startYear: 2020,
                minDate: '1.1.2019',
                maxDate: '{{date("d.m.Y", strtotime("+1 day"))}}',
                formatDate: 'DD-MM-YYYY',
                todayButton: true,
                monthHeightInPixels: 210,
            });
        });
    </script>
@endsection
