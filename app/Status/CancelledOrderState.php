<?php

namespace App\Status;

use Illuminate\Support\Arr;

final class CancelledOrderState extends OrderState
{
    protected $allowedStatuses = [
        Status::NEW
    ];

    function value(): string
    {
        return Status::CANCELLED;
    }

    function humanValue(): string
    {
        return Arr::get(Status::list(), Status::CANCELLED);
    }

    function actions(): void
    {
        $this->service->returnQuantity($this->order);
        $this->service->returnInStock($this->order);
    }

    protected function getAllowedStatuses(): array
    {
        return [
            Status::NEW => 'Новый'
        ];
    }
}
