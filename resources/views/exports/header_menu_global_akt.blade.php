@if ($mark == 'Export By Area')
    <table>
        <thead>
            <tr>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Area</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Kategori</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Menu</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Qty</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Harga</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td class="text-center">{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@elseif ($mark == 'Export By Waroeng')
    <table>
        <thead>
            <tr>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Area</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Waroeng</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Kategori</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Menu</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Qty</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Harga</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td class="text-center">{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@elseif ($mark == 'Export By Tanggal')
    <table>
        <thead>
            <tr>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Area</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Waroeng</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Tanggal</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Transaksi</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Kategori</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Menu</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Qty</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Harga</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td class="text-center">{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@elseif ($mark == 'Export Excel')
    <table>
        <thead>
            <tr>
                <th class="text-center" style="text-align: center; vertical-align: middle;" rowspan="2">Waroeng</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;" rowspan="2">Transaksi
                </th>
                <th class="text-center" style="text-align: center; vertical-align: middle;" rowspan="2">Kategori</th>
                <th class="text-center" style="text-align: center; vertical-align: middle;" rowspan="2">Menu</th>
                @foreach ($tanggal as $tgl)
                    <th class="text-center" style="text-align: center; vertical-align: middle;" colspan="2">
                        {{ date('d-m-Y', strtotime($tgl)) }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($tanggal as $tgl)
                    <th class="text-center" style="text-align: center; vertical-align: middle;">Qty</th>
                    <th class="text-center" style="text-align: center; vertical-align: middle;">Harga</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td class="text-center">{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
@endif
