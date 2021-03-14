<?php

namespace App\Models\Vinograd;

use App\Models\Vinograd\Order\Order;
use App\UseCases\CurrencyService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DeliveryMethod extends Model
{
    use Sluggable;

    protected $table = 'vinograd_delivery_methods';
    public $timestamps = false;
    protected $fillable = ['name', 'content', 'slug', 'cost', 'min_weight', 'max_weight'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

//    public function orders()
//    {
//        return $this->hasMany(Order::class);
//    }

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
    }

    public function remove()
    {
        $this->delete();
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
}
