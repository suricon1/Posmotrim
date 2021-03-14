<?php

namespace App\Notifications;

use App\Models\Vinograd\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderReplyCustomerMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $subject;
    public $message;
    public $cart;

    public function __construct($order, $request)
    {
        $this->subject = $request->subject;
        $this->message = $request->message;
        $this->cart = $request->add_cart;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($order)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->markdown('vendor.notifications.order_customer_reply', [
                'order' => $order,
                'message' => $this->message,
                'cart' => $this->cart,
                'currency' => Currency::where('code', $order->currency)->first()
            ]);
    }
}
