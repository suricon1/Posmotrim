<?php

namespace App\Models\Vinograd\Order;

class Status
{
    const NEW = 1;
    const PAID = 2;
    const SENT = 3;
    const COMPLETED = 4;
    const CANCELLED = 5;
    const CANCELLED_BY_CUSTOMER = 6;
    const PRELIMINARY = 7;
    const FORMED = 8;

    public $value;
    public $created_at;

    public function __construct($value, $created_at)
    {
        $this->value = $value;
        $this->created_at = $created_at;
    }
}
