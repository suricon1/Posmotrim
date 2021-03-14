@extends('layouts.vinograd-left')

@section('title', 'Сравнение товаров')
@section('key', 'Сравнение товаров')
@section('desc', 'Сравнение товаров')

@section('breadcrumb-content')
    <li class="active">Сравнение</li>
@endsection

@section('left-content')

    <div class="compare-table table-responsive">
        @include('vinograd.components._compare-table', ['compares' => $compares])
    </div>

@endsection
