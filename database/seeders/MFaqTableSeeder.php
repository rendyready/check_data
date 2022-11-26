<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MFaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_faq')->truncate();

        DB::table('m_faq')->insert([
            [
                'm_faq_judul' =>'Cara update ODCR55 V.1.3 ke ODCR55 V.3',
                'm_faq_deskripsi' =>'Untuk mengosongkan kembali database jalankan perintah php artisan migrate:fresh dan fetch ulang data
                Buka file .env, lalu Ganti APP_PRODUCTION=false menjadi APP_PRODUCTION=true,kemudian ganti APP_CLOUD menjadi APP_CLOUD=https://sipedas.waroengss.com
                selanjutnya ,ganti APP_CLOUD_HP menjadi APP_CLOUD_HP=sipedas.waroengss.com
                php artisan config:clear',
                'm_faq_tag'=>'update cr55,upgrade,cr55 v.3,update',
                'm_faq_created_by'=>1,
            ], 
        ]);
    }
}