<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('datasync:cron')->everyMinute()->withoutOverlapping();
        $schedule->command('getdata:cron')->everyMinute()->withoutOverlapping();
        $schedule->command('getdataupdate:cron')->everyMinute()->withoutOverlapping();
        $schedule->command('sendcloud:cron')->everyTwoMinutes()->withoutOverlapping();
        $schedule->command('mastercontrol:cron')->everyMinute()->withoutOverlapping();
        $schedule->command('autoshutdown:cron')->dailyAt('23:59')->withoutOverlapping();
        $schedule->command('resetlog:cron')->monthly()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
