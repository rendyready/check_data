<table>
    <thead>
        <tr>
            <th rowspan="2">Area</th>
            <th rowspan="2">Waroeng</th>
            <th rowspan="2">Name</th>
            <th rowspan="2">Sesi</th>
            <th rowspan="2">Tanggal</th>
            <th rowspan="2">Jam</th>
            <th rowspan="2">Nota Code</th>
            <th rowspan="2">Big Boss</th>
            <th rowspan="2">Produk Nama</th>
            <th colspan="5">Biaya</th>
        </tr>
        <tr>
            <th>Qty</th>
            <th>Price</th>
            <th>Nominal Pajak</th>
            <th>Nominal SC</th>
            <th>Total</th>
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
