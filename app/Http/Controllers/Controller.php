<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getNextId($table)
    {
        // $data = DB::select("select nextval('{$table}_id_seq');")[0]->nextval;
        // $data = DB::select("SELECT MAX(id) FROM users;")[0]->max;
        $data = Carbon::now()->format('ymd');

        return response($data);
    }
}
