<?php

namespace App\Models\Vinograd\Order;

use App\Models\Vinograd\Modification;
use App\Models\Vinograd\Product;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'vinograd_order_items';
    public $timestamps = false;
    protected $fillable = ['order_id', 'product_id', 'modification_id', 'price', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function modification()
    {
        return $this->belongsTo(Modification::class);
    }

    public static function create($order_id, Modification $modification, $price, $quantity)
    {
        $item = new static;
        $item->order_id = $order_id;
        $item->product_id = $modification->product->id;
        $item->modification_id = $modification->id;
        $item->price = $price;
        $item->quantity = $quantity;
        return $item;
    }

    public function getCost(): int
    {
        return $this->price * $this->quantity;
    }

    public static function remove($id)
    {
        OrderItem::where('order_id', $id)->delete();
    }

    public static function getOrderSortedByItem ($id)
    {
        return self::
        leftJoin('vinograd_products as prod', function ($join) {
            $join->on('prod.id', '=', 'vinograd_order_items.product_id');
        })->
        rightJoin('vinograd_product_modifications as prod_mod', function ($join) {
            $join->on('prod_mod.id', '=', 'vinograd_order_items.modification_id');
        })->
        rightJoin('vinograd_modifications as mod', function ($join) {
            $join->on('mod.id', '=', 'prod_mod.modification_id');
        })->
        select(
            'prod.name as product_name',
            'mod.name as modification_name',
            'vinograd_order_items.price as price',
            'vinograd_order_items.quantity as quantity'
        )->
        where('order_id', $id)->
        orderBy('product_name')->
        get();
    }
}
