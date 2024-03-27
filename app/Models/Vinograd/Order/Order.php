<?php

namespace App\Models\Vinograd\Order;

use App\Models\Vinograd\DeliveryMethod;
use App\Models\Vinograd\QueryBuilder\OrderQueryBuilder;
use App\Models\Vinograd\User;
use App\Status\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @method static Order|OrderQueryBuilder $query
 */
class Order extends Model
{
    use Notifiable;

    const ORDERED_LIST = [
        Status::NEW,
        Status::PRELIMINARY,
        Status::FORMED
    ];

    const SOLD_LIST = [
        Status::PAID,
        Status::SENT,
        Status::COMPLETED
    ];

    protected $table = 'vinograd_orders';
    public $timestamps = false;
    protected $fillable = [
        'created_at',
        'completed_at',
        'user_id',
        'delivery',
        'customer',
        'payment_method',
        'cost',
        'note',
        'current_status',
        'track_code',
        'statuses_json',
        'print_count',
        'date_build'
    ];

    protected $casts = [
        'statuses_json' => 'array',
        'customer' => 'array',
        'delivery' => 'array',
    ];

    public $customerData;

//    public function getStatusesAttribute(): OrderState
//    {
//        return Status::createStatus((int)$this->current_status, $this);
//    }

    public function statuses(): Attribute
    {
        return Attribute::make(
            get: fn() => Status::createStatus((int)$this->current_status, $this)
        );
    }

    public function newEloquentBuilder($query): OrderQueryBuilder
    {
        return new OrderQueryBuilder($query);
    }

    public static function create($userId, DeliveryData $deliveryData, CustomerData $customerData, $cost, $note, $status): self
    {
        $order = new static();
        $order->user_id = $userId;
        $order->delivery = $deliveryData;
        $order->customer = $customerData;
        $order->cost = $cost;
        $order->currency = realCurr()->code;
        $order->note = $note;
        $order->created_at = time();
        $order->addStatus($status);
        return $order;
    }

    public function edit(CustomerData $customerData, $note): void
    {
        $this->customerData = $customerData;
        $this->note = $note;
    }

    public function remove()
    {
        $this->delete();
    }

/////////////////

    public function getWeight(): int
    {
        return $this->items->map(function ($item) {
            return $item->modification->property->weight * $item->quantity;
        })->sum();
    }

    public function getTotalCost($delivery = false): int
    {
        if (!isset($this->delivery['weight'])) {
            return $this->cost + $this->delivery['cost'];
        }
        $delivery = $delivery ?: DeliveryMethod::find($this->delivery['method_id']);
        return $this->cost + $delivery->getDeliveryCost($this->delivery['weight']);
    }

//////////

    public function canBePaid(): bool
    {
        return $this->isNew();
    }

    public function isNew(): bool
    {
        return $this->current_status == Status::NEW;
    }

    public function isPaid(): bool
    {
        return $this->current_status == Status::PAID;
    }

    public function isSent(): bool
    {
        return $this->current_status == Status::SENT;
    }

    public function isCompleted(): bool
    {
        return $this->current_status == Status::COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->current_status == Status::CANCELLED;
    }

    public function isCancelledByCustomer(): bool
    {
        return $this->current_status == Status::CANCELLED_BY_CUSTOMER;
    }

    public function isPreliminsry(): bool
    {
        return $this->current_status == Status::PRELIMINARY;
    }

    public function isFormed(): bool
    {
        return $this->current_status == Status::FORMED;
    }

    public function isMailed()
    {
        if ($this->delivery['method_id'] == 2 || $this->delivery['method_id'] == 5 || $this->delivery['method_id'] == 6) {
            return true;
        } else {
            return false;
        }
    }

    public function isAllowedDateBuild(): bool
    {
        if ($this->isSent() || $this->isCancelled() || $this->isCancelledByCustomer()) {
            return false;
        }
        return true;
    }

    public function isTrackCode(): bool
    {
        return $this->track_code !== null;
    }

    public function isDateBuild(): bool
    {
        return $this->date_build !== null;
    }

    public function isCreatedByAdmin(): bool
    {
        return in_array($this->user_id, [2, 3, 4]);
    }

    public function addStatus($value): void
    {
        if ($value == Status::NEW) {
            $this->statuses_json = [];
        }
        $this->statuses_json = $this->statuses_json ?: [];
        $this->statuses_json = array_merge($this->statuses_json, [
            new Status($value, time())
        ]);
        $this->current_status = $value;

        if ($value == Status::COMPLETED) {
            $this->completed_at = time();
        }
    }

    public function getPercent($totalCost)
    {
        return round(($this->cost * 100) / $totalCost, 1);
    }

    public function routeNotificationForMail($notification)
    {
        return $this->customer['email'];
    }

    public function setTrackCode($code)
    {
        if ($code) {
            $this->track_code = $code;
        }
    }

    public function setPrintCount()
    {
        $this->print_count = $this->print_count ? $this->print_count + 1 : 1;
    }

    public function setDateBuild($date_build)
    {
        $this->date_build = $date_build;
    }

    public function getDateBuild()
    {
        return $this->date_build;
    }

    ##########################

    public function scopeTimeRange($query, $dateRange, $status)
    {
        $data = !isset($status) ? 'completed_at' : 'created_at';
//        $data = !$status ? 'completed_at' : 'created_at';
        $query->where($data, '>=', $dateRange['from']);
        if ($dateRange['to']) {
            $query->where($data, '<=', $dateRange['to']);
        }
        return $query;
    }

    public function scopeStatus($query, $status)
    {
        return $status
            ? $query->where('current_status', $status)
            : $query;
    }

    public function scopeWhereStatus($query, $status)
    {
        if (is_array($status)) {
            return $query->whereIn('current_status', $status);
        }
        return $status
            ? $query->where('current_status', $status)
            : $query->where('current_status', Status::COMPLETED);
    }

    public function scopeSelectOrdersByNumbers($query, $order_ids)
    {
        return $order_ids
            ? $query->whereIn('vinograd_orders.id', $order_ids)
            : $query;
    }

    ########## Relationships ################

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function correspondences()
    {
        return $this->hasMany(OrderCorrespondence::class);
    }

    ########## Mutators ################

    public function getCompletedAtAttribute($value)
    {
        if ($value) {
            return getRusDate($value);
        }
        return '---';
    }
}
