<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Http\Requests\Admin\Vinograd\Slider\SliderRequest;
use App\Jobs\ImageProcessing;
use App\Models\Vinograd\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;

class SlidersController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('slider_active', ' active');
    }

    public function index()
    {
        return view('admin.vinograd.slider.index', [
            'sliders' => Slider::all()
        ]);
    }

    public function create()
    {
        return view('admin.vinograd.slider.create');
    }

    public function store(SliderRequest $request)
    {
        $slider = Slider::add($request->all());
        $this->imageServis($request, $slider);

        return redirect()->route('sliders.index');
    }

    public function edit($id)
    {
        return view('admin.vinograd.slider.edit', [
            'slider' => Slider::find($id)
        ]);
    }

    public function update(SliderRequest $request, $id)
    {
        $slider = Slider::find($id);
        $slider->edit($request->all());
        $this->imageServis($request, $slider);

        return redirect()->route('sliders.index');
    }

    public function destroy($id)
    {
        Slider::find($id)->remove();
        return redirect()->route('sliders.index');
    }

    public function imageServis(Request $request, $slider)
    {
        try {
            $slider->uploadImage($request->file('image'));
            dispatch(new ImageProcessing($slider));
        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

}
