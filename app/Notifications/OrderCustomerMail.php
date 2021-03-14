<?php

namespace App\Notifications;

use App\Models\Vinograd\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderCustomerMail extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($order)
    {
        return (new MailMessage)
            ->subject('Ваш заказ на сайте '.config('app.name'))
            ->markdown('vendor.notifications.order_customer', [
                'order' => $order,
                'currency' => Currency::where('code', $order->currency)->first()
            ]);
    }
}
