<?php

return [
    'phone 1' => env('PHONE_1', false),
    'admin_email' => env('MAIL_FROM_ADDRESS', false),
    'admin_name' => env('ADMIN_NAME', false),
    'admin_index' => env('ADMIN_INDEX', false),
    'admin_address' => env('ADMIN_ADDRESS', false),

    'tracking_post' => env('TRACKING_POST', false),

    'success_comment' => 'Ваш комментарий добавлен!',
    'success_comment_verify' => 'Ваш комментарий будет добавлен после проверки!',

    'empty_text' => '<span class="text-danger">Нет в наличии</span>',
    //'empty_text' => '<span class="text-danger">Нет в наличии</span><br>Саженцы будут к началу мая<br>Черенки к ноябрю',
    'empty_text_info' => '<span class="text-danger">Нет в наличии</span>',
    //'empty_text_info' => '<span class="text-danger">Нет в наличии</span><br><div class="alert alert-info" role="alert">Саженцы будут к началу мая<br>Черенки к ноябрю</div>', data-target=".bd-example-modal-lg"
];
