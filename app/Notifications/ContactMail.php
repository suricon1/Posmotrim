<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactMail extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Сообщение из формы обратной связи')
            ->greeting('Сообщение из формы обратной связи!')
            ->line('<strong>От:</strong> ' . $notifiable->name.'<br>')
            ->line('<strong>Его сообщение:</strong> ' . nl2br($notifiable->message))
            ->action('Посмотреть в админке', url(route('mails.index')))
            ->success();
            //->replyTo($notifiable->email);
    }
}
