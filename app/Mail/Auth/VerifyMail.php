<?php

namespace App\Mail\Auth;

use App\Models\Vinograd\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Подтверждение регистрации на сайте - '. config('app.url'),
        );
    }

    public function content(): Content
    {
//        return new Content(
//            view: 'emails.auth.register.verify',
//        );
        return new Content(
            markdown: 'emails.auth.register.verify',
            with: [
                'url' => route('vinograd.register.verify', ['token' => $this->user->verify_token])
            ],
        );
    }

//    public function build()
//    {
//        return $this
//            ->subject('Подтверждение регистрации на сайте - '. config('app.url'))
//            ->markdown('emails.auth.register.verify');
//    }
}
