@component('mail::message')
# Ваш заказ на сайте {{ config('app.name') }}. № {{$order->id}}

@component('mail::panel')
Вы заказали:
@endcomponent

@component('mail::table')
    | Название                                                                 | Кол-во                  | Цена за шт                                                 |  Стоимость                                                                                                 |
    | :----------------------------------------------------------------------- |------------------------:| ----------------------------------------------------------:| ----------------------------------------------------------------------------------------------------------:|
    @foreach($order->items as $item)
    | {{$item->product->name}}<br><small>{{$item->modification->property->name}} </small>  | {{$item->quantity}} шт. | {{mailCurr($currency, $item->price)}} {{$currency->sign}}  | {{mailCurr($currency, $item->getCost())}} {{$currency->sign}}                                              |
    @endforeach
    | <hr>                                                                     |<hr>                     |<hr>                                                        |<hr>                                                                                                        |
    | <strong>Итого:</strong>                                                  |                         |                                                            |{{mailCurr($currency, $order->cost)}} {{$currency->sign}}                                                   |
    | <strong>Стоимость доставки:</strong>                                     |                         |                                                            |{{mailCurr($currency, $order->delivery['cost'])}} {{$currency->sign}}                                       |
    | <strong>Сумма к оплате:</strong>                                         |                         |                                                            |{{mailCurr($currency, $order->getTotalCost())}} {{$currency->sign}}<br>({{$order->getTotalCost()}} бел.руб) |
@endcomponent

@component('mail::panel')
    В ближайшее время мы свяжемся с Вами для уточнения деталей.
@endcomponent


@if($order->user_id)
@component('mail::button', ['url' => route('vinograd.cabinet.home'), 'color' => 'green'])
Посмотреть заказ в личном кабинете
@endcomponent
@endif

Спасибо, что выбрали нас.<br>
С уважением <a href="{{route('vinograd.home')}}">{{ config('app.name') }}</a>
@endcomponent
