<?php


namespace App\Repositories;


use App\Models\Vinograd\Modification;

class ModificationRepository
{
    public function save(Modification $modification): void
    {
        if (!$modification->save()) {
            throw new \RuntimeException('Ошибка сохранения модификации!');
        }
    }

    public function remove(Modification $modification): void
    {
        if (!$modification->delete()) {
            throw new \RuntimeException('Ошибка удаления модификации!');
        }
    }
}
