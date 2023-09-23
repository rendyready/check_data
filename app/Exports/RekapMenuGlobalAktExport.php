<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// class FormatExcel implements FromView, WithHeadingRow, ShouldAutoSize
// {
//     protected $data;

//     public function __construct(array $data)
//     {
//         $this->data = $data;
//     }

//     public function view(): View
//     {
//         return view('exports.header_menu_global_akt', [
//             'data' => $this->data,
//         ]);
//     }
// }

// class RekapMenuGlobalAktExport implements FromView, WithHeadingRow
// {
//     protected $data;

//     public function __construct(array $data)
//     {
//         $this->data = $data;
//     }

//     public function view(): View
//     {
//         $download = new FormatExcel($this->data);
//         return $download->view();
//     }
// }

class RekapMenuGlobalAktExport implements FromView, WithHeadingRow
{
    protected $data;
    protected $mark;
    protected $tanggal;

    public function __construct(array $data, $mark, $tanggal = null)
    {
        $this->data = $data;
        $this->mark = $mark;
        $this->tanggal = $tanggal;
    }

    public function view(): View
    {
        $download = new FormatExcel($this->data, $this->mark, $this->tanggal);
        return $download->view();
    }
}

class FormatExcel implements FromView, WithHeadingRow, ShouldAutoSize
{
    protected $data;
    protected $mark;
    protected $tanggal;

    public function __construct(array $data, $mark, $tanggal = null)
    {
        $this->data = $data;
        $this->mark = $mark; // Menyimpan nilai $mark
        $this->tanggal = $tanggal;
    }

    public function view(): View
    {
        return view('exports.header_menu_global_akt', [
            'data' => $this->data,
            'mark' => $this->mark, // Mengirim $mark ke tampilan Blade
            'tanggal' => $this->tanggal,
        ]);
    }
}
