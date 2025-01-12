<?php

namespace App\Status;

use App\Models\Vinograd\Order\Order;
use InvalidArgumentException;
use Illuminate\Support\Str;
use ReflectionClass;

class Status
{
    const NEW = 1;
    const PAID = 2;
    const SENT = 3;
    const COMPLETED = 4;
    const CANCELLED = 5;
    const CANCELLED_BY_CUSTOMER = 6;
    const PRELIMINARY = 7;
    const FORMED = 8;

//    public $value;
//    public $created_at;

    public function __construct(public $value, public $created_at)
    {
//        $this->value = $value;
//        $this->created_at = $created_at;
    }

    public static function createStatus (int $status, Order $order): OrderState
    {
        $class = self::get_name_class($status);
        return new $class($order);
    }

    public static function list(): array
    {
        return [
            self::NEW => 'Новый',
            self::PAID => 'Оплачен',
            self::SENT => 'Отправлен',
            self::COMPLETED => 'Выполнен',
            self::CANCELLED => 'Отменен',
            self::CANCELLED_BY_CUSTOMER => 'Отменен клиентом',
            self::PRELIMINARY => 'Предварительный',
            self::FORMED => 'Сформирован'
        ];
    }

    public static function orderEditable()
    {
        return [
            self::NEW,
            self::PAID,
            self::PRELIMINARY,
            self::FORMED
        ];
    }

    public static function statusColor(int $status): string
    {
        switch ($status) {
            case self::NEW:
                return 'success';
            case self::PAID:
                return 'primary';
            case self::SENT:
                return 'secondary';
            case self::COMPLETED:
                return 'info';
            case self::CANCELLED:
                return 'danger';
            case self::CANCELLED_BY_CUSTOMER:
                return 'danger';
            case self::PRELIMINARY:
                return 'warning';
            case self::FORMED:
                return 'light';
            default:
                return 'default';
        }
    }

    private static function get_name_class(int $status): string
    {
        $consts = (new ReflectionClass (self::class))->getConstants ();

        foreach ($consts as $name => $value) {
            if ($value === $status) {
                return 'App\\Status\\'.Str::title($name).'OrderState';
            }
        }
        throw new InvalidArgumentException('Такой статус не поддерживается.');
    }
}
