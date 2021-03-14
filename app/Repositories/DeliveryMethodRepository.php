<?php

namespace App\Repositories;

use App\Models\Vinograd\DeliveryMethod;
use Intervention\Image\Exception\NotFoundException;

class DeliveryMethodRepository
{
    public function get($id): DeliveryMethod
    {
        if (!$method = DeliveryMethod::find($id)) {
            throw new NotFoundException('DeliveryMethod is not found.');
        }
        return $method;
    }

    public function findByName($name): ?DeliveryMethod
    {
        return DeliveryMethod::where('name', $name)->get();
    }

    public function save(DeliveryMethod $method): void
    {
        if (!$method->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(DeliveryMethod $method): void
    {
        if (!$method->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}