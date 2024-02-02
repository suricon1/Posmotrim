<x-mail::message>

<x-mail::panel>
# Поступил новый заказ
</x-mail::panel>

<x-mail::panel>
<strong>Доставка:</strong><br>
<small>{{$order->delivery['method_name']}}</small>
</x-mail::panel>

<x-mail::table>
| Название                                                                             | Кол-во                  | Цена за шт           |  Стоимость                      |
| :----------------------------------------------------------------------------------- |------------------------:| --------------------:| -------------------------------:|
@foreach($order->items as $item)
| {{$item->product->name}}<br><small>{{$item->modification->property->name}} </small>  | {{$item->quantity}} шт. | {{$item->price}} руб | {{$item->getCost()}} руб        |
@endforeach
| <hr>                                                                                 |<hr>                     |<hr>                  |<hr>                             |
| <strong>Стоимость доставки:</strong>                                                 |                         |                      |{{$order->delivery['cost']}} руб |
| <strong>Сумма к оплате:</strong>                                                     |                         |                      |{{$order->getTotalCost()}} руб   |
</x-mail::table>

<x-mail::button :url="$url">
Смотреть в админке
</x-mail::button>

</x-mail::message>
