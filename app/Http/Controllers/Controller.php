<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use PDO;
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
            $nextId = $currentId + 1;
        }

        return $nextId;
    }

    public function getNextId($table, $waroengId)
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
        $waroengInfo = DB::table('m_w')->where('m_w_id', $waroengId)->first();
        #cek Last ID
        $counter = DB::table('app_id_counter')
            ->where([
                'app_id_counter_m_w_id' => $waroengId,
                'app_id_counter_table' => $table,
            ]);

        if (!empty($counter->first())) {
            if ($counter->first()->app_id_counter_date == Carbon::now()->format('Y-m-d')) {
                $nextCounter = $counter->first()->app_id_counter_value + 1;
                $counter->update([
                    'app_id_counter_value' => $nextCounter,
                ]);
                // $id = $waroengId.Auth::user()->users_id.$date.$nextCounter;
            } else {
                $nextCounter = 1;
                $counter->update([
                    'app_id_counter_value' => $nextCounter,
                    'app_id_counter_date' => Carbon::now()->format('Y-m-d'),
                ]);
                // $id = $waroengId.Auth::user()->users_id.$date.$nextCounter;
            }
        } else {
            $nextCounter = 1;
            DB::table('app_id_counter')
                ->insert([
                    'app_id_counter_m_w_id' => $waroengId,
                    'app_id_counter_table' => $table,
                    'app_id_counter_value' => $nextCounter,
                    'app_id_counter_date' => Carbon::now()->format('Y-m-d'),
                ]);
            // $id = $waroengId.Auth::user()->users_id.$date.$nextCounter;
        }
        $id = $waroengId . "." . $waroengInfo->m_w_m_area_id . "." . Auth::user()->users_id . "." . $date . "." . $nextCounter;
        return strtoupper($prefix) . "." . $id;
    }
    public function getNamaW($id)
    {
        return $waroeng = DB::table('m_w')->where('m_w_id', $id)->first()->m_w_nama;
    }
    public function getAreaMw($id_waroeng) {
        $area = DB::table('m_w')->join('m_area','m_area_id','m_w_m_area_id')
        ->where('m_w_id',$id_waroeng)->first();
        return $area;
    }
    public function get_last_stok($g_id, $p_id)
    {
        $stok = DB::table('m_stok')
            ->where('m_stok_gudang_code', $g_id)
            ->where('m_stok_m_produk_code', $p_id)
            ->first();
        return $stok;
    }
    public function get_m_w_nama()
    {
        $waroeng_aktif = Auth::user()->waroeng_id;
        $waroeng_nama = DB::table('m_w')->where('m_w_id', $waroeng_aktif)
            ->first()->m_w_nama;
        return $waroeng_nama;
    }
    public function get_akses_area()
    {
        return $akses_area = [1, 2, 3, 4, 5, 6, 27, 36, 52, 70, 83, 101, 110, 116];
    }
    public function get_akses_pusar()
    {
        return $akses_pusat = [6, 27, 36, 52, 70, 83, 101, 110, 116];
    }
    public function get_akses_pusat()
    {
        return $akses_pusat = [1, 2, 3, 4, 5];
    }
    public function get_produk($id)
    {
        return DB::table('m_produk')->where('m_produk_code', $id)->first();
    }

    public function coba()
    {
        // return JangkrikHelper::convertTarget([21,13]);
        // return DB::select('select list_waroeng()');
        DB::table('m_area')->where('m_area_id', '10')
            ->update([
                // 'm_area_client_target' => DB::raw('(select list_waroeng())')
                'm_area_client_target' => DB::raw('DEFAULT'),
                // 'm_area_client_target' => JangkrikHelper::convertTarget([21,13])
            ]);
        return "ok";
    }

    public function non_menu()
    {
        $rekap = DB::table('rekap_transaksi_detail')
            ->selectRaw('
                        rekap_modal_id,
                        MAX(r_t_m_area_id) m_area_id,
                        MAX(r_t_m_area_nama) m_area_nama,
                        r_t_m_w_id m_w_id,
                        MAX(r_t_m_w_nama) m_w_nama,
                        MAX(r_t_tanggal) tanggal,
                        MAX(rekap_modal_sesi) sesi,
                        MAX(name) kasir,
                        MAX(r_t_m_t_t_id) type_id,
                        MAX(m_t_t_name) type_name,
                        r_t_detail_m_produk_id m_produk_id,
                        MAX(r_t_detail_m_produk_nama) m_produk_nama,
                        SUM(r_t_detail_reguler_price*r_t_detail_qty) nominal,
                        SUM(r_t_detail_nominal_pajak) pajak
                    ')
            ->join('rekap_transaksi', 'r_t_detail_r_t_id', 'r_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->join('users', 'users_id', 'rekap_modal_created_by')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->where(DB::raw('DATE(rekap_modal_tanggal)'), '2023-06-11')
            ->where('r_t_m_area_id', '5')
        // ->where('r_t_m_w_id', '54')
            ->where('r_t_detail_status', 'paid')
            ->groupBy('rekap_modal_id', 'r_t_detail_m_produk_id', 'r_t_m_w_id', 'm_t_t_id')
            ->orderBy('tanggal', 'asc')
            ->orderBy('m_w_nama', 'asc')
            ->orderBy('sesi', 'asc')
            ->get();

        $countNota = DB::table('rekap_transaksi')
            ->selectRaw('r_t_m_t_t_id type_id, r_t_rekap_modal_id modal_id, COUNT(r_t_id) jml')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->where(DB::raw('DATE(rekap_modal_tanggal)'), '2023-06-11')
            ->where('r_t_m_area_id', '5')
            ->where('r_t_status', 'paid')
            ->groupBy('r_t_rekap_modal_id', 'r_t_m_t_t_id')
            ->get();

        $countNotaArray = [];
        foreach ($countNota as $keyNot => $valNot) {
            $countNotaArray[$valNot->type_id . "-" . $valNot->modal_id] = $valNot->jml;
        }

        $getMenu = DB::table('m_produk')
            ->select('m_produk_id')
            ->whereNotIn('m_produk_m_jenis_produk_id', [9, 11, 12, 13])->get();

        $listMenu = [];
        foreach ($getMenu as $key => $valMenu) {
            array_push($listMenu, $valMenu->m_produk_id);
        }

        $getNonMenu = DB::table('m_produk')
            ->select('m_produk_id')
            ->whereIn('m_produk_m_jenis_produk_id', [9, 11])->get();
        $listNonMenu = [];
        foreach ($getNonMenu as $key => $valMenu) {
            array_push($listNonMenu, $valMenu->m_produk_id);
        }

        $arrayListRekap = [];
        foreach ($rekap as $keyRekap => $valRekap) {
            array_push($arrayListRekap, $valRekap->rekap_modal_id);
        }

        $listRekap = array_unique($arrayListRekap);

        $getIceCream = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [20, 22, 23, 24, 25])->get();
        $listIceCream = [];
        foreach ($getIceCream as $key => $valMenu) {
            array_push($listIceCream, $valMenu->m_produk_id);
        }
        $getMineral = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [12])->get();
        $listMineral = [];
        foreach ($getMineral as $key => $valMenu) {
            array_push($listMineral, $valMenu->m_produk_id);
        }

        $getKerupuk = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [47])->get();
        $listKerupuk = [];
        foreach ($getKerupuk as $key => $valMenu) {
            array_push($listKerupuk, $valMenu->m_produk_id);
        }

        $getKbd = DB::table('m_produk')
            ->select('m_produk_id')
            ->whereIn('m_produk_m_jenis_produk_id', [11])->get();
        $listKbd = [];
        foreach ($getKbd as $key => $valMenu) {
            array_push($listKbd, $valMenu->m_produk_id);
        }

        $getWbdFrozen = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [45])->get();
        $listWbdFrozen = [];
        foreach ($getWbdFrozen as $key => $valMenu) {
            array_push($listWbdFrozen, $valMenu->m_produk_id);
        }

        #List of transaction type
        $tipe = ['dine in', 'take away', 'grab', 'gojek', 'shopeefood'];

        $data = [];
        foreach ($listRekap as $keyListRekap => $valListRekap) {
            ${$valListRekap . '-icecream'} = 0;
            ${$valListRekap . '-mineral'} = 0;
            ${$valListRekap . '-krupuk'} = 0;
            ${$valListRekap . '-wbdbb'} = 0;
            ${$valListRekap . '-wbdfrozen'} = 0;
            ${$valListRekap . '-pajakreguler'} = 0;
            ${$valListRekap . '-pajakojol'} = 0;

            foreach ($tipe as $keyTipe => $valTipe) {
                ${$valListRekap . '-' . $valTipe . '-menu'} = 0;
                ${$valListRekap . '-' . $valTipe . '-nonmenu'} = 0;
                ${$valListRekap . '-' . $valTipe . '-jmlnota'} = 0;

                foreach ($rekap as $keyRekap => $valRekap) {
                    if ($valRekap->rekap_modal_id == $valListRekap) {
                        $data[$valListRekap]['area'] = $valRekap->m_area_nama;
                        $data[$valListRekap]['waroeng'] = $valRekap->m_w_nama;
                        $data[$valListRekap]['tanggal'] = date('d-m-Y', strtotime($valRekap->tanggal));
                        $data[$valListRekap]['sesi'] = $valRekap->sesi;
                        $data[$valListRekap]['operator'] = $valRekap->kasir;
                        if ($valRekap->type_name == $valTipe) {
                            if (in_array($valRekap->m_produk_id, $listMenu)) {
                                ${$valListRekap . '-' . $valTipe . '-menu'} += $valRekap->nominal;
                            }
                            if (in_array($valRekap->m_produk_id, $listNonMenu)) {
                                ${$valListRekap . '-' . $valTipe . '-nonmenu'} += $valRekap->nominal;
                            }

                            if (isset($countNotaArray[$valRekap->type_id . '-' . $valListRekap])) {
                                ${$valListRekap . '-' . $valTipe . '-jmlnota'} = $countNotaArray[$valRekap->type_id . '-' . $valListRekap];
                            }

                            $data[$valListRekap][$valTipe . '-menu'] = ${$valListRekap . '-' . $valTipe . '-menu'};
                            $data[$valListRekap][$valTipe . '-nonmenu'] = ${$valListRekap . '-' . $valTipe . '-nonmenu'};
                            $data[$valListRekap][$valTipe . '-jmlnota'] = ${$valRekap->rekap_modal_id . '-' . $valTipe . '-jmlnota'};
                        }
                    }
                }
            }
            foreach ($rekap as $keyRekap => $valRekap) {
                if ($valRekap->rekap_modal_id == $valListRekap) {
                    if (in_array($valRekap->m_produk_id, $listIceCream)) {
                        ${$valListRekap . '-icecream'} += $valRekap->nominal;
                    }
                    $data[$valListRekap]['icecream'] = ${$valListRekap . '-icecream'};

                    if (in_array($valRekap->m_produk_id, $listMineral)) {
                        ${$valListRekap . '-mineral'} += $valRekap->nominal;
                    }
                    $data[$valListRekap]['mineral'] = ${$valListRekap . '-mineral'};

                    if (in_array($valRekap->m_produk_id, $listKerupuk)) {
                        ${$valListRekap . '-krupuk'} += $valRekap->nominal;
                    }
                    $data[$valListRekap]['krupuk'] = ${$valListRekap . '-krupuk'};

                    if (in_array($valRekap->m_produk_id, $listKbd)) {
                        ${$valListRekap . '-wbdbb'} += $valRekap->nominal;
                    }
                    $data[$valListRekap]['wbdbb'] = ${$valListRekap . '-wbdbb'};

                    if (in_array($valRekap->m_produk_id, $listWbdFrozen)) {
                        ${$valListRekap . '-wbdfrozen'} += $valRekap->nominal;
                    }
                    $data[$valListRekap]['wbdfrozen'] = ${$valListRekap . '-wbdfrozen'};

                    if (in_array($valRekap->type_name, ['dine in', 'take away'])) {
                        ${$valListRekap . '-pajakreguler'} += $valRekap->pajak;
                    } else {
                        $nominalPajak = $valRekap->nominal * 0.10;
                        ${$valListRekap . '-pajakojol'} += $nominalPajak;
                    }
                    $data[$valListRekap]['pajakreguler'] = ${$valListRekap . '-pajakreguler'};
                    $data[$valListRekap]['pajakojol'] = ${$valListRekap . '-pajakojol'};
                }
            }
        }

        return response($data);
    }

    public function upload_file($request)
    {   
        if ($request->hasFile('m_produk_image')) {
            $image = $request->file('m_produk_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $directory = public_path('uploads');
            $path = $directory . '/' . $filename;

            // Create the directory if it doesn't exist
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }
            $image->move($directory, $filename);
            // Open and resize the image while maintaining the aspect ratio
            $img = Image::make($path);
            $img->fit(200, 200, function ($constraint) {
                $constraint->upsize(); 
            });
            $img->save($path);

            return 'uploads/' . $filename;
        }
    }

    public function remove_file($directory)
    {
        $path = public_path($directory);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    public function uploadImageCloud($url)
    {
        #Send Image to public server
        $img = url($url);
        $folder = 'produk';

        $image = fopen($img, 'r');
        $upload = Http::withHeaders([
            'accept' => 'application/json',
            'X-Authorization' => 'aD1UnchysFUfRHMqi61TWiZT7gjAFNAmnDrjkUFvVgrXIJplWasWvylDuZismZnO',
        ])
            ->withoutVerifying()
            ->attach('image', $image)
            ->post('https://struk.pedasabis.com/api/upload-image', [
                "folder" => $folder,
            ])->body();
        return $upload;
    }

    public function deleteImageCloud($urlImage)
    {
        #delete image from cloud storage
        $delete = Http::withHeaders([
            'accept' => 'application/json',
            'X-Authorization' => 'aD1UnchysFUfRHMqi61TWiZT7gjAFNAmnDrjkUFvVgrXIJplWasWvylDuZismZnO',
        ])
            ->post('https://struk.pedasabis.com/api/delete-image', [
                "url" => $urlImage,
            ]);
        return response($delete, 200);
    }

    function connect_qr(){
        Config::set("database.connections.qronline", [
            'driver' => 'pgsql',
            'host' => '45.76.144.207',
            'port' => '5432',
            'database' => 'admindb_qrorder',
            'username' => 'admindb_qrorder',
            'password' => 'Qr.Waroeng@55',
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
            'options' => [
                PDO::ATTR_TIMEOUT => 3, // Timeout dalam detik
            ],
        ]);
        $db_qr = DB::connection('qronline');

        try {
            $db_qr->table('m_w')->get();
            return $db_qr;
        } catch (\Throwable $th) {
            Log::info($th);
            return response()->json(["messages" => "Can't Connect Database Order"]);
        }
    }
}
