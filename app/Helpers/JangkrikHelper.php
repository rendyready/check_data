<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Illuminate\Encryption\Encrypter;
class JangkrikHelper
{
    public static function getMasterId($table)
    {
        #Work Fine jangkrik500
        #GET Next and SET ID Increment
        // $data = DB::select("select nextval('{$table}_id_seq');")[0]->nextval;

        #Get Last Increment Used
        $maxId = DB::select("SELECT MAX(id) FROM {$table};")[0]->max;

        #GET Current Increment of table (Recomended method)
        $currentId = DB::select("SELECT last_value FROM {$table}_id_seq;")[0]->last_value;
        $nextId = $currentId;
        if (!empty($maxId) && $currentId >= 1) {
            if ($maxId != $currentId) {
                DB::select("SELECT setval('{$table}_id_seq', {$maxId});");
                $currentId = $maxId;
            }
            $nextId = $currentId+1;
        }

        return $nextId;
    }

    public static function getNextIdCron($table,$waroengId,$user_id)
    {
        #Get Last Increment Used
        $maxId = DB::select("SELECT MAX(id) FROM {$table};")[0]->max;

        #GET Current Increment of table (Recomended method)
        $currentId = DB::select("SELECT last_value FROM {$table}_id_seq;")[0]->last_value;

        if (!empty($maxId) && $currentId >= 1) {
            if ($maxId != $currentId) {
                DB::select("SELECT setval('{$table}_id_seq', {$maxId});");
            }
        }

        $words = explode("_", $table);
        $prefix = "";

        foreach ($words as $w) {
            $prefix .= mb_substr($w, 0, 1);
        }

        $date = Carbon::now()->format('ymdHis');
        $waroengInfo = DB::table('m_w')->where('m_w_id',$waroengId)->first();
        #cek Last ID
        $counter = DB::table('app_id_counter')
                ->where([
                    'app_id_counter_m_w_id' => $waroengId,
                    'app_id_counter_table' => $table
                ]);

        if (!empty($counter->first())) {
            if ($counter->first()->app_id_counter_date == Carbon::now()->format('Y-m-d')) {
                $nextCounter = $counter->first()->app_id_counter_value+1;
                $counter->update([
                    'app_id_counter_value' => $nextCounter
                ]);
                // $id = $waroengId.Auth::user()->users_id.$date.$nextCounter;
            }else{
                $nextCounter = 1;
                $counter->update([
                    'app_id_counter_value' => $nextCounter,
                    'app_id_counter_date' => Carbon::now()->format('Y-m-d')
                ]);
                // $id = $waroengId.Auth::user()->users_id.$date.$nextCounter;
            }
        }else{
            $nextCounter = 1;
            DB::table('app_id_counter')
                ->insert([
                    'app_id_counter_m_w_id' => $waroengId,
                    'app_id_counter_table' => $table,
                    'app_id_counter_value' => $nextCounter,
                    'app_id_counter_date' => Carbon::now()->format('Y-m-d')
                ]);
            // $id = $waroengId.Auth::user()->users_id.$date.$nextCounter;
        }
        $id = $waroengId.".".$waroengInfo->m_w_m_area_id.".".$user_id.".".$date.".".$nextCounter;
        return strtoupper($prefix).".".$id;
    }
    public static function get_last_stok($g_id,$p_id)
    {
        $stok = DB::table('m_stok')
                ->where('m_stok_gudang_code',$g_id)
                ->where('m_stok_m_produk_code',$p_id)
                ->first();
        return $stok;
    }

    public static function convertTarget($target)
    {
        $data = '';
        foreach ($target as $keyT => $valT) {
            $data .= ':'.$valT.':';
            // array_push($data,':'.$valT.':');
        }

        return $data;
    }

    public static function customCrypt($vWord){
        $jangkrikKey = base64_decode("CccMZ15qMHXk47PEnC/lCk3Woq2rpjmxahQIFUZ3tMI=");
        $newEncrypter = new Encrypter($jangkrikKey,Config::get('app.cipher'));
        return $newEncrypter->encrypt($vWord);
    }

    public static function customDecrypt($vWord){
        $jangkrikKey = base64_decode("CccMZ15qMHXk47PEnC/lCk3Woq2rpjmxahQIFUZ3tMI=");
        $newEncrypter = new Encrypter($jangkrikKey,Config::get('app.cipher') );
        return $newEncrypter->decrypt($vWord);
    }
}
