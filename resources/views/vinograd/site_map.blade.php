@extends('layouts.vinograd-left')

@section('title', 'Виноград в Минске. Карта сайта')
@section('key', 'Виноград в Минске. Карта сайта')
@section('desc', 'Виноград в Минске. Карта сайта')

@section('breadcrumb-content')
    <li class="active">Карта сайта</li>
@endsection

@section('left-content')

{!! $view !!}

@endsection
