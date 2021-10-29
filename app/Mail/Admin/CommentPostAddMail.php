<?php

namespace App\Mail\Admin;

use App\Models\Vinograd\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPostAddMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $post;
    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function build()
    {
        return $this
            ->subject('Поступил новый комментарий к статье!')
            ->markdown('admin.emails.comment_post_add');
    }
}
