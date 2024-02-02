<?php

namespace App\Mail\Admin;

use App\Models\Vinograd\Order\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderAddMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Поступил новый заказ!',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'admin.emails.orders_add',
            with: [
                'order' => $this->order,
                'url' => route('orders.show', $this->order->id)
            ],
        );
    }
}
