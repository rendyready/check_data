<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FormatExcel implements FromView, WithHeadingRow, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.header_selisih_penjualan', [
            'data' => $this->data,
        ]);
    }
}

class RekapSelisihPenjualanExport implements FromView, WithHeadingRow
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $download = new FormatExcel($this->data);
        return $download->view();
    }
}
