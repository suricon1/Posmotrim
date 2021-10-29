@component('mail::message')

@component('mail::panel')
    # Поступил новый заказ
@endcomponent

@component('mail::panel')
    <strong>Доставка:</strong><br>
    <small>{{$order->delivery['method_name']}}</small>
@endcomponent

@component('mail::table')
    | Название                                                                 | Кол-во                  | Цена за шт           |  Стоимость                      |
    | :----------------------------------------------------------------------- |------------------------:| --------------------:| -------------------------------:|
    @foreach($order->items as $item)
        | {{$item->product->name}}<br><small>{{$item->modification->property->name}} </small>  | {{$item->quantity}} шт. | {{$item->price}} руб | {{$item->getCost()}} руб        |
    @endforeach
    | <hr>                                                                     |<hr>                     |<hr>                  |<hr>                             |
    | <strong>Стоимость доставки:</strong>                                     |                         |                      |{{$order->delivery['cost']}} руб |
    | <strong>Сумма к оплате:</strong>                                         |                         |                      |{{$order->getTotalCost()}} руб   |
@endcomponent

@component('mail::button', ['url' => route('orders.show', ['id' => $order->id])])
Смотреть в админке
@endcomponent

@endcomponent
