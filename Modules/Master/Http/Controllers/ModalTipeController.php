<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MModalTipe;
class ModalTipeController extends Controller
{
    public function index()
    {
        $data = new \stdClass();
        $data->m_modal_tipe = MModalTipe::with('m_modal_tipe')->whereNull('m_modal_tipe_deleted_at')->get();
        return view('master::modal_tipe',compact('data'));
    }
}
