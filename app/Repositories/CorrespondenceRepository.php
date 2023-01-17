<?php


namespace App\Repositories;


use App\Models\Vinograd\Order\OrderCorrespondence;

class CorrespondenceRepository
{
    public function remove(OrderCorrespondence $correspondence): void
    {
        if (!$correspondence->delete()) {
            throw new \RuntimeException('Ошибка удаления переписки с заказчиком!');
        }
    }
}
