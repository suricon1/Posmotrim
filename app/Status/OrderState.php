<?php

namespace App\Status;

use App\Models\Vinograd\Order\Order;
use App\Repositories\ModificationRepository;
use App\Repositories\OrderRepository;
use App\UseCases\StatusService;
use Html;
use Illuminate\Support\Arr;
use \RuntimeException;

abstract class OrderState
{
    protected $order;
    protected $service;

    protected $allowedStatuses = [];
    public $allowedTransitions = [];

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->allowedTransitions = $this->getAllowedStatuses();
        $this->service = new StatusService(new OrderRepository, new ModificationRepository);
    }

    abstract function value(): string;

    abstract function actions(): void;

    abstract function humanValue(): string;

    public function transitionTo(OrderState $state): void
    {
        if(!array_key_exists($state->value(), $this->allowedTransitions)) {
            throw new RuntimeException(
                "Этот заказ нельзя перевести в -<{$state->humanValue()}>-."
            );
        }

        $this->order->addStatus($state->value());
        $state->actions();

//        event(new OrderStatusChanged(
//           $this->order,
//           $this,
//           $state
//        ));
    }

    public function name($status = false): string
    {
        $status = $status ?: $this->value();
        return Html::tag('span', Arr::get(Status::list(), $status), [
            'class' => 'input-group-text bg-' . Status::statusColor($status)
        ]);
    }

    protected function getAllowedStatuses(): array
    {
        $slice = Arr::only(Status::list(), $this->allowedStatuses);

        foreach ($this->order->statuses_json as $item){
            if(array_key_exists($item['value'], $slice)){
                unset($slice[$item['value']]);
            }
        }
        return $slice;
    }
}
