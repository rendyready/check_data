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
                'm_jenis_nota_m_w_id'=>1,
                'm_jenis_nota_m_t_t_id' =>1,
                'm_jenis_nota_created_by' => 1
            ],  [
                'm_jenis_nota_m_w_id'=>2,
                'm_jenis_nota_m_t_t_id' => 2,
                'm_jenis_nota_created_by' => 1
            ],  [
                'm_jenis_nota_m_w_id'=>3,
                'm_jenis_nota_m_t_t_id' => 3,
                'm_jenis_nota_created_by' => 1
            ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Batu Bulan',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Gatot Subroto',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Bawean',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Bekasi',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Bintaro 1',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Bintaro 2',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Bogor Yasmin',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Bogor Ahmad Yani',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A BSD',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Citra Raya',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Depok',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Depok Sawangan ',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Gading Serpong ',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Greenvile ',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Karawaci',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Kisamaun 1 ',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Kisamaun 2',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Agricola',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Palem Semi',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Taman Sari ',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Tanjung Duren Utara ',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Tasikmalaya',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Arjuna Raya',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Rungkut ',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Ambar Ketawang',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Bantul',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Banyudono',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Banyumanik',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Bawen ',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Herritage ',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Boyolali Perintis',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Cilacap',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Ampera',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Tuparev',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Concat Barat',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Concat Timur',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Jakal 8',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Gedong Kuning',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Gonilan',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Jakal 12',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Jember',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Jurug',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Karanganyar',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Kediri',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            
            // [
            //     'm_jenis_nota_nama' => 'Nota B Kerten',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Klaten Sekarsuli',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Kledokan',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Kopral Sayom',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Kudus',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Kulon Progo',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Kupatan',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Kyai Mojo ',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Lampersari ',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Madiun',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Magelang',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Perumnas',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Ciliwung',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B La Sucipto',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Sengkaling',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Manahan Barat',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Manahan Timur',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Megatruh',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Monjali',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Muntilan',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Ngaliyan',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Palagan',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Palemsemi',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Pandega',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Pati',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Pattimura',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Pekalongan',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Plengkung Gading',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Prambanan',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Puri Anjasmoro',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B  GOR Satria',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Wiryatmaja',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            
            // [
            //     'm_jenis_nota_nama' => 'Nota B Salatiga Diponegoro',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Salatiga Sudirman',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Sambiroto',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Samirono',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Sampangan',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Sewon',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Solo Baru',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Sompok',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Sragen',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Tegal',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Temanggung',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Tembalang',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Ungaran',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Veteran',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Wonogiri',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Wonosari',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Wonosobo',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota A Jatinangor',
            //     'm_jenis_nota_group' => 'Nota A',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Tekim',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Klodran',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Exspress Megatruh',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],
            // [
            //     'm_jenis_nota_nama' => 'Nota B Perjuangan',
            //     'm_jenis_nota_group' => 'Nota B',
            //     'm_jenis_nota_created_by' => 1
            // ],

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
