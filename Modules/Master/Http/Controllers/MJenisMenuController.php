<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MJenisProduk;
use Carbon\Carbon;
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
        if ($request->ajax()) {
            $check = Str::upper($request->m_jenis_produk_nama);
            $checkData = DB::table('m_jenis_produk')->whereRaw("UPPER(m_jenis_produk_nama)='{$check}'")->first();
            if (!empty($request->validate($checkData->m_jenis_nama_produk))) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_jenis_produk_nama' => $request->m_jenis_produk_nama,
                        'm_jenis_produk_odcr55' => $request->m_jenis_produk_odcr55,
                        'm_jenis_produk_urut' => $count + 1,
                        'm_jenis_produk_created_by' => Auth::id(),
                        'm_jenis_produk_created_at' => Carbon::now(),
                    );
                    DB::table('m_jenis_produk')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_jenis_produk_nama' => $request->m_jenis_produk_nama,
                        'm_jenis_produk_odcr55' => $request->m_jenis_produk_odcr55,
                        'm_jenis_produk_updated_by' => Auth::id(),
                        'm_jenis_produk_updated_at' => Carbon::now(),
                    );
                    DB::table('m_jenis_produk')->where('m_jenis_produk_id', $request->id)
                        ->update($data);
                } else {
                    $softdelete = array('m_jenis_produk_deleted_at' => Carbon::now());
                    DB::table('m_jenis_produk')
                        ->where('m_jenis_produk_id', $request->id)
                        ->update($softdelete);
                }
            } else {
                return 'Duplicate';
            }
            return response()->json($request);
        }
    }
    public function sort(Request $request)
    {
        $tasks = MJenisProduk::all();

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
