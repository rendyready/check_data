<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
}
