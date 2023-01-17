<?php

namespace App\cart;

use App\Models\Vinograd\Modification;
use App\Models\Vinograd\Product;

class CartItem
{
    private $product;
    private $modification;
    private $quantity;

    public function __construct(Product $product, $modification, $quantity)
    {
        $this->modification = Modification::find($modification->id);
        if (!$product->canBeCheckout($modification->id, $quantity)) {
            throw new \DomainException($product->name.' - '.$this->modification->property->name.'.<br>Вы заказываете слишком много! В наличии только '.$this->modification->quantity.' шт.');
        }
        $this->product = $product;
        //$this->modification = $modification;
        $this->quantity = $quantity;
    }

    public function getId()
    {
        return md5(serialize([$this->product->id, $this->modification->id]));
    }

    public function getProductId()
    {
        return $this->product->id;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getModificationId()
    {
        return $this->modification->id;
    }

    public function getModification()
    {
//        if ($this->modification->id) {
//            return $this->product->getModification($this->modification->id);
//        }
//        return null;
        return $this->modification;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPrice()
    {
        return $this->product->getModificationPrice($this->modification->id);
    }

    public function getWeight()
    {
        return $this->modification->property->weight * $this->quantity;
    }

    public function getCost()
    {
        return $this->getPrice() * $this->quantity;
    }

    public function plus($quantity)
    {
        return new static($this->product, $this->modification, $this->quantity + $quantity);
    }

    public function changeQuantity($quantity)
    {
        return new static($this->product, $this->modification, $quantity);
    }
}
