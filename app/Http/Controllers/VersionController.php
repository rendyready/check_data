<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class VersionController extends Controller
{
    public function setup(){
        #This is Work Fine
        // $process = Process::fromShellCommandline('php artisan migrate');
        // $process->setWorkingDirectory(base_path());
        // $process->run();
        // if (!$process->isSuccessful()) {
        //     throw new ProcessFailedException($process);
        // }

        // echo $process->getOutput();

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
