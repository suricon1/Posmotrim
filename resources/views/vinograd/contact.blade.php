@extends('layouts.vinograd-left')

@section('title', 'Форма обратной связи')
@section('key', 'Форма обратной связи')
@section('desc', 'Форма обратной связи')

@section('breadcrumb-content')
    <li class="active">Форма обратной связи</li>
@endsection

@section('left-content')

    @include('components.reklama.yandex_blog_post_text_15')

    <div class="contact-address-area mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title2 bl-color">
                        <h3>Контакты</h3>
                        <p>Мы всегда рады услышать Ваши предложения!</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="single-contact-address text-center mb-35">
                        <div class="contact-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="contact-info">
                            <h2>Телефон</h2>
                            <p><img src="{{Storage::url('pics/img/velcom.png')}}"> {{config('main.phone 1')}} <br></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single-contact-address text-center mb-35">
                        <div class="contact-icon">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                        <div class="contact-info">
                            <h2>Электронный адрес</h2>
                            <p>{{config('main.admin_email')}} <br></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-form-area">
                        <div class="contact-form-title">
                            <h2>Форма обратной связи</h2>
                        </div>
                            {!! Form::open(['route'	=> 'vinograd.contactStore', 'id' => 'contact-forms']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="contact-form-style mb-20">
                                        <input name="name" placeholder="Представьтесь *" type="text"  class="form-control{{ $errors->first('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" id="name">
                                        <div class="invalid-feedback" id="invalid-name">
                                            {!! $errors->first('name') ? $errors->first('name') : '' !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-form-style mb-20">
                                        <input type="email" name="email" class="form-control{{ $errors->first('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" id="email" placeholder="Ваш Email *">
                                        <div class="invalid-feedback" id="invalid-email">
                                            {!! $errors->first('email') ? $errors->first('email') : '' !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="special-field col-md-12">
                                    <label for="subject">Subject</label>
                                    <input type="text" name="subject" id="subject" placeholder="Subject" value="" />
                                </div>
                                <div class="col-md-12">
                                    <div class="contact-form-style form-style-2">
                                        <textarea name="message" placeholder="Ваше сообщение *" class="form-control{{ $errors->first('message') ? ' is-invalid' : '' }}">
                                            {{ old('message') }}
                                        </textarea>
                                        <div class="invalid-feedback" id="invalid-message">
                                            {!! $errors->first('message') ? $errors->first('message') : '' !!}
                                        </div>
                                        <button class="form-button btn-style-2" type="submit"><span>Отправить</span></button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
{{--                        <p class="form-messege"></p>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
