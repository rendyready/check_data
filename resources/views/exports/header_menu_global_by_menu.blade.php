<table>
    <thead>
        <tr>
            <th class="text-center">Kategori</th>
            <th class="text-center">Menu</th>
            <th class="text-center">Jumlah Penjualan (pcs)</th>
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
