<?php

namespace App\Http\Controllers\Vinograd;

use App\Http\Requests\Vinograd\AddCommentRequest;
use App\Http\Requests\Vinograd\DeleteCommentRequest;
use App\Http\Requests\Vinograd\EditCommentRequest;
use App\Mail\Admin\CommentPostAddMail;
use App\Mail\Admin\CommentProductAddAdminMail;
use App\Models\Vinograd\Comment;
use App\Models\Site\UserComment;
use App\Http\Controllers\Controller;
use App\Notifications\CommentPostUserMail;
use App\Notifications\CommentProductUserMail;
use Auth;
use Mail;

class CommentController extends Controller
{
    /*-------------------
        store action
    -------------------*/
    public function store(AddCommentRequest $request)
    {
        $this->addCommentAndSendEmail($request);
        return redirect()->back()->with('status', is_admin()
            ? config('main.success_comment')
            : config('main.success_comment_verify'));
    }

    /*-------------------
        ajaxStore action
    -------------------*/
    public function ajaxStore (AddCommentRequest $request)
    {
        $comment = $this->addCommentAndSendEmail($request);
        return ['succes' => is_admin()
            ? view('components.ajax-comment-item', ['comment' => $comment])->render()
            : "<div class='alert alert-success coment_blok'>".config('main.success_comment_verify')."</div>"
        ];
    }

    /*-------------------
        ajaxEdit action
    -------------------*/
    public function ajaxEdit(EditCommentRequest $request)
    {
        $comment = Comment::find($request->input('comment_id'));
        $comment->text = $request->input('text');
        $comment->save();
        return ['succes' => $request->input('text')];
    }

    /*-------------------
        ajaxDelete action
    -------------------*/
    public function ajaxDelete(DeleteCommentRequest $request)
    {
        if (Comment::where('parent_id', $request->input('comment_id'))->count()){
            return ['errors' => ['2' => 'Удалить этот комментарий нельзя, на него есть ответы!']];
        }

        //Comment::find($request->input('comment_id'))->delete();
        Comment::destroy($request->input('comment_id'));
        return ['succes' => 'Ok'];
    }

    //--------------------------------------------------------
    private function addCommentAndSendEmail($request)
    {
        if(!Auth::user()){
            $user_comment = UserComment::add($request->get('name'), $request->get('email'));
            $comment = Comment::add($request->all(), $user_comment->id);
        }else{
            $comment = Comment::add($request->all());
        }

        if($comment->product_id){
            Mail::to(config('main.admin_email'))->queue(new CommentProductAddAdminMail($comment));

            if($comment->parent_id){
                //  нотификацию юзеру
                $comment->notify(new CommentProductUserMail($comment));
            }

        }else{
            if($comment->post->user_id != $comment->user_id) {
                Mail::to($comment->post->author->email)->queue(new CommentPostAddMail($comment));
            }
            if($comment->parent_id){
                //  нотификацию юзеру
                if($comment->post->user_id != $comment->parent->user_id) {
                    $comment->notify(new CommentPostUserMail($comment));
                }
            }
        }
        return $comment;
    }
}
