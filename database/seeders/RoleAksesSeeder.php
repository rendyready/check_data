<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;
class RoleAksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'asisten opp',
                'guard_name' => 'web',
            ],
            [
                'name' => 'asisten pengadaan - gudang',
                'guard_name' => 'web',
            ],
            [
                'name' => 'asisten produksi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'general manajer',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasi akuntansi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasi it',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasi keuangan area',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasi keuangan pusat',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasi lemdir',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasi operasi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasi opp',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasi pgd',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasi produksi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasi sdm',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kaur akuntansi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kaur it',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kaur keuangan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kaur opp',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kaur pgd',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kaur produksi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kaur sdm',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kaur wbd',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manajer akuntansi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manajer keuangan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manajer operasi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'patroli tradisi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'puk',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf akuntansi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf keuangan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf it',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf khusus gm',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf khusus manajer',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf manajemen',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf opp',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf sdm',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf umum',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf waroeng',
                'guard_name' => 'web',
            ],
            [
                'name' => 'staf wbd',
                'guard_name' => 'web',
            ],
            [
                'name' => 'wakil direktur',
                'guard_name' => 'web',
            ]
        ]);
    }
}
