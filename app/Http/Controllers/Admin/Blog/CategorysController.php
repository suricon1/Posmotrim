<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Jobs\ContentProcessing;
use App\Jobs\SitemapVinograd;
use App\Models\Blog\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use View;

class CategorysController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('blog_categorys_active', ' active');
    }

    public function index()
    {
        return view('admin.blog.category.index', [
            'categorys' => Category::all()
        ]);
    }

    public function create()
    {
        return view('admin.blog.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>  'required|max:100',
            'title' =>  'required|max:255',
        ]);

        $category = Category::add($request->all());

        try {
            dispatch(new ContentProcessing($category));

            dispatch(new SitemapVinograd());
            cache()->delete('siteMapHTML');

        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('blog.categorys.index');
    }

    public function edit($id)
    {
        return view('admin.blog.category.edit', [
            'category' => Category::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $this->validate($request, [
            'name' =>  'required|max:100',
            'title' =>  'required|max:255',
            'slug' =>  [
                'required',
                Rule::unique('vinograd_blog_category')->ignore($category->id),
            ]
        ]);

        $category->edit($request->all());

        try {
            //new PostContentService($category);
            dispatch(new ContentProcessing($category));

            dispatch(new SitemapVinograd());
            cache()->delete('siteMapHTML');

        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('blog.categorys.index');
    }

    public function destroy($id)
    {
        Category::find($id)->delete();

        dispatch(new SitemapVinograd());
        cache()->delete('siteMapHTML');

        return redirect()->route('blog.categorys.index');
    }
}
