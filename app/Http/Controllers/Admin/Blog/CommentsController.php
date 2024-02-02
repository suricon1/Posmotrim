<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Models\Vinograd\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CommentsController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('blog_comment_active', ' active');
    }

    public function index()
    {
        return view('admin.blog.comments.index', [
            'comments'	=>	Comment::with('post')->where('post_id', '<>', null)->orderBy('status', 'desc')->paginate(20)
        ]);
    }

    public function edit($id)
    {
        return view('admin.blog.comments.edit', [
            'comment' => Comment::find($id)
        ]);
    }

    public function update(Request $request)
    {
        return 'OK';
    }

    public function toggle($id)
    {
        $comment = Comment::find($id);
        $comment->toggleStatus();

        return redirect()->back();
    }

    public function destroy($id)
    {
        Comment::find($id)->remove();
        return redirect()->back();
    }
}
