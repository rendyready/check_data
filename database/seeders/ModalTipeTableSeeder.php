<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ModalTipeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_modal_tipe')->truncate();
        DB::table('m_modal_tipe')->insert([
            [
                'm_modal_tipe_nama' => 'IDR',
                'm_modal_tipe_parent_id' => Null,
                'm_modal_tipe_nominal'=> Null ,
                'm_modal_tipe_urut'=> Null ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'MYR',
                'm_modal_tipe_parent_id' => Null,
                'm_modal_tipe_nominal'=> Null ,
                'm_modal_tipe_urut'=> Null ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'Rp.',
                'm_modal_tipe_parent_id' => 1,
                'm_modal_tipe_nominal'=> Null ,
                'm_modal_tipe_urut'=> Null ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'RM',
                'm_modal_tipe_parent_id' => 2,
                'm_modal_tipe_nominal'=> Null ,
                'm_modal_tipe_urut'=> Null ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'SEN',
                'm_modal_tipe_parent_id' => 2,
                'm_modal_tipe_nominal'=> Null ,
                'm_modal_tipe_urut'=> Null ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'Rp. 100',
                'm_modal_tipe_parent_id' => 3,
                'm_modal_tipe_nominal'=> 100.00 ,
                'm_modal_tipe_urut'=> 100.00,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'Rp. 200',
                'm_modal_tipe_parent_id' => 3,
                'm_modal_tipe_nominal'=> 200.00 ,
                'm_modal_tipe_urut'=> 200.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'Rp .500',
                'm_modal_tipe_parent_id' => 3,
                'm_modal_tipe_nominal'=> 500.00 ,
                'm_modal_tipe_urut'=> 500.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'Rp. 1,000',
                'm_modal_tipe_parent_id' => 3,
                'm_modal_tipe_nominal'=> 1000.00 ,
                'm_modal_tipe_urut'=> 1000.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],  
            [
                'm_modal_tipe_nama' => 'Rp 2,000',
                'm_modal_tipe_parent_id' => 3,
                'm_modal_tipe_nominal'=> 2000.00 ,
                'm_modal_tipe_urut'=> 2000.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'Rp. 5,000',
                'm_modal_tipe_parent_id' => 3,
                'm_modal_tipe_nominal'=> 5000.00 ,
                'm_modal_tipe_urut'=> 5000.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'Rp. 10,000',
                'm_modal_tipe_parent_id' => 3,
                'm_modal_tipe_nominal'=> 10000.00 ,
                'm_modal_tipe_urut'=> 10000.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'Rp. 20,000',
                'm_modal_tipe_parent_id' => 3,
                'm_modal_tipe_nominal'=> 20000.00 ,
                'm_modal_tipe_urut'=> 20000.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'Rp 50,000',
                'm_modal_tipe_parent_id' => 3,
                'm_modal_tipe_nominal'=> 50000.00 ,
                'm_modal_tipe_urut'=> 50000.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'Rp 100,000',
                'm_modal_tipe_parent_id' => 3,
                'm_modal_tipe_nominal'=> 100000.00 ,
                'm_modal_tipe_urut'=> 100000.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'RM 100',
                'm_modal_tipe_parent_id' => 4,
                'm_modal_tipe_nominal'=> 100.00 ,
                'm_modal_tipe_urut'=> 100.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'RM 50',
                'm_modal_tipe_parent_id' => 4,
                'm_modal_tipe_nominal'=> 50.00 ,
                'm_modal_tipe_urut'=> 50.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'RM 20',
                'm_modal_tipe_parent_id' => 4,
                'm_modal_tipe_nominal'=> 20.00 ,
                'm_modal_tipe_urut'=> 20.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'RM 10',
                'm_modal_tipe_parent_id' => 4,
                'm_modal_tipe_nominal'=> 10.00 ,
                'm_modal_tipe_urut'=> 10.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'RM 5',
                'm_modal_tipe_parent_id' => 4,
                'm_modal_tipe_nominal'=> 5.00 ,
                'm_modal_tipe_urut'=> 5.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'RM 2',
                'm_modal_tipe_parent_id' => 4,
                'm_modal_tipe_nominal'=> 2.00 ,
                'm_modal_tipe_urut'=> 2.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'RM 1',
                'm_modal_tipe_parent_id' => 4,
                'm_modal_tipe_nominal'=> 4.00 ,
                'm_modal_tipe_urut'=> 4.00 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'SEN 50',
                'm_modal_tipe_parent_id' => 5,
                'm_modal_tipe_nominal'=> 50.00 ,
                'm_modal_tipe_urut'=> 0.50 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'SEN 20',
                'm_modal_tipe_parent_id' => 5,
                'm_modal_tipe_nominal'=> 20.00 ,
                'm_modal_tipe_urut'=> 0.20 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'SEN 10',
                'm_modal_tipe_parent_id' => 5,
                'm_modal_tipe_nominal'=> 10.00 ,
                'm_modal_tipe_urut'=> 0.10 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'SEN 5',
                'm_modal_tipe_parent_id' => 5,
                'm_modal_tipe_nominal'=> 5.00 ,
                'm_modal_tipe_urut'=> 0.50 ,    
                'm_modal_tipe_created_by' => 1,
            ],
            [
                'm_modal_tipe_nama' => 'SEN 1',
                'm_modal_tipe_parent_id' => 5,
                'm_modal_tipe_nominal'=> 1.00 ,
                'm_modal_tipe_urut'=> 0.10 ,    
                'm_modal_tipe_created_by' => 1,
            ]
        ]);
    }
}
