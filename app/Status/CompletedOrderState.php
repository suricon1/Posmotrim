<?php

namespace App\Status;

use Illuminate\Support\Arr;

final class CompletedOrderState extends OrderState
{
    public function value(): string
    {
        return Status::COMPLETED;
    }

    public function actions(): void
    {
        $this->service->checkoutInStock($this->order);
    }

    public function humanValue(): string
    {
        return Arr::get(Status::list(), Status::COMPLETED);
    }
}
