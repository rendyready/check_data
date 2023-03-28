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
            font-size: 9pt;
        }

        .table {
            width: 100%;
            text-align: center;
            border: none;
            border-color: transparent;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
    <center>
        <h4>LAPORAN PENJUALAN MENU</h4>
        <h5>{{ $w_nama }}</h5>
        <h6>{{ $tgl }}</h6>
        <h6>Kasir : {{strtoupper($kasir)}}</h6>
        <h6>Sesi : {{$shift}}</h6>
    </center>

    <table id="detail_modal" class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover">
        <thead>
            <tr>
                <th class="text-center">Tanggal</th>
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
                <tr>
                    <td>{{ $item['tanggal'] }}</td>
                    <td>{{ $item['no_nota'] }}</td>
                    <td>{{ $item['transaksi'] }}</td>
                    <td>{{ $item['masuk'] }}</td>
                    <td>{{ $item['keluar'] }}</td>
                    <td>{{ $item['saldo'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="table-responsive">
        <table class="table table-sm table-borderless">
            <tr>
                <td>Menyetujui,</td>
                <td>Mengetahui,</td>
                <td>Melaporkan,</td>
            </tr>
            <tr>
                <td>Kepala Cabang</td>
                <td>Asisten Keuangan</td>
                <td>Kasir</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>(......................)</td>
                <td>(......................)</td>
                <td>({{$kasir}})</td>
            </tr>
        </table>
    </div>
</body>
</html>
