<?php

namespace App\Models\Vinograd;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Model;

class Modification extends Model
{
    protected $table = 'vinograd_product_modifications';
    public $timestamps = false;
    protected $fillable = ['product_id', 'modification_id', 'price', 'quantity'];

    protected $casts = [
        'price' => PriceCast::class
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function property()
    {
        return $this->belongsTo(ModificationProps::class, 'modification_id');
    }

    public static function create($fields)
    {
        $modification = new static;
        $modification->fill($fields);
        $modification->in_stock = $fields['quantity'];
        $modification->save();
        return $modification;
    }

    public function edit($price, $correct)
    {
        $this->price = $price;
        $this->quantity = $this->quantity + $correct;
//        if ($this->quantity < 0){
//            throw new \DomainException('Колличество товара не может быть меньше 0!');
//        }
        $this->in_stock = $this->in_stock + $correct;
        if ($this->in_stock < 0){
            throw new \DomainException('Колличество товара не может быть меньше 0!');
        }
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    public function checkout($quantity, $pre)
    {
        if (!$pre && $quantity > $this->quantity) {
            throw new \DomainException('Вас кто то опередил!<br>' . $this->product->name.' - '.$this->property->name.'.<br>В наличии осталось '.$this->quantity.' шт.<br>Отредактируйте корзину.');
        }
        $this->quantity -= $quantity;
    }

    public function returnQuantity($quantity)
    {
        $this->quantity += $quantity;
    }

    public function returnInStock($quantity) // Применять если отменяется заказ со статусом отправлен или оплачен
    {
        $this->in_stock += $quantity;
    }

    public function checkoutInStock($quantity)
    {
        if ($quantity > $this->in_stock) {
            throw new \RuntimeException($this->product->name.' - '.$this->property->name.'.<br>Наличие товара уходит в минус. Необходимо откорректировать наличие товара.');
        }
        $this->in_stock -= $quantity;
    }

    public function isIdEqualTo($id)
    {
        return $this->id == $id;
    }
}
