<?php

namespace App\Models\Vinograd\Order;
class CustomerData
{
    public $phone;
    public $name;
    public $email;

    public function __construct($phone = '', $name = '', $email = '')
    {
        $this->phone = preg_replace("/[^\d]/", '', $phone);
        $this->name = $name;
        $this->email = $email;
    }
}
