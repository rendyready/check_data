<!DOCTYPE html>
<html>

<head>
    <title>Laporan Harian Kas Kasir</title>
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-css/bootstrap.min.css') }}">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 8pt;
            padding: 0 !important;
            margin: 0 !important;
        }
        .table {
            width: 100%;
            text-align: center;
            border: none;
            border-color: transparent;
        }
        .table-border th,td{
            border: 1px solid black;
        color: black;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
    <center>
        <h6 style="font-size: 12pt">LAPORAN KAS HARIAN KASIR</h6>
        <h6 style="font-size: 10pt">{{ $w_nama }}</h6>
        <h6 style="font-size: 10pt">{{ $tgl }}</h6>
        <h6 style="font-size: 10pt">Kasir : {{ strtoupper($kasir) }} (Sesi : {{ $shift }})</h6>
    </center><br>
    <h6 style="font-size: 10pt">Rekap Kas</h6>
    <table id="detail_modal" class="table table-sm table-striped table-border table-vcenter nowrap table-hover">
        <thead>
            <tr>
                <th class="text-center">No Nota</th>
                <th class="text-center">Transaksi</th>
                <th class="text-center">Masuk</th>
                <th class="text-center">Keluar</th>
                <th class="text-center">Saldo</th>
            </tr>
        </thead>
        <tbody>
            {{-- @dump($data) --}}
            @foreach ($data as $item)
            @if (in_array($item['payment'], [1]))
                <tr>
                    <td>{{ $item['no_nota'] }}</td>
                    <td>{{ $item['transaksi'] }}</td>
                    <td>{{ $item['masuk'] }}</td>
                    <td>{{ $item['keluar'] }}</td>
                    <td>{{ $item['saldo'] }}</td>
                </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <h6 style="font-size: 10pt">Laporan Kas</h6>
    <table id="detail_modal" class="table table-sm table-striped table-border table-vcenter nowrap table-hover">
        <thead>
            <tr>
                <th class="text-center">Saldo Awal</th>
                <th class="text-center">Pemasukan</th>
                <th class="text-center">Pengeluaran</th>
                <th class="text-center">Saldo Akhir</th>
                <th class="text-center">Selisih</th>
            </tr>
        </thead>
        <tbody>
            {{-- @dump($data) --}}
            @foreach ($data as $item)
            @if (in_array($item['payment'], [22]))
                <tr>
                    <td>{{ $item['no_nota'] }}</td>
                    <td>{{ $item['transaksi'] }}</td>
                    <td>{{ $item['masuk'] }}</td>
                    <td>{{ $item['keluar'] }}</td>
                    <td>{{ $item['saldo'] }}</td>
                </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <div style="width: 100%; height: 250px; border: 1px solid black;" class="mb-2">
        <p class="ml-2" style="font-size: 14px">Catatan : </p>
      </div>
    <div class="table-responsive">
        <table class="table table-sm table-borderless">
            <tr>
                <td style="width: 30%">Menyetujui,</td>
                <td style="width: 40%">Mengetahui,</td>
                <td style="width: 30%">Melaporkan,</td>
            </tr>
            <tr>
                <td>Kepala Cabang</td>
                <td>Asisten Keuangan</td>
                <td>Kasir</td>
            </tr>
            <tr>
                <td style="padding: 2.2rem!important"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>(......................)</td>
                <td>(......................)</td>
                <td>({{ $kasir }})</td>
            </tr>
        </table>
    </div><br><br>
    <h6 style="font-size: 10pt">Rekap Transfer</h6>
    <table id="detail_modal" class="table table-sm table-striped table-border table-vcenter nowrap table-hover">
        <thead>
            <tr>
                <th class="text-center">No Nota</th>
                <th class="text-center">Transaksi</th>
                <th class="text-center">Masuk</th>
                <th class="text-center">Keluar</th>
                <th class="text-center">Saldo</th>
            </tr>
        </thead>
        <tbody>
            {{-- @dump($data) --}}
            @foreach ($data as $item)
            @if (in_array($item['payment'], [2,3,4,5,6,7,8,9]))
                <tr>
                    <td>{{ $item['no_nota'] }}</td>
                    <td>{{ $item['transaksi'] }}</td>
                    <td>{{ $item['masuk'] }}</td>
                    <td>{{ $item['keluar'] }}</td>
                    <td>{{ $item['saldo'] }}</td>
                </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    <div style="width: 100%; height: 250px; border: 1px solid black;" class="mb-2">
        <p class="ml-2" style="font-size: 14px">Catatan : </p>
      </div>
    <div class="table-responsive">
        <table class="table table-sm table-borderless">
            <tr>
                <td style="width: 30%">Menyetujui,</td>
                <td style="width: 40%">Mengetahui,</td>
                <td style="width: 30%">Melaporkan,</td>
            </tr>
            <tr>
                <td>Kepala Cabang</td>
                <td>Asisten Keuangan</td>
                <td>Kasir</td>
            </tr>
            <tr>
                <td style="padding: 2.2rem!important"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>(......................)</td>
                <td>(......................)</td>
                <td>({{ $kasir }})</td>
            </tr>
        </table>
    </div>
</body>

</html>
