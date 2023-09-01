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
        $process = new Process(['php','/usr/local/var/www/sipedas_v4/artisan','db:seed --class=MigrationSeeder']);
$process->run();
return $process->getOutput();
//         return $path = base_path();
        $path= "/home/adminweb/web/cronjob.wss/public_html";
        $appPath = 'cr55.wss';
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
        return $newPath;
    }
    public function test(){
        #/home/admin/web/cronjob.wss/public_html
        // $string = 'php artisan migrate';
        // if (str_contains($string, 'migrate')) {
        //     return 'ada';
        // }else{
        //     return 'tidak';
        // }
        #This is Work Fine
        $path = "/usr/local/var/www/sipedas_v4";
        // try {
            //code...

        $process = Process::fromShellCommandline('composer dump-autoload');
        // $process = Process::fromShellCommandline('php artisan migrate --path=/usr/local/var/www/sipedas_v4/database/migrations');
        // $process->setWorkingDirectory(base_path());
        $process->setWorkingDirectory($path);
        $process->run();

        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return $th;
        // }
        // return $process->getOutput();

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
