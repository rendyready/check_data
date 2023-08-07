<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class VersionControl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'version:cron';

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
         #Cek cronjob status on Local
         $cronStatus = DB::table('cronjob')
         ->where('cronjob_name','version:cron')
         ->first();

        if (!empty($cronStatus)) {
            if ($cronStatus->cronjob_status == 'open') {
                Log::info("Cronjob VERSION START at ". Carbon::now()->format('Y-m-d H:i:s'));
            }else{
                Log::info("Cronjob VERSION CLOSED");
                return Command::SUCCESS;
            }
        }else{
            Log::info("Cronjob VERSION CLOSED");
            return Command::SUCCESS;
        }

        #Get Version app on pusat
        $getVersion = DB::connection('cronpusat')
            ->table('version_app')
            ->get();

        if (empty($getVersion)) {
            Log::info("Cronjob VERSION INFO NOT FOUND");
            return Command::SUCCESS;
        }

        foreach ($getVersion as $keyVersi => $valVersi) {
            #cek versi aplikasi lokal
            $cekVersi = DB::table('version_app')
                        ->where('version_app_name',$valVersi->version_app_name)
                        ->first();

            if (!empty($cekVersi)) {
                if ($cekVersi->version_app_code != $valVersi->version_app_code) {
                    #get app instruction
                    $command = DB::connection('cronpusat')
                                ->table('instuction_update')
                                ->where('instuction_update_app_name',$valVersi->version_app_name)
                                ->orderBy('instuction_update_order','asc');

                    if (empty($command->get())) {
                        Log::info("Cronjob VERSION - Command of {$valVersi->version_app_name} NOT FOUND");
                        continue;
                    }

                    $commandCount = $command->count();
                    $i = 1;
                    foreach ($command->get() as $keyCom => $valCom) {
                        $path = base_path();
                        $appPath = $valCom->instuction_update_base_path;
                        $replace = explode('/',$path);
                        $newPath = '';
                        foreach ($replace as $keyW => $valW) {
                            if ($keyW > 0) {
                                if ($keyW == 4) {
                                    $newPath .= '/'.$appPath;
                                } else {
                                    $newPath .= '/'.$valW;
                                }
                            }
                        }

                        $process = Process::fromShellCommandline($valCom->instuction_update_syntax);
                        $process->setWorkingDirectory($newPath);
                        $process->run();
                        if (!$process->isSuccessful()) {
                            Log::info("Cronjob VERSION - {$valVersi->version_app_name} UPDATE FAILED");
                            continue;
                        }
                        Log::info($process->getOutput());

                        if ($i == $commandCount) {
                            Log::info("Cronjob VERSION - {$valVersi->version_app_name} UPDATE SUCCESS");

                            DB::table('version_app')
                            ->where('version_app_name',$valVersi->version_app_name)
                            ->update([
                                'version_app_code' => $valVersi->version_app_code
                            ]);
                        }
                    }
                }
            }else{
                #get app instruction
                $command = DB::connection('cronpusat')
                ->table('instuction_update')
                ->where('instuction_update_app_name',$valVersi->version_app_name)
                ->orderBy('instuction_update_order','asc');

                if (empty($command->get())) {
                    Log::info("Cronjob VERSION - Command of {$valVersi->version_app_name} NOT FOUND");
                    continue;
                }

                $commandCount = $command->count();
                $i = 1;
                foreach ($command->get() as $keyCom => $valCom) {
                    $path = base_path();
                    $appPath = $valCom->instuction_update_base_path;
                    $replace = explode('/',$path);
                    $newPath = '';
                    foreach ($replace as $keyW => $valW) {
                        if ($keyW > 0) {
                            if ($keyW == 4) {
                                $newPath .= '/'.$appPath;
                            } else {
                                $newPath .= '/'.$valW;
                            }
                        }
                    }

                    $process = Process::fromShellCommandline($valCom->instuction_update_syntax);
                    $process->setWorkingDirectory($newPath);
                    $process->run();
                    if (!$process->isSuccessful()) {
                        Log::info("Cronjob VERSION - {$valVersi->version_app_name} UPDATE FAILED");
                        continue;
                    }
                    Log::info($process->getOutput());

                    if ($i == $commandCount) {
                        Log::info("Cronjob VERSION - {$valVersi->version_app_name} UPDATE SUCCESS");

                        DB::table('version_app')
                        ->insert([
                            'version_app_name' => $valVersi->version_app_name,
                            'version_app_code' => $valVersi->version_app_code
                        ]);
                    }
                }
            }

        }
        Log::info("Cronjob VERSION FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));
        return Command::SUCCESS;
    }
}
