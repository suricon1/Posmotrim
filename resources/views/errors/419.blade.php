@extends('layouts.vinograd-left')

@section('title', '419 | ОШИБКА! Истекло время ожидания!')
@section('key', '419 | ОШИБКА! Истекло время ожидания!')
@section('desc', '419 | ОШИБКА! Истекло время ожидания!')

@section('header-top-area', '')

@section('content')

    <div class="error-404-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-wrapper text-center">
                        <div class="error-text">
                            <h1>419</h1>
                            <h2>Истекло время ожидания!</h2>
                            <p>Перегрузите, пожалуйста, страницу.</p>
                        </div>

                        <div class="error-button">
                            <a href="{{ route('vinograd.home') }}">Перейти на главную страницу</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
