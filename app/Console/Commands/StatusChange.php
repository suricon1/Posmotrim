<?php

namespace App\Console\Commands;

use App\Mail\Admin\StatusChangeErrorMail;
use App\Mail\Admin\StatusChangeMail;
use App\Models\Vinograd\Order\Order;
use App\Models\Vinograd\Order\Status;
use App\UseCases\StatusService;
use Illuminate\Console\Command;
use Mail;

class StatusChange extends Command
{
    protected $signature = 'status:change';

    public function handle(StatusService $service)
    {
        try {
            if($orders = Order::where('current_status', Status::PRELIMINARY)->get()) {
                foreach ($orders as $order){
                    $service->setStatus($order->id, Status::NEW);
                }
                Mail::to(config('main.admin_email'))->queue(new StatusChangeMail('Статус предварительных заказов успешно изменен.'));
            }
        }catch (\Exception $e){
            Mail::to(config('main.admin_email'))->queue(new StatusChangeErrorMail($e->getMessage()));
        }
    }
}
