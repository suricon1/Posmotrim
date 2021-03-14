<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentPostUserMail extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($comment)
    {
        return (new MailMessage)
            ->subject('Получен новый ответ на Ваш комментарий на сайте: '. config('app.name'))
            ->markdown('vendor.notifications.comment_post_user', ['comment' => $comment]);
    }
}
