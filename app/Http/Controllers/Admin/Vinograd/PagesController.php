<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Http\Requests\Admin\Vinograd\Page\PageRequest;
use App\Jobs\ContentProcessing;
use App\Jobs\SitemapVinograd;
use App\Models\Vinograd\Page;
use App\UseCases\PostContentService;
use Artisan;
use Illuminate\Http\Request;
use View;

class PagesController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('page_active', ' active');
    }

    public function index()
    {
        return view('admin.vinograd.pages.index', [
            'pages' => Page::orderBy('sort')->get()
        ]);
    }

    public function create()
    {
        return view('admin.vinograd.pages.create');
    }

    public function store(PageRequest $request)
    {
        $page = Page::add($request);
        $page->toggleStatus($request->get('status'));

        try {
//            new PostContentService($page);
            dispatch(new ContentProcessing($page));

            dispatch(new SitemapVinograd());
            cache()->delete('siteMapHTML');

        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }
        return redirect()->route('pages.index');
    }

    public function edit($id)
    {
        return view('admin.vinograd.pages.edit', [
            'page' => Page::find($id)
        ]);
    }

    public function update(PageRequest $request, $id)
    {
        $page = Page::find($id);

        $page->edit($request);
        $page->toggleStatus($request->get('status'));

        try {
            new PostContentService($page);
//            dispatch(new ContentProcessing($page));

            dispatch(new SitemapVinograd());
            cache()->delete('siteMapHTML');

        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }
        return redirect()->route('pages.index');
    }

    public function destroy($id)
    {
        Page::find($id)->remove();

        dispatch(new SitemapVinograd());
        cache()->delete('siteMapHTML');

        return redirect()->route('pages.index');
    }

    public function toggle($id)
    {
        $page = Page::find($id);
        $page->toggledsStatus();

        dispatch(new SitemapVinograd());
        cache()->delete('siteMapHTML');

        return redirect()->back();
    }

    public function moveUp($id)
    {
        Page::moveUp($id);
        return redirect()->route('pages.index');
    }

    public function moveDown($id)
    {
        Page::moveDown($id);
        return redirect()->route('pages.index');
    }
}
