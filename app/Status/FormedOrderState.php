<?php

namespace App\Status;

use Illuminate\Support\Arr;

final class FormedOrderState extends OrderState
{
    protected $allowedStatuses = [
        Status::PAID,
        Status::SENT,
        Status::COMPLETED,
        Status::CANCELLED,
    ];

    public function value(): string
    {
        return Status::FORMED;
    }

    public function actions(): void
    {
        //
    }

    public function humanValue(): string
    {
        return Arr::get(Status::list(), Status::FORMED);
    }
}
