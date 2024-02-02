@component('mail::message')

@component('mail::panel')
    # Поступил новый комментарий к посту
@endcomponent

<p><strong>Статья:</strong> - <small>{{Html::link(route('blog.post', ['slug' => $comment->post->slug]), $comment->post->name)}}</small></p>
<p><strong>Комментарий:</strong> - <small>{{$comment->text}}</small></p>

@component('mail::button', ['url' => route('blog.comments.index')])
    Смотреть в админке
@endcomponent

@endcomponent
