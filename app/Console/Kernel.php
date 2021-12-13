<?php

namespace App\Console;

use App\Console\Commands\CurrencyExchange;
use App\Console\Commands\StatusChange;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //'App\Console\Commands\SitemapArticle',
        //'App\Console\Commands\SitemapVinograd',
        'App\Console\Commands\Queues',
        'App\Console\Commands\YandexMetricAPI',
        CurrencyExchange::class,
        StatusChange::class
    ];

    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('sitemap:article')->everyMinute();
        //$schedule->command('sitemap:section')->everyMinute();
        //289
        //294

        $schedule->command('queues:start')->everyMinute();

//        $schedule->command('metric:start')->everyMinute();
        $schedule->command('metric:start')->daily();

        $schedule->command('currency:exchange')->daily();
        //$schedule->command('currency:exchange')->everyMinute();

        $schedule->command('status:change')->cron('* * 1 10 *'); //   Переводим предварительные заказы в новые
        $schedule->command('status:change')->cron('* * 1 4 *'); //   Переводим предварительные заказы в новые

        // 0 0 1 1 * Выполнение команды каждый год 1-го января в 00:00:

        //  Cron=/opt/php73/bin/php /home/user1209858/www/vinograd-minsk.by/artisan schedule:run >> /dev/null 2>&1
        //  php %sitedir%\vinograd\artisan schedule:run --для локального сервера

        //для тестирования я выполнял так:
        //$schedule->command('xmlsitemap')->cron('* * * * *')->sendOutputTo("/tmp/shed_log");
        //в формате крон ежеминутно(каждый запуск) и вывод в файл
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
