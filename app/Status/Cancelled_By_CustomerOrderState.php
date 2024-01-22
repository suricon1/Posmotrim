<?php

namespace App\Status;

use Illuminate\Support\Arr;

final class Cancelled_By_CustomerOrderState extends OrderState
{
    protected $allowedStatuses = [
        Status::NEW
    ];

    function value(): string
    {
        return Status::CANCELLED_BY_CUSTOMER;
    }

    function humanValue(): string
    {
        return Arr::get(Status::list(), Status::CANCELLED_BY_CUSTOMER);
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
