<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // View::composer('layouts.app', function ($view) {
        //     $view->with('waroeng',$this->get_m_w_nama());
        // });
        // View::addNamespace('auth', resource_path('views/auth'));
    }
    // public function get_m_w_nama()
    // {
    //     $waroeng_aktif = Auth::user()->waroeng_id;
    //     $waroeng_nama = DB::table('m_w')->where('m_w_id',$waroeng_aktif)
    //     ->first()->m_w_nama;
    //     return $waroeng_nama;
    // }
}