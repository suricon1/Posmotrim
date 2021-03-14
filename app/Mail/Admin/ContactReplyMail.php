<?php

namespace App\Mail\Admin;

use App\Models\Vinograd\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $contact;
    public $reply;

    public function __construct(Contact $contact, Contact $reply)
    {
        $this->contact = $contact;
        $this->reply = $reply;
    }

    public function build()
    {
        return $this
            ->subject('Re: '.config('app.name').'. Ответ на Ваше сообщение')
            ->markdown('admin.emails.contact_reply');
    }
}
