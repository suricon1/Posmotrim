<?php

namespace App\Models\Vinograd\Order;

use App\Models\Vinograd\Product;
use App\Models\Vinograd\User;
use Html;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

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
    ];

    protected $casts = [
        'statuses_json' => 'array',
        'customer' => 'array',
        'delivery' => 'array',
    ];

    public $customerData;

    public static function statusList(): array
    {
        return [
            Status::NEW => 'Новый',
            Status::PAID => 'Оплачен',
            Status::SENT => 'Отправлен',
            Status::COMPLETED => 'Выполнен',
            Status::CANCELLED => 'Отменен',
            Status::CANCELLED_BY_CUSTOMER => 'Отменен клиентом',
            Status::PRELIMINARY => 'Предварительный',
            Status::FORMED => 'Сформирован'
        ];
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

    public function pay($method): void
    {
        if ($this->isPaid()) {
            throw new \DomainException('Order is already paid.');
        }
        $this->payment_method = $method;
        $this->addStatus(Status::PAID);
    }

    public function send(): void
    {
        if ($this->isSent()) {
            throw new \DomainException('Order is already sent.');
        }
        $this->addStatus(Status::SENT);
    }

    public function complete(): void
    {
        if ($this->isCompleted()) {
            throw new \DomainException('Order is already completed.');
        }
        $this->addStatus(Status::COMPLETED);
    }

    public function cancel($reason): void
    {
        if ($this->isCancelled()) {
            throw new \DomainException('Order is already cancelled.');
        }
        $this->cancel_reason = $reason;
        $this->addStatus(Status::CANCELLED);
    }

    public function getTotalCost(): int
    {
        return $this->cost + $this->delivery['cost'];
    }

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

    public function isTrackCode(): bool
    {
        return $this->track_code !== null;
    }

    public function isCreatedByAdmin(): bool
    {
        return in_array($this->user_id, [2, 3, 4]);
    }

    public function addStatus($value): void
    {
        $this->statuses_json = $this->statuses_json ?: [];
        $this->statuses_json = array_merge($this->statuses_json, [[
            'value' => $value,
            'created_at' => time()
        ]]);
        $this->current_status = $value;
        if ($value == Status::COMPLETED) {
            $this->completed_at = time();
        }
    }

    public function getColorProgress($int)
    {
        switch ($int) {
            case $int >= 50:
                return 'success';
            case $int >= 30 && $int < 49:
                return 'primary';
            case $int >= 10 && $int < 29:
                return 'warning';
            case $int < 10:
                return 'danger';
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

    ##########################

    public function scopeTimeRange($query, $dateRange, $status)
    {
        $data = !isset($status) ? 'completed_at' : 'created_at';
//        $data = !$status ? 'completed_at' : 'created_at';
        $query->where($data, '>=', $dateRange['from']);
        if($dateRange['to']){
            $query->where($data, '<=', $dateRange['to']);
        }
        return $query;
    }

    public function scopeStatus($query, $status)
    {
        return $status ? $query->where('current_status', $status) : $query;
    }

    public function scopeWhereStatus($query, $status)
    {
        if(is_array($status)){
            return $query->whereIn('current_status', $status);
        }
        return $status ? $query->where('current_status', $status) : $query->where('current_status', Status::COMPLETED);
    }

    public function scopeSelectOrdersByNumbers($query, $order_ids)
    {
        return $order_ids ? $query->whereIn('vinograd_orders.id', $order_ids) : $query;
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

    ########## Mutators ################

    public function getCompletedAtAttribute($value)
    {
        if($value){
            return  getRusDate($value);
        }
        return '---';
    }

    ##########################

    public static function statusColor($status): string
    {
        switch ($status) {
            case Status::NEW:
                return 'success';
            case Status::PAID:
                return 'primary';
            case Status::SENT:
                return 'secondary';
            case Status::COMPLETED:
                return 'info';
            case Status::CANCELLED:
                return 'danger';
            case Status::CANCELLED_BY_CUSTOMER:
                return 'danger';
            case Status::PRELIMINARY:
                return 'warning';
            case Status::FORMED:
                return 'light';
            default:
                return 'default';
        }
    }

    public static function statusName($status): string
    {
        return Html::tag('span', array_get(self::statusList(), $status), [
            'class' => 'bg-' . self::statusColor($status),
            'style' => 'padding: 5px;'
        ]);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Product::IS_DRAFT:
                $class = 'label label-default';
                break;
            case Product::IS_PUBLIC:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', array_get(self::statusList(), $status), [
            'class' => 'badge ' . $class,
        ]);
    }
}
