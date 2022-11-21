<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class PinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_pin')->insert([
            'm_pin_value' => Crypt::encryptString('rahasia'),
            'm_pin_type' => 'Dashboard',
            'm_pin_status' => '1',
            'm_pin_created_by'=> 1,
        ]);
    }
}
