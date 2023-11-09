<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Artisan;

class ClearCache implements ShouldQueue
{
    public function handle(Login $event)
    {
        Artisan::call('cache:clear');
    }
}

