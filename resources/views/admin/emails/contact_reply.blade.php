@component('mail::message')

<p>{!! nl2br($reply->message) !!}<p><br>

@component('mail::panel')
    <small>Ваше сообщение:</small><br>
    <strong>{{$contact->name}}</strong> написал:<br>
    <p>{!! nl2br($contact->message) !!}<p>
@endcomponent

@component('mail::button', ['url' => route('vinograd.category')])
    Перейти к каталогу сортов винограда
@endcomponent

@endcomponent
