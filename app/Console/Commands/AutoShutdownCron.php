<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class AutoShutdownCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoshutdown:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        #Cek cronjob status
        $cronStatus = DB::table('cronjob')
                    ->where('cronjob_name','autoshutdown:cron')
                    ->first();

        if ($cronStatus->cronjob_status == 'open') {
            info("Server shutdown at ". Carbon::now()->format('Y-m-d H:i:s'));
            try {
                system('shutdown -h now');
            } catch (\Throwable $th) {
                info("Shutdown failed.");
                info("Error: ".$th);
            }
        }else{
            return Command::SUCCESS;
        }
    }
}
