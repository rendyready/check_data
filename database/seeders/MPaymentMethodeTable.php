<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MPaymentMethodeTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_payment_method')->truncate();

        DB::table('m_payment_method')->insert([
            [
                'm_payment_method_id' => '1',
                'm_payment_method_type' => 'cash',
                'm_payment_method_name' => 'cash',
                'm_payment_method_color' => '#B7C4CF',
                'm_payment_method_created_by' => 1
            ],
            [
                'm_payment_method_id' => '2',
                'm_payment_method_type' => 'transfer',
                'm_payment_method_name' => 'mandiri',
                'm_payment_method_color' => '#002B5B',
                'm_payment_method_created_by' => 1
            ],
            [
                'm_payment_method_id' => '3',
                'm_payment_method_type' => 'transfer',
                'm_payment_method_name' => 'bni',
                'm_payment_method_color' => '#FFC23C',
                'm_payment_method_created_by' => 1
            ],
            [
                'm_payment_method_id' => '4',
                'm_payment_method_type' => 'transfer',
                'm_payment_method_name' => 'bri',
                'm_payment_method_color' => '#277BC0',
                'm_payment_method_created_by' => 1
            ],
            [
                'm_payment_method_id' => '5',
                'm_payment_method_type' => 'transfer',
                'm_payment_method_name' => 'bca',
                'm_payment_method_color' => '#31087B',
                'm_payment_method_created_by' => 1
            ],
            [
                'm_payment_method_id' => '6',
                'm_payment_method_type' => 'transfer',
                'm_payment_method_name' => 'gopay',
                'm_payment_method_color' => '#5A8F7B',
                'm_payment_method_created_by' => 1
            ],
            [
                'm_payment_method_id' => '7',
                'm_payment_method_type' => 'transfer',
                'm_payment_method_name' => 'ovo',
                'm_payment_method_color' => '#7A4495',
                'm_payment_method_created_by' => 1
            ],
            [
                'm_payment_method_id' => '8',
                'm_payment_method_type' => 'transfer',
                'm_payment_method_name' => 'shopeepay',
                'm_payment_method_color' => '#D1512D',
                'm_payment_method_created_by' => 1
            ],
            [
                'm_payment_method_id' => '9',
                'm_payment_method_type' => 'transfer',
                'm_payment_method_name' => 'qris',
                'm_payment_method_color' => '#C21010',
                'm_payment_method_created_by' => 1
            ],
        ]);
    }
}
