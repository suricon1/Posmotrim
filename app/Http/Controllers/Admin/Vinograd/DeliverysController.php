<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Http\Requests\Admin\Vinograd\Delivery\DeliveryRequest;
use App\Models\Vinograd\DeliveryMethod;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

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
        DeliveryMethod::create($request);
        return redirect()->route('deliverys.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show (DeliveryMethod $delivery)
    {
        //
    }

    public function edit(DeliveryMethod $delivery)
    {
        return view('admin.vinograd.deliveryMethod.edit', [
            'delivery' => $delivery
        ]);
    }

    public function update(DeliveryRequest $request, DeliveryMethod $delivery)
    {
        $delivery->edit($request);

        return redirect()->route('deliverys.index');
    }

    public function destroy(DeliveryMethod $delivery)
    {
        $delivery->remove();
        return redirect()->route('deliverys.index');
    }

    public function toggle($id)
    {
        $delivery = DeliveryMethod::find($id);
        $delivery->toggledsStatus();
        return redirect()->back();
    }

}
