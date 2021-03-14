<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Requests\Admin\Blog\PostRequest;
use App\Jobs\ContentProcessing;
use App\Jobs\ImageProcessing;
use App\Jobs\SitemapVinograd;
use App\Models\Blog\Post;
use App\Models\Blog\Category;
use App\UseCases\PostContentService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;
use View;

class PostsController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('post_active', ' active');
    }

//=========== Index =============================
    public function index()
    {
        return view('admin.blog.index', [
            'posts' => Post::orderByDesc('status')->orderByDesc('date_add')->paginate(30)
        ]);
    }

//=========== Create =============================
    public function create()
    {
        return view('admin.blog.create', [
            'tags' => [],
            'categorys' => Category::orderBy('name')->pluck('name', 'id')->all()
        ]);
    }

//=========== Store =============================
    public function store(PostRequest $request)
    {
        $post = Post::add($request);
        $post->toggleStatus($request->get('status'));
        $post->toggleFeatured($request->get('featured'));
//
//        $this->addTagsDesc($request->get('tags'), $post);
//
        $this->imageServis($request, $post);

        dispatch(new SitemapVinograd());
        cache()->delete('siteMapHTML');

        return redirect()->route('posts.index');
    }

//=========== Edit =============================
    public function edit(Post $post)
    {
        //$post = Post::find($id);
        return view('admin.blog.edit', [
            'post' => $post,
            'categorys' => Category::orderBy('name')->pluck('name', 'id')->all(),
            'tags' => [],
            'selectedTags' => []
        ]);
    }

//=========== Update =============================
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);

        $post->edit($request);
//        $post->setTags($request->get('tags'));
        $post->toggleStatus($request->get('status'));
        $post->toggleFeatured($request->get('featured'));

        //$this->addTagsDesc($request->get('tags'), $post);

        $this->imageServis($request, $post);

        dispatch(new SitemapVinograd());
        cache()->delete('siteMapHTML');

        return redirect()->route('posts.index');
    }

    public function contentEditable(Request $request)
    {
        $v = Validator::make($request->all(), [
            'post_id' => 'required|integer|exists:vinograd_posts,id',
            'content' => 'required|string'
        ]);
        if ($v->fails()){
            return ['errors' => $v->errors()];
        }

        $post = Post::find($request->post_id);
        $post->edit($request);

        dispatch(new ContentProcessing($post));

        return ['succes' => 'ok'];
    }

    //=========== Destroy =============================
    public function destroy($id)
    {
        Post::find($id)->remove();
        return redirect()->route('posts.index');
    }

    //=========== Toggle =============================
    public function toggle($id)
    {
        $post = Post::find($id);
        $post->toggledsStatus();

        return redirect()->back();
    }

    //=========== ImageServis =============================
    public function imageServis(Request $request, Model $post)
    {
        try {
            $post->uploadImage($request->file('image'));
            if($request->file('image') != null) {
                dispatch(new ImageProcessing($post));
                //$post->fitImage();
            }
            dispatch(new ContentProcessing($post));
            //new PostContentService($post);
        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }
}
