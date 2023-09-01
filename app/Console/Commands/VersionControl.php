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

        if ($getVersion->count() == 0) {
            Log::info("Cronjob VERSION INFO NOT FOUND");
            return Command::SUCCESS;
        }

        foreach ($getVersion as $keyVersi => $valVersi) {
            #cek versi aplikasi lokal
            $cekVersi = DB::table('version_app')
                        ->where('version_app_name',$valVersi->version_app_name)
                        ->first();

            if (!empty($cekVersi)) {
                if ($cekVersi->version_app_code == $valVersi->version_app_code) {
                    continue;
                }
            }
            #get app instruction
            $command = DB::connection('cronpusat')
                        ->table('instuction_update')
                        ->where('instuction_update_app_name',$valVersi->version_app_name)
                        ->orderBy('instuction_update_order','asc')
                        ->get();

            if ($command->count() == 0) {
                Log::info("Cronjob VERSION - Command of {$valVersi->version_app_name} NOT FOUND");
                continue;
            }

            $commandCount = $command->count();
            $i = 1;
            foreach ($command as $keyCom => $valCom) {
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
                $syntax = $valCom->instuction_update_syntax;
                if (str_contains($valCom->instuction_update_syntax, 'migrate')) {
                    $syntax = $valCom->instuction_update_syntax." --path={$newPath}/database/migrations";
                }

                $process = Process::fromShellCommandline($syntax);
                $process->setWorkingDirectory($newPath);
                $process->run();
                $i++;
                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                    Log::info("Cronjob VERSION - {$valVersi->version_app_name}-{$syntax} FAILED");
                    $i--;
                }
                Log::info($process->getOutput());

                if ($i == $commandCount) {
                    Log::info("Cronjob VERSION - {$valVersi->version_app_name} UPDATE SUCCESS");
                    $version = $valVersi->version_app_code;
                }else{
                    $version = $valVersi->version_app_code."-With Failed";
                }
                DB::table('version_app')
                    ->updateOrInsert([
                            'version_app_name' => $valVersi->version_app_name
                        ],
                        [
                        'version_app_name' => $valVersi->version_app_name,
                        'version_app_code' => $version
                    ]);

                    $getLocalSipedas = DB::table('db_con')
                    ->where('db_con_host','127.0.0.1')
                    ->first();

                    $fieldApp = 'log_version_'.$valVersi->version_app_name;
                    DB::connection('cronpusat')
                    ->table('log_version')
                    ->updateOrInsert(
                        [
                            'log_version_m_w_id' => $getLocalSipedas->db_con_m_w_id
                        ],
                        [
                            $fieldApp => $version
                        ]
                    );
            }
        }
        Log::info("Cronjob VERSION FINISH at ". Carbon::now()->format('Y-m-d H:i:s'));
        return Command::SUCCESS;
    }
}
