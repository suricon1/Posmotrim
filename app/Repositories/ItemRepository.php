<?php

namespace App\Repositories;

use App\Models\Vinograd\Order\OrderItem;

class ItemRepository
{
    public function save(OrderItem $item): void
    {
        if (!$item->save()) {
            throw new \RuntimeException('Ошибка сохранения позиции заказа!');
        }
    }

    public function remove(OrderItem $item): void
    {
        if (!$item->delete()) {
            throw new \RuntimeException('Ошибка удаления позиции заказа!');
        }
    }

}
