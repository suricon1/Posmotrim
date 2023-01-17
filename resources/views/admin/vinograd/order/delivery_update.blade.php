@extends('admin.layouts.layout')

@section('title', 'Admin | Редактировать метод доставки. Заказ № ' . $order->id)
@section('key', 'Admin | Редактировать метод доставки. Заказ № ' . $order->id)
@section('desc', 'Admin | Редактировать метод доставки. Заказ № ' . $order->id)

@section('header-title', 'Редактировать метод доставки. Заказ № ' . $order->id)

@section('content')
{{--    {{dd($order, $delivery)}}--}}
<div class="col-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{$delivery->name}}</h3>
        </div>
        {{Form::open(['route'=>['orders.delivery.update', $order->id], 'style' => 'margin: 2px;', 'class' => 'form-horizontal'])}}
        {!! Form::hidden('delivery[method]', $delivery->id) !!}
            <div class="card-body">
                @if($delivery->isMailed())
                <div class="form-group">
                    <label for="customer[name]">Фамилия Имя Отчество (Необходимо для заполнения почтовой формы) <span class="text-danger">*</span></label>
                    <input type="text" name="customer[name]" class="form-control{{ $errors->first('customer.name') ? ' is-invalid' : '' }}"  value="{{ old('customer.name', $order->customer['name']) }}" id="customer[name]">
                </div>
                <div class="form-group">
                    <label for="delivery[index]">Индекс Вашей почты <span class="text-danger">*</span></label>
                    <input type="text" name="delivery[index]" class="form-control{{ $errors->first('delivery.index') ? ' is-invalid' : '' }}" value="{{ old('delivery.index', $order->delivery['index']) }}" id="delivery[index]">
                    <div class="invalid-feedback" id="invalid-delivery[index]">
                        {{ $errors->first('delivery.index') ? $errors->first('delivery.index') : '' }}
                    </div>
                </div>
            @else
                <div class="form-group">
                    <label for="customer[name]">Имя <span class="text-danger">*</span></label>
                    <input type="text" name="customer[name]" class="form-control{{ $errors->first('customer.name') ? ' is-invalid' : '' }}" value="{{ old('customer.name', $order->customer['name']) }}" id="customer[name]">
                    <div class="invalid-feedback" id="invalid-customer[name]">
                        {{ $errors->first('customer.name') ? $errors->first('customer.name') : '' }}
                    </div>
                </div>
            @endif
            @if(!$delivery->isPickup())
                <div class="form-group">
                    <label for="delivery[address]">Адрес <span class="text-danger">*</span></label>
                    <input type="text" name="delivery[address]" class="form-control{{ $errors->first('delivery.address') ? ' is-invalid' : '' }}" value="{{ old('delivery.address', $order->delivery['address']) }}" id="delivery[address]">
                    <div class="invalid-feedback" id="invalid-delivery[address]">
                        {{ $errors->first('delivery.address') ? $errors->first('delivery.address') : '' }}
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer[email]">Ваш Email - адрес <span class="text-danger">*</span></label>
                        <input name="customer[email]" placeholder="" type="email" class="form-control{{ $errors->first('customer.email') ? ' is-invalid' : '' }}" value="{{ old('customer.email', $order->customer['email']) }}" id="customer[email]">
                        <div class="invalid-feedback" id="invalid-customer[email]">
                            {{ $errors->first('customer.email') ? $errors->first('customer.email') : '' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer[phone]">Либо Телефон <span class="text-danger">*</span></label>
                        <input type="text" name="customer[phone]" class="form-control{{ $errors->first('customer.phone') ? ' is-invalid' : '' }}" value="{{ old('customer.phone', formatPhone($order->customer['phone'])) }}" id="customer[phone]">
                        <div class="invalid-feedback" id="invalid-customer[phone]">
                            {{ $errors->first('customer.phone') ? $errors->first('customer.phone') : '' }}
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Сохранить</button>
            </div>
        {{Form::close()}}
    </div>
</div>

@endsection
