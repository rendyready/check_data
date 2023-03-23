@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            FORM PENJUALAN GUDANG INTERNAL
                    </div>
                    <div class="block-content text-muted">
                        <form id="formAction">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-labdistributorel-sm"
                                            for="rekap_beli_created_by">Operator</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_beli_created_by" name="rekap_beli_created_by"
                                                value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="example-hf-text">Distibutor</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="distributor"
                                                name="distributor" value="{{ $data->waroeng_nama->m_w_nama }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label-sm" for="rekap_beli_code">No Nota</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm" id="rekap_beli_code"
                                                name="rekap_beli_code" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label-sm" for="rekap_beli_tgl">Tanggal</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control form-control-sm"
                                                value="{{ $data->tgl_now }}" readonly id="rekap_beli_tgl"
                                                name="rekap_beli_tgl" required>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label-sm" for="rekap_beli_jth_tmp">Jth Tempo</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control form-control-sm"
                                                value="{{ $data->tgl_now }}" id="rekap_beli_jth_tmp"
                                                name="rekap_beli_jth_tmp" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label-sm" for="asal_gudang">Sumber
                                            Gudang</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 gudang_code form-control-sm" style="width: 100%;"
                                                name="asal_gudang" id="asal_gudang" data-placeholder="Pilih Gudang"
                                                required>
                                                <option></option>
                                                @foreach ($data->gudang as $item)
                                                    <option value="{{ $item->m_gudang_code }}">
                                                        {{ ucwords($item->m_gudang_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label-sm" for="nama_gudang">Jenis Penjualan</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 form-control-sm" style="width: 100%;"
                                                name="nama_gudang" id="nama_gudang" data-placeholder="Pilih Jenis Penjualan"
                                                required>
                                                <option></option>
                                                <option value="gudang utama waroeng">Waroeng</option>
                                                <option value="gudang wbd waroeng">WDB</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label-sm" for="waroeng_tujuan">Tujuan</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 form-control-sm" style="width: 100%;"
                                                name="waroeng_tujuan" id="waroeng_tujuan" data-placeholder="Pilih Customer"
                                                required>
                                                <option></option>
                                                @foreach ($data->waroeng as $item)
                                                    <option value="{{ $item->m_w_id }}">{{ ucwords($item->m_w_nama) }}
                                                    </option>
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
                                        <th>Catatan</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Disc %</th>
                                        <th>Disc Rp</th>
                                        <th>Sub Harga</th>
                                        <th><button type="button" class="btn tambah btn-success"><i
                                                    class="fa fa-plus"></i></button></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><select class="js-select2 fc nama_barang"
                                                    name="rekap_beli_detail_m_produk_id[]"
                                                    id="rekap_beli_detail_m_produk_id1" style="width: 100%;"
                                                    data-placeholder="Pilih Nama Barang" required>
                                                    <option value="0" selected disabled hidden>Pilih Nama Produk
                                                    </option>
                                                </select></td>
                                            <td>
                                                <textarea class="form-control fc reset form-control-sm" name="rekap_beli_detail_catatan[]"
                                                    id="rekap_beli_detail_catatan" cols="50" required placeholder="catatan bb atau satuan"></textarea>
                                            </td>
                                            <td><input type="text"
                                                    class="form-control number fc reset form-control-sm qty"
                                                    name="rekap_beli_detail_qty[]" id="rekap_beli_detail_qty" required>
                                                <span class="stok" id="stok1"></span>
                                            </td>
                                            <td><input type="text"
                                                    class="form-control reset hpp number form-control-sm harga"
                                                    name="rekap_beli_detail_harga[]" id="rekap_beli_detail_harga1"
                                                    readonly></td>
                                            <td><input type="text"
                                                    class="form-control number form-control-sm persendisc"
                                                    name="rekap_beli_detail_disc[]" id="rekap_beli_detail_disc"></td>
                                            <td><input type="text"
                                                    class="form-control number form-control-sm rupiahdisc"
                                                    name="rekap_beli_detail_discrp[]" id="rekap_beli_detail_discrp"></td>
                                            <td><input type="text" class="form-control number form-control-sm subtot"
                                                    name="rekap_beli_detail_subtot[]" id="rekap_beli_detail_subtot"
                                                    readonly></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <th>Nama Barang</th>
                                        <th>Catatan</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Disc %</th>
                                        <th>Disc Rp</th>
                                        <th>Sub Harga</th>
                                        <th><button type="button" class="btn tambah btn-success"><i
                                                    class="fa fa-plus"></i></button></th>
                                    </tfoot>
                                </table>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Total <span id="total_sum_value"></span></h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="rekap_beli_tot_no_ppn">Jumlah
                                                Total</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm grdtot"
                                                    id="rekap_beli_tot_no_ppn" name="rekap_beli_tot_no_ppn" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-3 col-form-label" for="rekap_beli_disc">Diskon</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control number form-control-sm disc_tot"
                                                    id="rekap_beli_disc" name="rekap_beli_disc" placeholder="%">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text"
                                                    class="form-control number form-control-sm disc_tot_rp"
                                                    id="rekap_beli_disc_rp" name="rekap_beli_disc_rp" placeholder="Rp">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-3 col-form-label" for="rekap_beli_ppn">PPN</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control number form-control-sm ppn"
                                                    id="rekap_beli_ppn" name="rekap_beli_ppn" placeholder="%">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control number form-control-sm ppnrp"
                                                    id="rekap_beli_ppn_rp" name="rekap_beli_ppn_rp" placeholder="Rp"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="rekap_beli_ongkir">Ongkos
                                                Kirim</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm number ongkir"
                                                    id="rekap_beli_ongkir" name="rekap_beli_ongkir">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="rekap_beli_tot_nom">Jumlah
                                                Akhir</label>
                                            <div class="col-sm-6">
                                                <input type="text"
                                                    class="form-control number form-control-sm rekap_beli_tot_nom"
                                                    id="rekap_beli_tot_nom" name="rekap_beli_tot_nom" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label"
                                                for="rekap_beli_terbayar">Dibayar</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control number form-control-sm bayar"
                                                    id="rekap_beli_terbayar" name="rekap_beli_terbayar" value="0">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="rekap_beli_tersisa">Sisa</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm sisa"
                                                    id="rekap_beli_tersisa" name="rekap_beli_tersisa" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content block-content-full text-end bg-transparent">
                                    <input type="submit" class="btn btn-sm btn-success btn-save">
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="tb_keluar"
                                class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                                <thead>
                                    <th>No</th>
                                    <th>No Bukti</th>
                                    <th>Total</th>
                                    <th>Tujuan</th>
                                    <th>Operator</th>
                                    <th>Jam Input</th>
                                    <th>Detail</th>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th>No</th>
                                    <th>No Bukti</th>
                                    <th>Total</th>
                                    <th>Tujuan</th>
                                    <th>Operator</th>
                                    <th>Jam Input</th>
                                    <th>Detail</th>
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
        function get_code() {
            $.get("/inventori/beli/code/", function(data) {
                $('#rekap_beli_code').val(data);
            });
        }
        $(document).ready(function() {
            get_code();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });
            var datas, asal, table;
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
                        "url": "{{ route('hist_penj_g.index') }}",
                        "type": "GET"
                    }
                });
            });
            Codebase.helpersOnLoad(['jq-select2']);
            $('#asal_gudang').on('change', function() {
                var asal = $('#asal_gudang').val();
                console.log($('.fc').serialize().length);
                if ($('.fc').serialize().length > 98) {
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
                            $('#rekap_beli_detail_m_produk_id1').empty();
                            $('#rekap_beli_detail_m_produk_id1').append('<option></option>');
                            var asal = $(this).val()
                            $.get("/inventori/stok/" + asal, function(data) {
                                datas = data;
                                $.each(data, function(key, value) {
                                    $('#rekap_beli_detail_m_produk_id1')
                                        .append($('<option>', {
                                                value: key
                                            })
                                            .text(value));
                                });
                            });
                            $('.remove').remove();
                            $('.reset').trigger('changer').val('');
                        }
                    });
                } else {
                    var asal = $(this).val()
                    $('#rekap_beli_detail_m_produk_id1').empty();
                    $('#rekap_beli_detail_m_produk_id1').append('<option></option>');
                    $.get("/inventori/stok/" + asal, function(data) {
                        datas = data;
                        $.each(data, function(key, value) {
                            $('#rekap_beli_detail_m_produk_id1')
                                .append($('<option>', {
                                        value: key
                                    })
                                    .text(value));
                        });
                    });
                }
            });
            var no = 1;
            $('.tambah').on('click', function() {
                no++;
                $('#form').append('<tr id="row' + no + '" class="remove">' +
                    '<td><select class="js-select2 nama_barang" name="rekap_beli_detail_m_produk_id[]" id="rekap_beli_detail_m_produk_id' +
                    no +
                    '" style="width: 100%;" data-placeholder="Pilih Nama Barang" required > <option value="0" selected disabled hidden></option></select></td>' +
                    '<td><textarea class="form-control form-control-sm" name="rekap_beli_detail_catatan[]" id="rekap_beli_detail_catatan" cols="50" required placeholder="catatan bb atau satuan"></textarea></td>' +
                    '<td><input type="text" class="form-control number form-control-sm qty" name="rekap_beli_detail_qty[]" id="rekap_beli_detail_qty" required><span class="stok" id="stok' +
                    no + '"></span></td>' +
                    '<td><input type="text" class="form-control number form-control-sm hpp harga" name="rekap_beli_detail_harga[]" id="rekap_beli_detail_harga' +
                    no + '" required></td>' +
                    '<td><input type="text" class="form-control number form-control-sm persendisc" name="rekap_beli_detail_disc[]" id="rekap_beli_detail_disc"></td>' +
                    '<td><input type="text" class="form-control number form-control-sm rupiahdisc" name="rekap_beli_detail_discrp[]" id="rekap_beli_detail_discrp"></td>' +
                    '<td><input type="text" class="form-control number form-control-sm subtot" name="rekap_beli_detail_subtot[]" id="rekap_beli_detail_subtot" readonly></td>' +
                    '<td><button type="button" id="' + no +
                    '" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>'
                    );
                Codebase.helpersOnLoad(['jq-select2']);
                $.each(datas, function(key, value) {
                    $('#rekap_beli_detail_m_produk_id' + no)
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
                $tblrows.find('.persendisc').trigger('input');
            });
            $("#form, .qty, .harga, .persendisc, .rupiahdisc, .disc_tot, .disc_tot_rp, .ppn, .ongkir, .bayar").on(
                'input',
                function() {
                    var $tblrows = $("#form tbody tr");
                    $tblrows.each(function(index) {
                        var $tblrow = $(this);
                        $tblrow.find(".qty, .harga, .persendisc, .rupiahdisc").on('input', function() {
                            var qty = $tblrow.find("[name='rekap_beli_detail_qty[]']").val()
                                .replace(/\./g, '').replace(/\,/g, '.');
                            var price = $tblrow.find("[name='rekap_beli_detail_harga[]']").val()
                                .replace(/\./g, '').replace(/\,/g, '.');
                            var persendisc = $tblrow.find("[name='rekap_beli_detail_disc[]']")
                                .val();
                            var nilaipersendisc = 100 - persendisc;
                            var rupiahdisc = $tblrow.find("[name='rekap_beli_detail_discrp[]']")
                                .val().replace(/\./g, '').replace(/\,/g, '.');
                            if (rupiahdisc == null) {
                                rupiahdisc = 0;
                            }
                            var subTotal = parseFloat(qty) * parseFloat(price) * (
                                nilaipersendisc / 100) - rupiahdisc;
                            if (!isNaN(subTotal)) {
                                $tblrow.find('.subtot').val(subTotal.toLocaleString("id"));
                                var grandTotal = 0;
                                $(".subtot").each(function() {
                                    var stval = parseFloat($(this).val().replace(/\./g,
                                        '').replace(/\,/g, '.'));
                                    grandTotal += isNaN(stval) ? 0 : stval;
                                });
                                $('.grdtot').val(grandTotal.toLocaleString('id'));
                            }
                        });
                    });
                    var grdtot = 0;
                    $(".subtot").each(function() {
                        var stval = parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.'));
                        grdtot += isNaN(stval) ? 0 : stval;
                    });
                    var disc_tot = $("[name='rekap_beli_disc']").val();
                    var disctotrp = $("[name='rekap_beli_disc_rp']").val().replace(/\./g, '').replace(/\,/g,
                        '.');
                    var ppn = $("[name='rekap_beli_ppn']").val();
                    var bayar = $("[name='rekap_beli_terbayar']").val().replace(/\./g, '').replace(/\,/g, '.');
                    var ongkir = $("[name='rekap_beli_ongkir']").val().replace(/\./g, '').replace(/\,/g, '.');
                    if (ongkir === "") {
                        var ongkir = 0;
                    }
                    var grandtotal = grdtot * parseFloat((100 - disc_tot) / 100) - disctotrp;
                    var ppnrp = parseFloat(ppn / 100) * grandtotal;
                    var rekap_beli_tot_nom = parseFloat(grandtotal) + parseFloat(ppnrp) + parseFloat(ongkir);
                    $('.ppnrp').val(ppnrp);
                    $('.rekap_beli_tot_nom').val(rekap_beli_tot_nom.toLocaleString('id'));
                    $('.sisa').val((rekap_beli_tot_nom - bayar).toLocaleString('id'));
                    $('#total_sum_value').html(': Rp ' + rekap_beli_tot_nom.toLocaleString('id'));

                });
            $('#formAction').submit(function(e) {
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: "{{ route('simpan.penj_gudang') }}",
                        type: "POST",
                        data: $('form').serialize(),
                        success: function(data) {
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: 'success', // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: 'Input Penjualan Berhasil'
                            });
                            table.ajax.reload();
                            $('.remove').remove();
                            $('#rekap_beli_detail_m_produk_id1,.reset').trigger('change').val(
                                '');
                            $('#formAction').find('.persendisc').trigger('input');
                            get_code();
                        },
                        error: function() {
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endsection
