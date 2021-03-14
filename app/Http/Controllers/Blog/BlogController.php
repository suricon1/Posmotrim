<?php

namespace App\Http\Controllers\Blog;

use App\Http\Requests\Blog\IndexSortRequest;
use App\Models\Blog\Category;
use App\Models\Blog\Post;
use App\Models\Vinograd\Comment;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class BlogController extends Controller
{

    public function index(IndexSortRequest $request, PostRepository $postRep, $page = '')
    {
        return view('blog.index', [
            'posts' => $postRep->getPosts($request, $page),
            'param' => $postRep->getParams($request),
            'page' => $page
        ]);
    }

    public function post($slug)
    {
        $post = Post::where('slug', $slug)->active()->firstOrFail();
        //dd($post->id, Comment::getAllProductComments($post->id, 'post_id'));
        return view('blog.post', [
            'post' => $post,
            'relatedPosts' => Post::orderByDesc('view')->where('slug', '<>', $slug)->active()->take(4)->get(),
            'comments' => Comment::getAllProductComments($post->id, 'post_id'),
            'contents' => cache()->get($post->classNameByIDForCache())
        ]);
    }

    public function category(IndexSortRequest $request, PostRepository $postRep, $slug, $page = null)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('blog.index', [
            'category' => $category,
            'posts' => $postRep->getPostsByCategory($category, $request, $page),
            'param' => $postRep->getParams($request),
            'page' => $page
        ]);
    }
}
