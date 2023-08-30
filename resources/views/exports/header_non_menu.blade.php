<table>
    <thead>
        <tr>
            <th rowspan="2" class="text-center">Area</th>
            <th rowspan="2" class="text-center">Waroeng</th>
            <th rowspan="2" class="text-center">Tanggal</th>
            <th rowspan="2" class="text-center">Sesi</th>
            <th rowspan="2" class="text-center">Operator</th>
            <th colspan="3" class="text-center">Dine In</th>
            <th colspan="3" class="text-center">Take Away</th>
            <th colspan="3" class="text-center">Grab</th>
            <th colspan="3" class="text-center">Gojek</th>
            <th colspan="3" class="text-center">Shopee</th>
            <th colspan="3" class="text-center">Grab Mart</th>
            <th colspan="5" class="text-center">Rincian</th>
            <th rowspan="2" class="text-center">Pajak Reguler</th>
            <th rowspan="2" class="text-center">Pajak Ojol</th>
        </tr>
        <tr>
            <th rowspan="1" class="text-center">Menu</th>
            <th rowspan="1" class="text-center">Non Menu</th>
            <th rowspan="1" class="text-center">Nota</th>

            <th rowspan="1" class="text-center">Menu</th>
            <th rowspan="1" class="text-center">Non Menu</th>
            <th rowspan="1" class="text-center">Nota</th>

            <th rowspan="1" class="text-center">Menu</th>
            <th rowspan="1" class="text-center">Non Menu</th>
            <th rowspan="1" class="text-center">Nota</th>

            <th rowspan="1" class="text-center">Menu</th>
            <th rowspan="1" class="text-center">Non Menu</th>
            <th rowspan="1" class="text-center">Nota</th>

            <th rowspan="1" class="text-center">Menu</th>
            <th rowspan="1" class="text-center">Non Menu</th>
            <th rowspan="1" class="text-center">Nota</th>

            <th rowspan="1" class="text-center">WBD BB</th>
            <th rowspan="1" class="text-center">WBD Frozen</th>
            <th rowspan="1" class="text-center">Nota</th>

            <th rowspan="1" class="text-center">Es Cream</th>
            <th rowspan="1" class="text-center">Air Mineral</th>
            <th rowspan="1" class="text-center">Kerupuk</th>
            <th rowspan="1" class="text-center">WBD BB</th>
            <th rowspan="1" class="text-center">WBD Frozen</th>
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
