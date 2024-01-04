<?php

namespace App\Repositories;

use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\Order as Model;
use Illuminate\Http\Request;

class OrderRepository extends CoreRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param int $id
     *
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->modelName()->find($id);
    }

    public function getFilterOrders(Request $request, $status)
    {
        $query = $this->modelName()->status($status);

        if (!empty($request->get('id'))) {
            $query->orWhere('id', $request->get('id'));
        }
        if (!empty($request->get('email'))) {
            $query->orWhere('customer', 'like', '%' . $request->get('email') . '%');
        }
        if (!empty($request->get('phone'))) {
            $query->orWhere('customer', 'like', '%' . preg_replace("/[^\d]/", '', $request->get('phone')) . '%');
        }
        if (!empty($request->get('build'))) {
            $query->orWhere('date_build', $request->get('build'));
        }

        return $query->orderBy('current_status')->orderBy('id', 'desc')->paginate(30)->appends($request->all());
    }


    //######################################

    public function get($id): Order
    {
        if (!$order = Order::with('items')->find($id)) {
            throw new \RuntimeException('Order is not found.');
        }
        return $order;
    }

    public function save(Order $order): void
    {
        if (!$order->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Order $order): void
    {
        if (!$order->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function isCompleted(Order $order): void
    {
        if ($order->isCompleted()) {
            throw new \RuntimeException('Заказ закрыт.');
        }
    }
}
