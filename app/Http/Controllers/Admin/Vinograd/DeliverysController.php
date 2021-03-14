<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Http\Requests\Admin\Vinograd\Delivery\DeliveryRequest;
use App\Models\Vinograd\DeliveryMethod;
use App\Http\Controllers\Controller;
use View;

class DeliverysController extends Controller
{
    public function __construct()
    {
        View::share ('deliverys_open', ' menu-open');
        View::share ('deliverys_active', ' active');
    }

    public function index()
    {
        return view('admin.vinograd.deliveryMethod.index', [
            'deliverys' => DeliveryMethod::all()
        ]);
    }

    public function create()
    {
        return view('admin.vinograd.deliveryMethod.create');
    }

    public function store(DeliveryRequest $request)
    {
        $method = DeliveryMethod::create($request);
        return redirect()->route('deliverys.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('admin.vinograd.deliveryMethod.edit', [
            'delivery' => DeliveryMethod::find($id)
        ]);
    }

    public function update(DeliveryRequest $request, $id)
    {
        $delivery = DeliveryMethod::find($id);
        $delivery->edit($request);

        return redirect()->route('deliverys.index');
    }

    public function destroy($id)
    {
        DeliveryMethod::find($id)->remove();
        return redirect()->route('deliverys.index');
    }
}
