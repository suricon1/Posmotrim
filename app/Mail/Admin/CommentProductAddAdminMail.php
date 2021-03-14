<?php

namespace App\Mail\Admin;

use App\Models\Vinograd\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentProductAddAdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function build()
    {
        return $this
            ->subject('Поступил новый комментарий к продукту!')
            ->markdown('admin.emails.comment_product_add_admin');
    }
}
