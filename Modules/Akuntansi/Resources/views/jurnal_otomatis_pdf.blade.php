<!DOCTYPE html>
<html>

<head>
    <title>Jurnal Penjualan</title>
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
        <h6 style="font-size: 12pt">JURNAL PENJUALAN</h6>
        <h6 style="font-size: 10pt">{{ $w_nama }}</h6>
        <h6 style="font-size: 10pt">{{ $tgl }}</h6>
    </center><br>
    {{-- <h6 style="font-size: 10pt">Jurnal</h6> --}}
    <table id="detail_modal" class="table table-sm table-striped table-border table-vcenter nowrap table-hover">
        <thead>
            <tr>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Akun</th>
                <th class="text-center">Debit</th>
                <th class="text-center">Kredit</th>
            </tr>
        </thead>
        <tbody>
            {{-- @dump($data) --}}
            @foreach ($data as $item)
            {{-- @if (in_array($item['payment'], [1])) --}}
                <tr>
                    <td>{{ $item['tanggal'] }}</td>
                    <td>{{ $item['akun'] }}</td>
                    <td>{{ $item['debit'] }}</td>
                    <td>{{ $item['kredit'] }}</td>
                </tr>
            {{-- @endif --}}
            @endforeach
        </tbody>
    </table>

    {{-- <div style="width: 100%; height: 250px; border: 1px solid black;" class="mb-2">
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
    </div> --}}
</body>

</html>
