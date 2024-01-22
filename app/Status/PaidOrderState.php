<?php

namespace App\Status;

use Illuminate\Support\Arr;

final class PaidOrderState extends OrderState
{
    protected $allowedStatuses = [
        Status::SENT,
        Status::COMPLETED,
        Status::CANCELLED,
        Status::FORMED
    ];

    function value(): string
    {
        return Status::PAID;
    }

    function humanValue(): string
    {
        return Arr::get(Status::list(), Status::PAID);;
    }

    function actions(): void
    {
        $this->service->checkoutInStock($this->order);
    }
}
