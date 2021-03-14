<?php

namespace App\Notifications;

use App\Models\Vinograd\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCodeMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $code;

    public function __construct($order, $code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($order)
    {
        return (new MailMessage)
            ->subject('Ваш заказ на сайте '.config('app.name').' отправлен. Трек код посылки')
            ->markdown('vendor.notifications.send_code', [
                'order' => $order,
                'code' => $this->code,
                'currency' => Currency::where('code', $order->currency)->first()
            ]);
    }
}
