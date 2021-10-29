<?php

namespace App\Models\Vinograd;

use Illuminate\Database\Eloquent\Model;

class Modification extends Model
{
    protected $table = 'vinograd_product_modifications';
    public $timestamps = false;
    protected $fillable = [/*'name', */'price', 'quantity', 'product_id', 'modification_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function property()
    {
        return $this->belongsTo(ModificationProps::class, 'modification_id');
    }

    public static function create($fields, $id)
    {
        $modification = new static;
        $modification->fill($fields);
        //$modification->name = ModificationProps::where('id', $id)->value('name'); // Временное решение, впоследствии удалить!
        $modification->save();
        return $modification;
    }

    public function edit($price, $quantity)
    {
        $this->price = $price;
        $this->quantity = $quantity;
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    public function checkout($quantity, $pre)
    {
        if (!$pre && $quantity > $this->quantity) {
            throw new \DomainException($this->product->name.' - '.$this->property->name.'.<br>Вы заказываете слишком много! В наличии только '.$this->quantity.' шт.');
        }
        $this->quantity -= $quantity;
    }

    public function returnQuantity($quantity)
    {
        $this->quantity += $quantity;
    }

    public function isIdEqualTo($id)
    {
        return $this->id == $id;
    }
//
//    public function priceCurrency($value)
//    {
//        return CurrencyService::Currency()->price($value);
//    }
//
//    public function signature()
//    {
//        return CurrencyService::Currency()->sign();
//    }
}
