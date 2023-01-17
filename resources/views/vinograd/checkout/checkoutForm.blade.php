@extends('layouts.vinograd-left')

@section('title', 'Оформление - ' . $delivery->name)
@section('key', 'Оформление - ' . $delivery->name)
@section('desc', 'Оформление - ' . $delivery->name)

@section('head')
    {{Html::meta('robots', 'noindex, nofollow')}}
@endsection

@section('breadcrumb-content')
<li><a href="{{route('vinograd.checkout.delivery')}}">Доставка</a></li>
<li class="active">Оформление - {{$delivery->name}}</li>
@endsection

@section('left-content')
<div class="checkout-area mb-80">
    <div class="container">
        @guest
        <div class="row">
            <div class="col-12">
                <div class="coupon-accordion">
                    <h3>Зарегистрированный пользователь ? <span id="showlogin">Нажмите здесь, чтобы войти</span></h3>
                    <div id="checkout-login" class="coupon-content">
                        <div class="coupon-info">
                            @include('components.login-form')
                            {{--                            <p class="coupon-text">Quisque gravida turpis sit amet nulla posuere lacinia. Cras sed est sit amet ipsum luctus.</p>--}}
                            {{--                            <form action="checkout.html#">--}}
                                {{--                                <p class="form-row-first">--}}
                                    {{--                                    <label>Username or email <span class="required">*</span></label>--}}
                                    {{--                                    <input type="text">--}}
                                    {{--                                </p>--}}
                                {{--                                <p class="form-row-last">--}}
                                    {{--                                    <label>Password  <span class="required">*</span></label>--}}
                                    {{--                                    <input type="text">--}}
                                    {{--                                </p>--}}
                                {{--                                <p class="form-row">--}}
                                    {{--                                    <input value="Login" type="submit">--}}
                                    {{--                                    <label>--}}
                                        {{--                                        <input type="checkbox">--}}
                                        {{--                                        Remember me--}}
                                        {{--                                    </label>--}}
                                    {{--                                </p>--}}
                                {{--                                <p class="lost-password"><a href="checkout.html#">Lost your password?</a></p>--}}
                                {{--                            </form>--}}
                        </div>
                    </div>
                    {{--                    <h3>Have a coupon? <span id="showcoupon">Click here to enter your code</span></h3>--}}
                    {{--                    <div id="checkout_coupon" class="coupon-checkout-content">--}}
                        {{--                        <div class="coupon-info">--}}
                            {{--                            <form action="checkout.html#">--}}
                                {{--                                <p class="checkout-coupon">--}}
                                    {{--                                    <input placeholder="Coupon code" type="text">--}}
                                    {{--                                    <input value="Apply Coupon" type="submit">--}}
                                    {{--                                </p>--}}
                                {{--                            </form>--}}
                            {{--                        </div>--}}
                        {{--                    </div>--}}
                </div>
            </div>
        </div>
        @endguest

        @php
            $user = Auth::user();
        @endphp

        {!! Form::open(['route'	=> 'vinograd.checkout.checkout']) !!}
        {!! Form::hidden('delivery[method]', $delivery->id) !!}
        <div class="row">

            <div class="col-lg-6 col-12">
                <div class="checkbox-form">
                    <h3>Доставка<br><small>{{$delivery->name}}</small></h3>
                    <div class="row">

                        @if($delivery->isMailed())
                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Фамилия Имя Отчество (Необходимо для заполнения почтовой формы) <span class="required">*</span></label>
                                <input placeholder="" type="text" name="customer[name]" class="form-control{{ $errors->first('customer.name') ? ' is-invalid' : '' }}" value="{{ old('customer.name', $user && $user->delivery ? $user->delivery['first_name'] : '') }}" id="customer[name]">
                                <div class="invalid-feedback" id="invalid-customer[name]">
                                    {{ $errors->first('customer.name') ? $errors->first('customer.name') : '' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Индекс Вашей почты <span class="required">*</span></label>
                                <input placeholder="" type="text" name="delivery[index]" class="form-control{{ $errors->first('delivery.index') ? ' is-invalid' : '' }}" value="{{ old('delivery.index', $user && $user->delivery ? $user->delivery['index'] : '') }}" id="delivery[index]">
                                <div class="invalid-feedback" id="invalid-delivery[index]">
                                    {{ $errors->first('delivery.index') ? $errors->first('delivery.index') : '' }}
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Имя <span class="required">*</span></label>
                                <input placeholder="" type="text" name="customer[name]" class="form-control{{ $errors->first('customer.name') ? ' is-invalid' : '' }}" value="{{ old('customer.name', $user && $user->delivery ? $user->delivery['first_name'] : '') }}" id="customer[name]">
                                <div class="invalid-feedback" id="invalid-customer[name]">
                                    {{ $errors->first('customer.name') ? $errors->first('customer.name') : '' }}
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(!$delivery->isPickup())
                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Адрес <span class="required">*</span></label>
                                <input placeholder="" type="text" name="delivery[address]" class="form-control{{ $errors->first('delivery.address') ? ' is-invalid' : '' }}" value="{{ old('delivery.address', $user && $user->delivery ? $user->delivery['address'] : '') }}" id="delivery[address]">
                                <div class="invalid-feedback" id="invalid-delivery[address]">
                                    {{ $errors->first('delivery.address') ? $errors->first('delivery.address') : '' }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>Ваш Email - адрес <span class="required">*</span></label>
                                <input name="customer[email]" placeholder="" type="email" class="form-control{{ $errors->first('customer.email') ? ' is-invalid' : '' }}" value="{{ old('customer.email', $user ? $user->email : '') }}" id="customer[email]">
                                <div class="invalid-feedback" id="invalid-customer[email]">
                                    {{ $errors->first('customer.email') ? $errors->first('customer.email') : '' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>Либо Телефон <span class="required">*</span></label>
                                <input type="text" name="customer[phone]" class="form-control{{ $errors->first('customer.phone') ? ' is-invalid' : '' }}" value="{{ old('customer.phone', $user && $user->delivery ? $user->delivery['phone'] : '') }}" id="customer[phone]">
                                <div class="invalid-feedback" id="invalid-customer[phone]">
                                    {{ $errors->first('customer.phone') ? $errors->first('customer.phone') : '' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="order-notes">
                                <div class="checkout-form-list">
                                    <label>Примечение к заказу</label>
                                    <textarea name="note" id="checkout-mess" cols="30" rows="10" placeholder="Примечания о Вашем заказе."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="your-order">
                    <h3>Вы заказали</h3>
                    <div class="your-order-table table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="cart-product-name">Наименование</th>
                                <th class="cart-product-total">Стоимость</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($cart->getItems() as $item)
                            @php
                            $product = $item->getProduct();
                            $modification = $item->getModification();
                            @endphp

                            <tr class="cart_item">
                                <td class="cart-product-name"><a href="{{route('vinograd.product', ['slug' => $product->slug])}}"><strong>{{$product->name}}</strong></a><br> {{$modification->property->name}}<br><strong class="product-quantity">{{$item->getQuantity()}} шт × {{currency($item->getPrice())}} {{signature()}}</strong></td>
                                <td class="cart-product-total"><span class="amount">{{currency($item->getCost())}} {{signature()}}</span></td>
                            </tr>

                            @endforeach
                            @if($delivery->cost)
                            <tr class="cart-subtotal">
                                <th>Вес заказа (прим.)</th>
                                <td><span class="amount">{{$cart->getWeight() / 1000}} кг.</span></td>
                            </tr>
                            <tr class="cart-subtotal">
                                <th>Стоимость доставки</th>
                                <td>
                                    <span class="amount">{{currency($delivery->getDeliveryCost($cart->getWeight()))}} {{signature()}}</span>
                                </td>
                            </tr>
                            @endif

                            </tbody>
                            <tfoot>
                            <tr class="order-total">
                                <th>Полная стоимость</th>
                                <td>
                                    <strong><span class="amount">{{currency($cart->getCost()->getTotal() + $delivery->getDeliveryCost($cart->getWeight()))}} {{signature()}}</span></strong><br>
                                    ({{$cart->getCost()->getTotal() + $delivery->getDeliveryCost($cart->getWeight())}} бел. руб)
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="order-button-payment">
                        <input value="Заказать" type="submit">
                    </div>
                </div>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection
