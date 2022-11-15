<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
            UserTableSeeder::class,
            AreaTableSeeder::class,
            MJenisMenuTableSeeder::class,
            SubJenisMenuTableSeeder::class,
            ModalTipeTableSeeder::class,
            JenisMejaTableSeeder::class,
            WjenisTableSeeder::class
       ]);
    }
}
