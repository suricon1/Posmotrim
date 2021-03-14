<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Jobs\ContentProcessing;
use App\Jobs\SitemapVinograd;
use App\Models\Vinograd\Category;
use App\Models\Vinograd\Country;
use App\Models\Vinograd\Product;
use App\Models\Vinograd\Selection;
use App\Repositories\ProductRepository;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use View;

class CategorysController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('category_active', ' active');
    }

    public function index()
    {
        return view('admin.vinograd.category.index', [
            'categorys' => Category::all(),
            'selections' => Selection::all(),
            'countrys' => Country::all()
        ]);
    }

    public function create($model)
    {
        $modelName = $this->getModelName($model);
        $modelClass = new $modelName;

        return view('admin.vinograd.category.create', [
            'model' => $model,
            'title' => $modelClass::TITLE
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>  'required|max:100',
            'title' =>  'required|max:255',
            'model' => [
                'required',
                Rule::in(['Category', 'Selection', 'Country']),
            ]
        ]);

        $category = $this->getModelName($request->model)::add($request->all());
        dispatch(new ContentProcessing($category));

        return redirect()->route('categorys.index');
    }


    public function edit($id, $model)
    {
        return view('admin.vinograd.category.edit', [
            'category' => $this->getModelName($model)::find($id),
            'model' => $model
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' =>  'required|max:100',
            'title' =>  'required|max:255',
            'slug' =>  [
                'required',
                Rule::unique('vinograd_' . strtolower($request->model) . 's')->ignore($id),
            ],
            'model' => [
                'required',
                Rule::in(['Category', 'Selection', 'Country']),
            ]
        ]);
        $category = $this->getModelName($request->model)::find($id);
        $category->edit($request->all());

        dispatch(new ContentProcessing($category));

        return redirect()->route('categorys.index');
    }

    public function destroy(ProductRepository $rep, Request $request, $id)
    {
        $this->validate($request, [
            'model' => [
                'required',
                Rule::in(['Category', 'Selection', 'Country'])
            ]
        ]);

        try {
            $rep->categoryExist($request->model, $id);
            $this->getModelName($request->model)::destroy($id);
        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('categorys.index');
    }

    private function getModelName($model)
    {
        return 'App\Models\Vinograd\\'.$model;
    }

}
