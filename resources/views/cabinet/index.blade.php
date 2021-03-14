@extends('layouts.vinograd-left')

@section('title', 'Кабинет - главная')
@section('key', 'Кабинет - главная')
@section('desc', 'Кабинет - главная')

@section('head')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('breadcrumb-content')
    <li class="active">Кабинет - главная</li>
@endsection

@section('content')
    <div class="my-account mb-5">
        <div class="container">
            <div class="account-dashboard">
                <div class="dashboard-upper-info">
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-3 col-md-12">
                            <div class="d-single-info">
                                <p class="user-name">Здравствуйте, <span>{{$user->name}}</span></p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <div class="d-single-info">
                                <p>Ваш Email адресс:</p>
                                <p><strong>{{$user->email}}</strong></p>
                                <p>телефон:</p>
                                @if($user->delivery)
                                <p><strong>{{$user->delivery['phone']}}</strong></p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <div class="d-single-info">
                                <p>Ваша Имя и Фамилия:</p>
                                @if($user->delivery)
                                    <p><strong>{{$user->delivery['first_name']}}</strong></p>
                                @else
                                    <a class="nav-link" data-toggle="tab" href="#account-details">Заполните имя и фамилию!</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <div class="d-single-info" style="padding: 30px 20px;">
                                <p>Ваш адрес доставки:</p>
                                @if($user->delivery)
                                <p><strong>{{$user->delivery['index']}}</strong></p>
                                <p><strong>{{$user->delivery['address']}}</strong></p>
                                @else
                                <a class="nav-link" data-toggle="tab" href="#account-details">Заполните адресс доставки!</a>                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-2">
                        <ul class="nav flex-column dashboard-list" role="tablist">
                            <li><a class="nav-link" data-toggle="tab" href="#dashboard">Dashboard</a></li>
                            <li> <a class="nav-link active" data-toggle="tab" href="#orders">Заказы</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#account-details">Контактные данные</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 col-lg-10">
                        <div class="tab-content dashboard-content">
                            <div id="dashboard" class="tab-pane fade">
                                <h3>Dashboard </h3>
                                <p>Это информационная панель вашего аккаунта. Здесь Вы можете просматривать свои заказы и управлять адресами доставки заказов.</p>
                            </div>
                            <div id="orders" class="tab-pane fade show active">
                                <h3>Мои заказы</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>№ Заказа</th>
                                            <th>Дата</th>
                                            <th>Статус</th>
                                            <th>Стоимость</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{$order->id}}</td>
                                                <td>{{getRusDate($order->created_at)}}</td>
                                                <td style="color: snow">{!! $order->statusName($order->current_status) !!}</td>
                                                <td>{{currency($order->getTotalCost())}} {{signature()}}</td>
                                                <td>
                                                    <div class="btn-group" id="nav">
                                                        <a class="view" href="{{route('vinograd.cabinet.order.view', ['order_id' => $order->id])}}">Посмотреть</a>
                                                        @if($order->isNew())
                                                        {{Form::open(['route'=>['vinograd.cabinet.order.destroy', $order->id]])}}
                                                        <button onclick="return confirm('Подтвердите отмену заказа!')" type="submit" class="btn btn-danger">Отменить</button>
                                                        {{Form::close()}}
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td><p>Вы еще ничего не заказывали!</p></td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="account-details" class="tab-pane fade">
                                <h3>Контактные данные</h3>
                                <div class="login">
                                    <div class="login-form-container">
                                        <div class="alert alert-info" role="alert">
                                            <h4>Уважаемые пользователи.</h4>
                                            <p>Для удобства при работе с сайтом Вы можете сохранить свои контакты для автоматического заполнения формы заказа.</p>
                                            <p>При оформлении заказа эти данные можно будет изменить на любые другие.</p>
                                        </div>
                                        <div class="account-login-form">
                                            {!! Form::open(['route'	=> ['vinograd.cabinet.delivery.update', $user->id]]) !!}
                                                <label><i class="fa fa-asterisk text-danger"></i> Фамилия Имя Отчество</label>
                                                <input name="delivery[first_name]" type="text" value="{{old('delivery[first_name]', $user->delivery['first_name'])}}">
                                                <label><i class="fa fa-asterisk text-danger"></i> Индекс</label>
                                                <input name="delivery[index]" type="text" value="{{old('delivery[index]', $user->delivery['index'])}}">
                                                <label><i class="fa fa-asterisk text-danger"></i> Адрес</label>
                                                <input name="delivery[address]" type="text" value="{{old('delivery[address]', $user->delivery['address'])}}">
                                                <label>Контактный телефон</label>
                                                <input name="delivery[phone]" type="text" value="{{old('delivery[phone]', $user->delivery['phone'])}}">
                                                <div class="button-box">
                                                    <button type="submit" class="default-btn">Сохранить</button>
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
