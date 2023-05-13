<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;

class VersionController extends Controller
{
    public function upgrade()
    {
        # code...
    }
    public function tes(){
        #/home/admin/web/cronjob.wss/public_html

        #This is Work Fine
        $path = "/usr/local/var/www/backend-cr-2023";
        $process = Process::fromShellCommandline('php artisan config:clear');
        // $process->setWorkingDirectory(base_path());
        $process->setWorkingDirectory($path);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();

        #tes
        $migration = new Process([]);
        $migration->start();
        $migration->setWorkingDirectory(base_path());
        $migration->fromShellCommandline('php artisan migrate');
        // $migration->run();
        echo $migration->getOutput();
        $migration->wait();
        $migration->fromShellCommandline('php artisan config:clear');
        // $migration->run();
        echo $migration->getOutput();
        $migration->stop();

        // if($migration->isSuccessful()){
        //     return response("Migrattion Success");
        // } else {
        //     throw new ProcessFailedException($migration);
        // }
    }
}
