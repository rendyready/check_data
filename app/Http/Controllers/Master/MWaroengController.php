<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MWaroengController extends Controller
{
    public function index()
    {
        return view('master.m_waroeng');
    }
}
