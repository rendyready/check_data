@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Form Input Barang Rusak
                    </div>
                    <div class="block-content text-muted">
                        <form action="{{ route('rusak.simpan') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm"
                                            for="rekap_rusak_created_by">Operator</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_rusak_created_by" name="rekap_rusak_created_by"
                                                value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>
                                    {{-- <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Pukul</label>
                            <div class="col-sm-8">
                                <h3 id="time">13:00</h3>
                            </div>
                        </div> --}}
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label" for="rekap_rusak_code">No Bukti</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="rekap_rusak_code"
                                                name="rekap_rusak_code" value="{{ $data->code }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label" for="rekap_rusak_tgl">Tanggal</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control form-control-sm" id="rekap_rusak_tgl"
                                                name="rekap_rusak_tgl" value="{{ $data->tgl_now }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label-sm" for="rekap_rusak">User Waroeng</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_rusak_m_w_nama" name="rekap_rusak_m_w_nama"
                                                value="{{ $waroeng_nama->m_w_nama }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label" for="rekap_rusak">Gudang</label>
                                        <div class="col-sm-7">
                                            <select class="js-select2 gudang_code" name="m_gudang_code" id="m_gudang_code"
                                                style="width: 100%;"data-placeholder="Pilih Gudang" required>
                                                <option></option>
                                                @foreach ($data->gudang as $item)
                                                    <option value="{{ $item->m_gudang_code }}">
                                                        {{ ucwords($item->m_gudang_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                                    <thead>
                                        <th>Nama Barang</th>
                                        <th>Keterangan</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Harga@</th>
                                        <th>Sub Harga</th>
                                        <th><button type="button" class="btn tambah btn-success"><i
                                                    class="fa fa-plus"></i></button></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><select class="js-select2 nama_barang"
                                                    name="rekap_rusak_detail_m_produk_id[]"
                                                    id="rekap_rusak_detail_m_produk_id1"
                                                    style="width: 100%;"data-placeholder="Pilih Nama Barang" required>
                                                    <option></option>
                                                </select></td>
                                            <td>
                                                <textarea class="form-control form-control-sm reset" name="rekap_rusak_detail_catatan[]" id="rekap_rusak_detail_catatan"
                                                    cols="50" required placeholder="keterangan rusak"></textarea>
                                            </td>
                                            <td><input type="text" class="form-control reset number form-control-sm qty"
                                                    name="rekap_rusak_detail_qty[]" id="rekap_rusak_detail_qty1" required>
                                            </td>
                                            <td><input type="text" class="form-control reset form-control-sm satuan"
                                                    id="satuan1" readonly></td>
                                            <td><input type="text" class="form-control number form-control-sm hpp"
                                                    name="rekap_rusak_detail_hpp[]" id="rekap_rusak_detail_hpp1" readonly>
                                            </td>
                                            <td><input type="text" class="form-control number form-control-sm subtotal"
                                                    name="rekap_rusak_detail_sub_total[]" id="rekap_rusak_detail_sub_total"
                                                    readonly></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <th>Nama Barang</th>
                                        <th>Keterangan</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Harga@</th>
                                        <th>Sub Harga</th>
                                        <th><button type="button" class="btn tambah btn-success"><i
                                                    class="fa fa-plus"></i></button></th>
                                    </tfoot>
                                </table>
                                <div class="block-content block-content-full text-end bg-transparent">
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <h4>Rekap Rusak Harian</h4>
                        <div class="table-responsive">
                            <table id="tb_rusak"
                                class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                                <thead>
                                    <th>Jam Input</th>
                                    <th>No Bukti</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Satuan</th>
                                    <th>Operator</th>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th>Jam Input</th>
                                    <th>No Bukti</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Satuan</th>
                                    <th>Operator</th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });
            Codebase.helpersOnLoad(['jq-select2']);
            var no = 2;
            var datas;
            $('#m_gudang_code').on('change', function() {
                var asal = $(this).val();
                Swal.fire({
                    title: 'Apakah Anda Yakin ?',
                    text: "Hasil Input Akan Hilang Jika Anda Berganti Gudang Tanpa Menyimpanya",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Berhasil',
                            'Gudang Telah Berganti.',
                            'success'
                        )
                        $('#rekap_rusak_detail_m_produk_id1').empty();
                        $('#rekap_rusak_detail_m_produk_id1').append('<option></option>');
                        $('.remove').remove();
                        $('.reset').val('');
                        $('.qty').trigger('input');
                        $.get("/inventori/stok/" + asal, function(data) {
                            datas = data;
                            $.get("/inventori/stok/" + asal, function(data) {
                                datas = data;
                                $.each(data, function(key, value) {
                                    $('#rekap_rusak_detail_m_produk_id1')
                                        .append($('<option>', {
                                                value: key
                                            })
                                            .text(value));
                                });
                            });
                        });
                        $(function() {
                            table = $('#tb_keluar').DataTable({
                                "destroy": true,
                                "orderCellsTop": true,
                                "processing": true,
                                "autoWidth": true,
                                "lengthMenu": [
                                    [10, 25, 50, 100, -1],
                                    [10, 25, 50, 100, "All"]
                                ],
                                "pageLength": 10,
                                "ajax": {
                                    "url": "out_hist/" + asal,
                                    "type": "GET"
                                }
                            });
                        });

                    }
                });
            });
            $('.tambah').on('click', function() {
                no++;
                $('#form').append('<tr id="row' + no + '" class="remove">' +
                    '<td><select class="js-select2 nama_barang" name="rekap_rusak_detail_m_produk_id[]" id="rekap_rusak_detail_m_produk_id' +
                    no +
                    '" style="width: 100%;" data-placeholder="Pilih Nama Barang" required><option></option></select></td>' +
                    '<td><textarea class="form-control form-control-sm reset" name="rekap_rusak_detail_catatan[]" id="rekap_rusak_detail_catatan" cols="50" required placeholder="keterangan rusak"></textarea></td>' +
                    '<td><input type="text" class="form-control number form-control-sm reset qty" name="rekap_rusak_detail_qty[]" id="rekap_rusak_detail_qty" required></td>' +
                    '<td><input type="text" class="form-control reset form-control-sm reset satuan" id="satuan' +
                    no + '" readonly></td>' +
                    '<td><input type="text" class="form-control number form-control-sm hpp" name="rekap_rusak_detail_hpp[]" id="rekap_rusak_detail_hpp' +
                    no + '" readonly></td>' +
                    '<td><input type="text" class="form-control number form-control-sm subtotal" name="rekap_rusak_detail_sub_total[]" id="rekap_rusak_detail_sub_total" readonly></td>' +
                    '<td><button type="button" id="' + no +
                    '" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>'
                );
                Codebase.helpersOnLoad(['jq-select2']);
                $.each(datas, function(key, value) {
                    $('#rekap_rusak_detail_m_produk_id' + no)
                        .append($('<option>', {
                                value: key
                            })
                            .text(value));
                });

            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                var $tblrows = $("#form");
                $tblrows.find('.qty').trigger('input');
            });
            $("#form, .qty, .harga").on('input', function() {
                var $tblrows = $("#form tbody tr");
                $tblrows.each(function(index) {
                    var $tblrow = $(this);
                    $tblrow.find(".qty, .harga").on('input', function() {
                        var qty = $tblrow.find("[name='rekap_rusak_detail_qty[]']").val()
                            .replace(/\./g, '').replace(/\,/g, '.');
                        var price = $tblrow.find("[name='rekap_rusak_detail_hpp[]']").val();
                        var subTotal = parseFloat(qty) * parseFloat(price);
                        if (!isNaN(subTotal)) {
                            $tblrow.find('.subtotal').val(subTotal.toFixed(2));
                            var grandTotal = 0;
                            $(".subtotal").each(function() {
                                var stval = parseFloat($(this).val());
                                grandTotal += isNaN(stval) ? 0 : stval;
                            });
                        }
                    });
                });
            });


        });
    </script>
@endsection
