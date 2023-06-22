<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MJenisProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use illuminate\Support\Str;

class MJenisMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =
        DB::table('m_jenis_produk')->select('m_jenis_produk_id', 'm_jenis_produk_nama', 'm_jenis_produk_odcr55', 'm_jenis_produk_urut')->whereNull('m_jenis_produk_deleted_at')->orderBy('m_jenis_produk_id', 'asc')->get();
        return view('master::jenis_menu', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    {
        $count = MJenisProduk::max('m_jenis_produk_id');
        $val = [
            'm_jenis_produk_nama' => Str::lower($request->m_jenis_produk_nama),
        ];
        $raw = [
            'm_jenis_produk_nama' => ['required', 'unique:m_jenis_produk', 'max:255'],
        ];

        if ($request->ajax()) {
            if ($request->action == 'add') {
                $validate = Validator::make($val, $raw);
                if ($validate->fails()) {
                    return response(['Messages' => 'Data Duplidate']);
                } else {
                    $data = array(
                        'm_jenis_produk_id' => $this->getMasterId('m_jenis_produk'),
                        'm_jenis_produk_nama' => Str::lower($request->m_jenis_produk_nama),
                        'm_jenis_produk_odcr55' => $request->m_jenis_produk_odcr55,
                        'm_jenis_produk_urut' => $count + 1,
                        'm_jenis_produk_created_by' => Auth::user()->users_id,
                        'm_jenis_produk_created_at' => Carbon::now(),
                    );
                    DB::table('m_jenis_produk')->insert($data);
                    return response(['Messages' => 'Berhasil Menambah', 'type' => 'success']);
                }
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_jenis_produk_nama' => $request->m_jenis_produk_nama,
                    'm_jenis_produk_odcr55' => $request->m_jenis_produk_odcr55,
                    'm_jenis_produk_status_sync' => 'send',
                    'm_jenis_produk_client_target' => DB::raw('DEFAULT'),
                    'm_jenis_produk_updated_by' => Auth::user()->users_id,
                    'm_jenis_produk_updated_at' => Carbon::now(),
                );
                DB::table('m_jenis_produk')->where('m_jenis_produk_id', $request->id)
                    ->update($data);
                return response(['Messages' => 'Data Updated !', 'type' => 'success']);
            } else {
                $softdelete = array('m_jenis_produk_deleted_at' => Carbon::now());
                DB::table('m_jenis_produk')
                    ->where('m_jenis_produk_id', $request->id)
                    ->update($softdelete);
            }
            return response(['Success' => true]);
        }
    }

    public function sort(Request $request)
    {
        $tasks = MJenisProduk::all(); // Really All Data Collect !

        foreach ($tasks as $task) {
            $task->timestamps = false; // To disable update_at field updation
            $id = $task->m_jenis_produk_id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->update(['m_jenis_produk_urut' => $order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
    }
}
