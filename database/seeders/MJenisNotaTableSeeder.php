<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MJenisNotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_jenis_nota')->truncate();

        DB::table('m_jenis_nota')->insert([
            [
                'm_jenis_nota_nama' => 'Nota A Uluwatu',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Teuku Umar',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Tukad Barito',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Batu Bulan',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Gatot Subroto',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Bawean',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Bekasi',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Bintaro 1',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Bintaro 2',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Bogor Yasmin',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Bogor Ahmad Yani',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A BSD',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Citra Raya',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Depok',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Depok Sawangan ',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Gading Serpong ',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Greenvile ',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Karawaci',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Kisamaun 1 ',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Kisamaun 2',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Agricola',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Palem Semi',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Taman Sari ',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Tanjung Duren Utara ',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Tasikmalaya',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Arjuna Raya',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ],
            [
                'm_jenis_nota_nama' => 'Nota A Rungkut ',
                'm_jenis_nota_group' => 'Nota A',
                'm_jenis_nota_created_by' => 1
            ]
        ]);
    }


    //     DB::table('m_jenis_nota')->truncate();
    //     $jenisnota = ['Nota A','Nota B'];

    //     foreach ($jenisnota as $key => $value) {
    //         DB::table('m_jenis_nota')->insert([
    //             'm_jenis_nota_nama' => $value,
    //             'm_jenis_nota_group'=>
    //             'm_jenis_nota_created_by'=> 1,
    //         ]);
    //     }
    // }
}
