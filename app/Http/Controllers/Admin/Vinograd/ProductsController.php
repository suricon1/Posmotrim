<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Http\Requests\Admin\Vinograd\Modification\ModificationDeleteRequest;
use App\Http\Requests\Admin\Vinograd\Modification\ModificationEditRequest;
use App\Http\Requests\Admin\Vinograd\Modification\ModificationRequest;
use App\Http\Requests\Admin\Vinograd\Product\ProductRequest;
use App\Jobs\ContentProcessing;
use App\Jobs\GalleryProcessing;
use App\Jobs\ImageProcessing;
use App\Models\Vinograd\Category;
use App\Models\Vinograd\Country;
use App\Models\Vinograd\Modification;
use App\Models\Vinograd\ModificationProps;
use App\Models\Vinograd\Product;
use App\Models\Vinograd\Selection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use View;

class ProductsController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('product_active', ' active');
    }

    public function index()
    {
        return view('admin.vinograd.product.index', [
            'products' => Product::with('category', 'adminModifications.property')->get()
        ]);
    }

    public function create()
    {
        return view('admin.vinograd.product.create', [
            'categorys' => Category::orderBy('name')->pluck('name', 'id')->all(),
            'countrys' => Country::orderBy('name')->pluck('name', 'id')->all(),
            'selections' => Selection::orderBy('name')->pluck('name', 'id')->all()
        ]);
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = Product::add($request);

            $product->toggleStatus($request->get('status'));
            $product->toggleFeatured($request->get('is_featured'));

            $this->imageServis($request, $product);

            return ($request->ajax()) ? ['succes' => 'OK'] : redirect()->route('products.index');
        } catch (\Exception $e) {
            //return back()->withErrors([$e->getMessage()]);
            return ['errors' => $e->getMessage()];
        }
    }

    public function edit($id)
    {
        return view('admin.vinograd.product.edit', [
            'product' => Product::with('adminModifications')->find($id),
            'categorys' => Category::orderBy('name')->pluck('name', 'id')->all(),
            'countrys' => Country::orderBy('name')->pluck('name', 'id')->all(),
            'selections' => Selection::orderBy('name')->pluck('name', 'id')->all(),
            'modifications' => ModificationProps::orderBy('name')->pluck('name', 'id')->all()
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::find($id);

            $product->edit($request);
            $product->toggleStatus($request->get('status'));
            $product->toggleFeatured($request->get('is_featured'));

            $this->imageServis($request, $product);

            return($request->ajax()) ? ['succes' => 'OK'] : redirect()->route('products.index');
        } catch (\Exception $e) {
            //return back()->withErrors([$e->getMessage()]);
            return ['errors' => $e->getMessage()];
        }
    }

    public function destroy($id)
    {
        Product::find($id)->remove();

        return redirect()->route('products.index');
    }

    public function toggle($id)
    {
        $product = Product::find($id);
        $product->toggledsStatus();

        return redirect()->back();
    }

//========= Modification ======================================
    public function modificationAdd(ModificationRequest $request)
    {
        try {
            $modification = Modification::create($request->all(), $request->modification_id);

            return ($request->ajax())
                ? ['succes' => view('admin.vinograd.product._modification-input-item', ['modification' => $modification])->render()]
                : redirect()->back();
        } catch (\Exception $e) {
            return ['errors' => $e->getMessage()];
        }
    }

    public function modificationEdit(ModificationEditRequest $request)
    {
        try {
            $modification = Modification::find($request->modification_id);
            $modification->edit($request->price, $request->quantity);

            return ($request->ajax())
                ? ['succes' => 'Модификация обновлена!']
                : redirect()->back();
        } catch (\Exception $e) {
            return ['errors' => $e->getMessage()];
        }
    }

    public function modificationDelete(ModificationDeleteRequest $request)
    {
        try {
            $modification = Modification::find($request->modification_id);
            $modification->remove();

            return ($request->ajax())
                ? ['succes' => 'Модификация удалена!']
                : redirect()->back();
        } catch (\Exception $e) {
            return ['errors' => $e->getMessage()];
        }
    }

//=============================================================
    public function imageServis(Request $request, Model $product)
    {
        try {
            $product->uploadImage($request->file('image'));
            $product->removeImageFromGallery($request->get('removeGallery'));
            $product->uploadGallery($request->ajax() ? $request->file('images') : $request->file('gallery'));

            if($request->file('image') != null) {
                dispatch(new ImageProcessing($product));
                //$product->fitImage();
            }
            if($request->file('images') != null || $request->file('gallery') != null){
                dispatch(new GalleryProcessing($product));
                //$product->fitGallery();
            }
            dispatch(new ContentProcessing($product));

        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }
}
