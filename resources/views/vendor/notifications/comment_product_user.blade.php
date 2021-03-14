@component('mail::message')
# Получен новый ответ на Ваш комментарий на сайте: {{config('app.name')}}

@component('mail::panel')
    На Ваш комментарий к продукту <strong>{{$comment->product->name}}</strong><br>
    Получен новый ответ: <strong>{{$comment->text}}</strong>
@endcomponent

@component('mail::button', ['url' => route('vinograd.product', ['slug' => $comment->product->slug]), 'color' => 'green'])
    Посмотреть ответ на сайте
@endcomponent

<a href="{{route('vinograd.home')}}">{{ config('app.name') }}</a>
@endcomponent
