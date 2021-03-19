<?php

namespace App\Models\Vinograd;

class ProductProps
{
    public $mass;
    public $color;
    public $flavor;
    public $frost;
    public $flower;

    public function __construct($props)
    {
        $this->mass = $props->input('props.mass');
        $this->color = $props->input('props.color');
        $this->flavor = $props->input('props.flavor');
        $this->frost = $props->input('props.frost');
        $this->flower = $props->input('props.flower');
        $this->similar = $props->input('props.similar');
    }
}
