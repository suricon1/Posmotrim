<?php

namespace App\Models\Vinograd\Order;

use App\Models\Vinograd\DeliveryMethod;
use App\Repositories\DeliveryMethodRepository;

class DeliveryData
{
    public $method_id;
    public $method_name;
    public $cost;
    public $index;
    public $address;
    public $weight;

    private $delivery;

    public function __construct($method_id = DeliveryMethod::SELF_DELIVERY)
    {
        $repository = new DeliveryMethodRepository();
        $this->delivery = $repository->get($method_id);

        $this->method_id = $this->delivery->id;
        $this->method_name = $this->delivery->name;

        if($method_id == DeliveryMethod::SELF_DELIVERY) {
            $this->setAddress();
            $this->setWeight();
        }
    }

    public function setWeight($weight = 0)
    {
        $this->weight = $weight;
        $this->cost = $this->delivery->getDeliveryCost($weight);
    }

    public function setAddress($index = '', $address = '')
    {
        $this->index = $index;
        $this->address = $address;
    }
}
