<table>
    <thead>
        <tr>
            <th rowspan="2" class="text-center">Area</th>
            <th rowspan="2" class="text-center">Waroeng</th>
            <th rowspan="2" class="text-center">Tanggal</th>
            <th colspan="2" class="text-center">Selisih Penjualan</th>
            <th rowspan="2" class="text-center">Pembulatan</th>
            <th rowspan="2" class="text-center">Free Kembalian</th>
        </tr>
        <tr>
            <th rowspan="1" class="text-center">Selisih Lebih</th>
            <th rowspan="1" class="text-center">Selisih Kurang</th>
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
