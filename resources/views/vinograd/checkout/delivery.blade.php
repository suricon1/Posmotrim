@extends('layouts.vinograd-left')

@section('title', 'Метод доставки')
@section('key', 'Метод доставки')
@section('desc', 'Метод доставки')

@section('head')
    {{Html::meta('robots', 'noindex, nofollow')}}
@endsection

@section('breadcrumb-content')
    <li class="active">Метод доставки</li>
@endsection

@section('left-content')
    <h2 class="text-center mt2 mb-5">Выберите метод доставки</h2>

    <div class="card-deck mb-3">
    @foreach($deliverys as $delivery)
        @continue($delivery->slug == 'courier-free' && $cart->getCost()->getTotal() < 100)

        <div class="card">
            <a href="{{route('vinograd.checkout.deliveryForm', ['delivery_slug' => $delivery->slug])}}">
                <img src="{{Storage::url('pics/img/'.$delivery->slug.'.jpg')}}" alt="{{$delivery->name}} черенков и саженцев винограда.">
                <div class="card-body">
                    <h4 class="card-title">{{$delivery->name}}</h4>
                    {!! $delivery->content !!}
                </div>
            </a>
        </div>

    @if($loop->iteration % 2 == 0 && !$loop->last)
    </div>
    <div class="card-deck">
    @endif

    @endforeach

    </div>

@endsection
