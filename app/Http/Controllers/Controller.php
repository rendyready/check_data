<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMasterId($table)
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

    public function getNextId($table,$waroengId)
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

        $date = Carbon::now()->format('ymd');
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
                $id = $waroengId.Auth::user()->users_id.$date.$nextCounter;
            }else{
                $nextCounter = 1;
                $counter->update([
                    'app_id_counter_value' => $nextCounter,
                    'app_id_counter_date' => Carbon::now()->format('Y-m-d')
                ]);
                $id = $waroengId.Auth::user()->users_id.$date.$nextCounter;
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
            $id = $waroengId.Auth::user()->users_id.$date.$nextCounter;
        }
        
        return strtoupper($prefix).$id;
    }
    public function getNamaW($id)
    {   
        return $waroeng = DB::table('m_w')->where('m_w_code',$id)->first()->m_w_nama;
    }
    public function get_last_stok($g_id,$p_id)
    {
        $stok = DB::table('m_stok')
                ->where('m_stok_gudang_code',$g_id)
                ->where('m_stok_m_produk_code',$p_id)
                ->first();
        return $stok;
    }
    public function get_m_w_nama()
    {
        $waroeng_aktif = Auth::user()->waroeng_id;
        $waroeng_nama = DB::table('m_w')->where('m_w_id',$waroeng_aktif)
        ->first()->m_w_nama;
        return $waroeng_nama;
    }
}
