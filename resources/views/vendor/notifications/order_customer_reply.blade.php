@component('mail::message')
# Уточнение Вашего заказа на сайте {{ config('app.name') }}.

@component('mail::panel')
<h3>
    Заказ №<strong>{{$order->id}}</strong>
</h3>
<p>
    {!! nl2br($message) !!}
</p>
@endcomponent

@if($cart)
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
@endif

@component('mail::button', ['url' => route('vinograd.category'), 'color' => 'green'])
    Сорта винограда на нашем участке
@endcomponent

Спасибо, что выбрали нас.<br>
С уважением <a href="{{route('vinograd.home')}}">{{ config('app.name') }}</a>
@endcomponent
