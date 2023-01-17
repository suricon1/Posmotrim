@component('mail::message')
# Ваш заказ на сайте {{ config('app.name') }}. № {{$order->id}}

@component('mail::panel')
Вы заказали:
@endcomponent

@component('mail::table')
| Название                                                                 | Кол-во                  | Цена за шт                                                 |  Стоимость                                                                                                 |
| :----------------------------------------------------------------------- |------------------------:| ----------------------------------------------------------:| ----------------------------------------------------------------------------------------------------------:|
@foreach($order->items as $item)
| {{$item->product->name}}<br><small>{{$item->modification->property->name}} </small>  | {{$item->quantity}} шт. | {{mailCurr($currency, $item->price)}} {{$currency->sign}}  | {{mailCurr($currency, $item->getCost())}} {{$currency->sign}}                                  |
@endforeach
| <hr>                                                                     |<hr>                     |<hr>                                                        |<hr>                                                                                                        |
| <strong>Итого:</strong>                                                  |                         |                                                            |{{mailCurr($currency, $order->cost)}} {{$currency->sign}}                                                   |
| <strong>Вес заказа:</strong>                                             |                         |                                                            |{{$order->delivery['weight'] / 1000}} кг.                                                                   |
| <strong>Стоимость доставки:</strong>                                     |                         |                                                            |{{mailCurr($currency, $order->delivery['cost'])}} {{$currency->sign}}                                       |
| <strong>Сумма к оплате:</strong>                                         |                         |                                                            |{{mailCurr($currency, $order->getTotalCost())}} {{$currency->sign}}<br>({{$order->getTotalCost()}} бел.руб) |
@endcomponent

@component('mail::panel')
# Адрес и контакты
<p><strong>ФИО:</strong> {{$order->customer['name']}}</p>
<p><strong>Тел.:</strong> {{formatPhone($order->customer['phone'])}}</p>
<p><strong>Email:</strong> {{$order->customer['email']}}</p>
<p><strong>Индекс:</strong> {{$order->delivery['index']}}</p>
<p><strong>Адрес:</strong> {{$order->delivery['address']}}</p>
<p style="color: red">ВНИМАНИЕ! Во избежание ошибок при отправке посылок и для осуществления обратной связи с нашей стороны, внимательно проверьте указанные Вами адрес и контактные данные. В случае ошибки свяжитесь с нами до отправки посылки.</p>
@endcomponent

@component('mail::panel')
<p>В ближайшее время мы свяжемся с Вами для уточнения деталей.</p>
@endcomponent

@component('mail::panel')
<p style="color: red">В случае отсутствия обратной связи с нашей стороны, проверяйте папку СПАМ, возможно наши письма попадают туда.</p>
@endcomponent


@if($order->user_id)
@component('mail::button', ['url' => route('vinograd.cabinet.home'), 'color' => 'green'])
Посмотреть заказ в личном кабинете
@endcomponent
@endif

Спасибо, что выбрали нас.<br>
С уважением <a href="{{route('vinograd.home')}}">{{ config('app.name') }}</a>
@endcomponent
