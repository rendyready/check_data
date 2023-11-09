<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_has_roles')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('roles')->insert([
            [
                'name' => 'administrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manager',
                'guard_name' => 'web',
            ],
            [
                'name' => 'general-user',
                'guard_name' => 'web',
            ],
            [
                'name' => 'pgd',
                'guard_name' => 'web',
            ],
            [
                'name' => 'produksi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kacab',
                'guard_name' => 'web',
            ],
            [
                'name' => 'keuangan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasir',
                'guard_name' => 'web',
            ]
        ]);
        DB::table('users')->insert(
            [
                [
                    'users_id' => 1,
                    'name' => 'administrator',
                    'email' => 'administrator@email.com',
                    'password' => Hash::make('IT@kinanthi'),
                    'waroeng_id' => 1,
                    'waroeng_akses' => "[1,2,3,4,5,9,10]"
                ],
                [
                    'users_id' => 2,
                    'name' => 'admin',
                    'email' => 'admin@email.com',
                    'password' => Hash::make('password'),
                    'waroeng_id' => 35,
                    'waroeng_akses' => "[1,2,3,35]"
                ],
                [
                    'users_id' => 3,
                    'name' => 'awan',
                    'email' => 'awan@waroengss.com',
                    'password' => Hash::make('supply'),
                    'waroeng_id' => 3,
                    'waroeng_akses' => "[1,3,4]"
                ],
               ]
        );
        User::where('name', 'administrator')->first()->assignRole('administrator');
        User::where('name', 'admin')->first()->assignRole('admin');
        User::where('name', 'awan')->first()->assignRole('pgd');
    }
}
