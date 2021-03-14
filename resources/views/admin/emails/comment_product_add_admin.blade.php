@component('mail::message')

@component('mail::panel')
    # Поступил новый комментарий к продукту
@endcomponent

<p><strong>Продукт:</strong> - <small>{{Html::link(route('vinograd.product', ['slug' => $comment->product->slug]), $comment->product->name)}}</small></p>
<p><strong>Комментарий:</strong> - <small>{{$comment->text}}</small></p>

@component('mail::button', ['url' => route('vinograd.comments.index')])
    Смотреть в админке
@endcomponent

@endcomponent
