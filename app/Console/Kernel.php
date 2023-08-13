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
        $schedule->command('getdata:cron')->everyMinute()->withoutOverlapping(10);
        $schedule->command('duplicatemaster:cron')->everyMinute()->withoutOverlapping(10);
        $schedule->command('duplicaterekap:cron')->everyMinute()->withoutOverlapping(10);
        $schedule->command('senddata:cron')->everyThreeMinutes()->withoutOverlapping(10);
        $schedule->command('version:cron')->hourly()->withoutOverlapping(10);
        $schedule->command('mastercontrol:cron')->hourly()->withoutOverlapping(10);
        $schedule->command('sendcloud:cron')->everyTwoMinutes()->withoutOverlapping(10);
        $schedule->command('sendserverstatus:cron')->everyMinute()->withoutOverlapping(10);
        $schedule->command('countdataserver:cron')->dailyAt('10:00')->withoutOverlapping(10);
        $schedule->command('countdataserver:cron')->dailyAt('14:00')->withoutOverlapping(10);
        $schedule->command('countdataserver:cron')->dailyAt('20:00')->withoutOverlapping(10);
        $schedule->command('resetlog:cron')->monthly()->withoutOverlapping(10);

        // $schedule->command('datasync:cron')->everyMinute()->withoutOverlapping(10);
        // $schedule->command('getdataupdate:cron')->everyMinute()->withoutOverlapping(10);
        // $schedule->command('autoshutdown:cron')->dailyAt('23:59')->withoutOverlapping(10);


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
