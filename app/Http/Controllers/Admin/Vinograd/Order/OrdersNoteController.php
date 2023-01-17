<?php

namespace App\Http\Controllers\Admin\Vinograd\Order;

use App\UseCases\OrderService;
use Illuminate\Http\Request;

class OrdersNoteController extends AppOrdersController
{
    public function noteEdit(Request $request, OrderService $service)
    {
        $this->validate($request, [
            'admin_note' =>  'required|string',
        ]);

        try {
            $service->adminNoteEdit($request);
            return back()->with('status', 'Примечание сохранено!');
        } catch (\DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function ajaxNoteEdit (Request $request, OrderService $service)
    {
        try {
            $service->adminNoteEdit($request);
            return ['success' => 'ok'];
        } catch  (\RuntimeException $e) {
            return ['errors' => [$e->getMessage()]];
        }
    }

}
