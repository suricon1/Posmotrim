<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class Queues extends Command
{
    protected $signature = 'queues:start';

    public function handle()
    {
        Artisan::call('queue:work', ['--stop-when-empty' => true, '--tries' => 5]);
    }
}
