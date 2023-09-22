@if ($mark == 'Export By Area')
    <table>
        <thead>
            <tr>
                <th class="text-center">Area</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Menu</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Jumlah</th>
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
                <th class="text-center">Area</th>
                <th class="text-center">Waroeng</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Menu</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Jumlah</th>
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
                <th class="text-center">Area</th>
                <th class="text-center">Waroeng</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Menu</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Jumlah</th>
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
@endif
