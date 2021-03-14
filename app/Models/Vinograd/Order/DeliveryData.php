<?php

namespace App\Models\Vinograd\Order;

use App\Models\Vinograd\DeliveryMethod;

class DeliveryData
{
    public $index;
    public $address;

    public function __construct(DeliveryMethod $delivery, $index = '', $address = '')
    {
        $this->method_id = $delivery->id;
        $this->method_name = $delivery->name;
        $this->cost = $delivery->cost;
        $this->index = $index;
        $this->address = $address;
    }
}
