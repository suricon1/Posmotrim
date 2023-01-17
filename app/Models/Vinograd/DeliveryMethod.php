<?php

namespace App\Models\Vinograd;

use App\Models\Vinograd\Order\Order;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DeliveryMethod extends Model
{
    use Sluggable;

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;

    const SELF_DELIVERY = 1;

    protected $table = 'vinograd_delivery_methods';
    public $timestamps = false;
    protected $fillable = ['name', 'content', 'slug', 'cost', 'price', 'status', 'min_weight', 'max_weight'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeFilterCost($query, $cost)
    {
        if($cost < 100){
            return $query->whereNotIn('slug', ['courier-free']);
        }
        return $query;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function create(Request $request): self
    {
        $method = new static();
        $method->fill($request->all());
        $method->sort = DeliveryMethod::all()->count() + 1;
        $method->save();
        return $method;
    }

    public function edit(Request $request): void
    {
        $this->fill($request->all());
        $this->save();

//        $this->name = $name;
//        $this->cost = $cost;
//        $this->min_weight = $minWeight;
//        $this->max_weight = $maxWeight;
//        $this->sort = $sort;
    }

    public function remove()
    {
        $this->delete();
    }


    public function setDraft()
    {
        $this->status = self::IS_DRAFT;
        $this->save();
    }

    public function setPublic()
    {
        $this->status = self::IS_PUBLIC;
        $this->save();
    }

    public function toggleStatus($value)
    {
        return ($value == null) ? $this->setDraft() : $this->setPublic();
    }

    public function toggledsStatus()
    {
        return ($this->status == 0) ? $this->setPublic() : $this->setDraft();
    }

    public function getDeliveryCost($weight)
    {
        /*
         * Калькулятор расчета стоимости мелкого пакета в РФ
         * http://tarifikator.belpost.by/forms/international/small.php
         */

        if(!$this->cost) {
            return 0;
        }
        if($weight <= $this->min_weight) {
            return $this->cost;
        }
        return $this->price * ceil(($weight - $this->min_weight) / 100) + $this->cost;
    }

    public function isAvailableForWeight($weight): bool
    {
        return (!$this->min_weight || $this->min_weight <= $weight) && (!$this->max_weight || $weight <= $this->max_weight);
    }

    public function isPickup(): bool
    {
        return $this->slug == 'pickup';
    }

    public function isPostal(): bool
    {
        return $this->slug == 'postal';
    }

    public function isPostalRussian(): bool
    {
        return $this->slug == 'postal-russia';
    }

    public function isCourier(): bool
    {
        return $this->slug == 'courier';
    }

    public function isFree(): bool
    {
        return $this->slug == 'courier-free';
    }

    public function isPostalBelarus(): bool
    {
        return $this->slug == 'postal-belarus';
    }

    public function isMailed()
    {
        if($this->isPostal() || $this->isPostalRussian() || $this->isPostalBelarus()) {
            return true;
        } else {
            return false;
        }
    }
}
