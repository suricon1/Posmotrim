<?php

namespace App\Status;

use Illuminate\Support\Arr;

final class SentOrderState extends OrderState
{
    protected $allowedStatuses = [
        Status::PAID,
        Status::COMPLETED,
        Status::CANCELLED,
    ];

    public function value(): string
    {
        return Status::SENT;
    }

    public function actions(): void
    {
        $this->service->checkoutInStock($this->order);
    }

    public function humanValue(): string
    {
        return Arr::get(Status::list(), Status::SENT);
    }
}
