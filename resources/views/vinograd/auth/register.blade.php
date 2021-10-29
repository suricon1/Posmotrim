@extends('layouts.vinograd-left')

@section('title', 'Регистрация на сайте '.config('app.name'))
@section('key', 'Регистрация на сайте '.config('app.name'))
@section('desc', 'Регистрация на сайте '.config('app.name'))

@section('breadcrumb-content')
    <li class="active">Регистрация}}</li>
@endsection

@section('head')
    {{Html::meta('robots', 'noindex, nofollow')}}
@endsection

@section('left-content')
    <div class="form-group errors"></div>
    @if(session('status'))
        <div class="alert alert-danger">
            {{session('status')}}
        </div>
    @endif

    <div class="customer-login-register register-pt-0">
        <div class="form-register-title">
            <h2>Register</h2>
        </div>
        <div class="register-form">
            {!! Form::open(['route' => 'vinograd.register']) !!}
                <div class="form-fild">
                    <p><label>Имя <span class="required">*</span></label></p>
                    <input name="name" value="{{old('name')}}" type="text">
                </div><div class="form-fild">
                    <p><label>Email <span class="required">*</span></label></p>
                    <input name="email" value="{{old('email')}}" type="email">
                </div>
                <div class="form-fild">
                    <p><label>Пароль <span class="required">*</span></label></p>
                    <input name="password" type="password">
                </div><div class="form-fild">
                    <p><label>Повторить пароль <span class="required">*</span></label></p>
                    <input name="password_confirmation" type="password">
                </div>
                <div class="register-submit">
                    <button type="submit" class="form-button">Зарегистрироваться</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
