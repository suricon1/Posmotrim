<?php

namespace App\Providers;

use App\Mail\Admin\QueueErrorsMail;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
use Mail;
use Queue;

class QueueServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Queue::failing(function (JobFailed $event) {
            Mail::to(config('main.admin_email'))->queue(new QueueErrorsMail($event->exception->getMessage()));
        });
    }
}
