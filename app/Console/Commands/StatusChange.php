<?php

namespace App\Console\Commands;

use App\Mail\Admin\StatusChangeErrorMail;
use App\Models\Vinograd\Order\Order;
use Illuminate\Console\Command;
use Mail;

class StatusChange extends Command
{
    protected $signature = 'status:change';

    public function handle()
    {
        try {
            Order::where('current_status', 7)->update(['current_status' => 1]);
        }catch (\Exception $e){
            Mail::to(config('main.admin_email'))->queue(new StatusChangeErrorMail($e->getMessage()));
        }
    }
}
