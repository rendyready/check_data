@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            FORM TRANSFER GUDANG
                    </div>
                    <div class="block-content text-muted">
                        <form id="formAction">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-labdistributorel-sm"
                                            for="r_t_jb_created_by">Operator</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm"
                                                id="r_t_jb_created_by" name="r_t_jb_created_by"
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
                                        <label class="col-sm-5 col-form-label-sm" for="r_t_jb_code">No Nota</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm" id="r_t_jb_code"
                                                name="r_t_jb_code" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label-sm" for="r_t_jb_tgl">Tanggal</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control form-control-sm"
                                                value="{{ $data->tgl_now }}" readonly id="r_t_jb_tgl"
                                                name="r_t_jb_tgl" required>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label-sm" for="r_t_jb_jth_tmp">Jth Tempo</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control form-control-sm"
                                                value="{{ $data->tgl_now }}" id="r_t_jb_jth_tmp"
                                                name="r_t_jb_jth_tmp" readonly required>
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
                                                    name="r_t_jb_detail_m_produk_id[]"
                                                    id="r_t_jb_detail_m_produk_id1" style="width: 100%;"
                                                    data-placeholder="Pilih Nama Barang" required>
                                                    <option value="0" selected disabled hidden>Pilih Nama Produk
                                                    </option>
                                                </select></td>
                                            <td>
                                                <textarea class="form-control fc reset form-control-sm" name="r_t_jb_detail_catatan[]"
                                                    id="r_t_jb_detail_catatan" cols="50" required placeholder="catatan bb atau satuan"></textarea>
                                            </td>
                                            <td><input type="text"
                                                    class="form-control number fc reset form-control-sm qty"
                                                    name="r_t_jb_detail_qty[]" id="r_t_jb_detail_qty" required>
                                                <span class="stok" id="stok1"></span>
                                            </td>
                                            <td><input type="text"
                                                    class="form-control reset hpp number form-control-sm harga"
                                                    name="r_t_jb_detail_harga[]" id="r_t_jb_detail_harga1"
                                                    readonly></td>
                                            <td><input type="text"
                                                    class="form-control number form-control-sm persendisc"
                                                    name="r_t_jb_detail_disc[]" id="r_t_jb_detail_disc"></td>
                                            <td><input type="text"
                                                    class="form-control number form-control-sm rupiahdisc"
                                                    name="r_t_jb_detail_discrp[]" id="r_t_jb_detail_discrp"></td>
                                            <td><input type="text" class="form-control number form-control-sm subtot"
                                                    name="r_t_jb_detail_subtot[]" id="r_t_jb_detail_subtot"
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
                                            <label class="col-sm-4 col-form-label" for="r_t_jb_sub_total_beli">Jumlah
                                                Total</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm grdtot"
                                                    id="r_t_jb_sub_total_beli" name="r_t_jb_sub_total_beli" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-3 col-form-label" for="r_t_jb_disc">Diskon</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control number form-control-sm disc_tot"
                                                    id="r_t_jb_disc" name="r_t_jb_disc" placeholder="%">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text"
                                                    class="form-control number form-control-sm disc_tot_rp"
                                                    id="r_t_jb_nominal_disc" name="r_t_jb_nominal_disc" placeholder="Rp">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-3 col-form-label" for="r_t_jb_ppn">PPN</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control number form-control-sm ppn"
                                                    id="r_t_jb_ppn" name="r_t_jb_ppn" placeholder="%">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control number form-control-sm ppnrp"
                                                    id="r_t_jb_nominal_ppn" name="r_t_jb_nominal_ppn" placeholder="Rp"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="r_t_jb_ongkir">Ongkos
                                                Kirim</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm number ongkir"
                                                    id="r_t_jb_ongkir" name="r_t_jb_ongkir">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="r_t_jb_nominal_total_beli">Jumlah
                                                Akhir</label>
                                            <div class="col-sm-6">
                                                <input type="text"
                                                    class="form-control number form-control-sm r_t_jb_nominal_total_beli"
                                                    id="r_t_jb_nominal_total_beli" name="r_t_jb_nominal_total_beli" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-1" hidden>
                                            <label class="col-sm-4 col-form-label"
                                                for="r_t_jb_terbayar">Dibayar</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control number form-control-sm bayar"
                                                    id="r_t_jb_terbayar" name="r_t_jb_terbayar" value="0">
                                            </div>
                                        </div>
                                        <div class="row mb-1" hidden>
                                            <label class="col-sm-4 col-form-label" for="r_t_jb_tersisa">Sisa</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm sisa"
                                                    id="r_t_jb_tersisa" name="r_t_jb_tersisa" readonly>
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
                $('#r_t_jb_code').val(data);
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
                            $('#r_t_jb_detail_m_produk_id1').empty();
                            $('#r_t_jb_detail_m_produk_id1').append('<option></option>');
                            var asal = $(this).val()
                            $.get("/inventori/stok/" + asal, function(data) {
                                datas = data;
                                $.each(data, function(key, value) {
                                    $('#r_t_jb_detail_m_produk_id1')
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
                    $('#r_t_jb_detail_m_produk_id1').empty();
                    $('#r_t_jb_detail_m_produk_id1').append('<option></option>');
                    $.get("/inventori/stok/" + asal, function(data) {
                        datas = data;
                        $.each(data, function(key, value) {
                            $('#r_t_jb_detail_m_produk_id1')
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
                    '<td><select class="js-select2 nama_barang" name="r_t_jb_detail_m_produk_id[]" id="r_t_jb_detail_m_produk_id' +
                    no +
                    '" style="width: 100%;" data-placeholder="Pilih Nama Barang" required > <option value="0" selected disabled hidden></option></select></td>' +
                    '<td><textarea class="form-control form-control-sm" name="r_t_jb_detail_catatan[]" id="r_t_jb_detail_catatan" cols="50" required placeholder="catatan bb atau satuan"></textarea></td>' +
                    '<td><input type="text" class="form-control number form-control-sm qty" name="r_t_jb_detail_qty[]" id="r_t_jb_detail_qty" required><span class="stok" id="stok' +
                    no + '"></span></td>' +
                    '<td><input type="text" class="form-control number form-control-sm hpp harga" name="r_t_jb_detail_harga[]" id="r_t_jb_detail_harga' +
                    no + '" required></td>' +
                    '<td><input type="text" class="form-control number form-control-sm persendisc" name="r_t_jb_detail_disc[]" id="r_t_jb_detail_disc"></td>' +
                    '<td><input type="text" class="form-control number form-control-sm rupiahdisc" name="r_t_jb_detail_discrp[]" id="r_t_jb_detail_discrp"></td>' +
                    '<td><input type="text" class="form-control number form-control-sm subtot" name="r_t_jb_detail_subtot[]" id="r_t_jb_detail_subtot" readonly></td>' +
                    '<td><button type="button" id="' + no +
                    '" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>'
                    );
                Codebase.helpersOnLoad(['jq-select2']);
                $.each(datas, function(key, value) {
                    $('#r_t_jb_detail_m_produk_id' + no)
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
                            var qty = $tblrow.find("[name='r_t_jb_detail_qty[]']").val()
                                .replace(/\./g, '').replace(/\,/g, '.');
                            var price = $tblrow.find("[name='r_t_jb_detail_harga[]']").val()
                                .replace(/\./g, '').replace(/\,/g, '.');
                            var persendisc = $tblrow.find("[name='r_t_jb_detail_disc[]']")
                                .val();
                            var nilaipersendisc = 100 - persendisc;
                            var rupiahdisc = $tblrow.find("[name='r_t_jb_detail_discrp[]']")
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
                    var disc_tot = $("[name='r_t_jb_disc']").val();
                    var disctotrp = $("[name='r_t_jb_nominal_disc']").val().replace(/\./g, '').replace(/\,/g,
                        '.');
                    var ppn = $("[name='r_t_jb_ppn']").val();
                    var bayar = $("[name='r_t_jb_terbayar']").val().replace(/\./g, '').replace(/\,/g, '.');
                    var ongkir = $("[name='r_t_jb_ongkir']").val().replace(/\./g, '').replace(/\,/g, '.');
                    if (ongkir === "") {
                        var ongkir = 0;
                    }
                    var grandtotal = grdtot * parseFloat((100 - disc_tot) / 100) - disctotrp;
                    var ppnrp = parseFloat(ppn / 100) * grandtotal;
                    var r_t_jb_nominal_total_beli = parseFloat(grandtotal) + parseFloat(ppnrp) + parseFloat(ongkir);
                    $('.ppnrp').val(ppnrp);
                    $('.r_t_jb_nominal_total_beli').val(r_t_jb_nominal_total_beli.toLocaleString('id'));
                    $('.sisa').val((r_t_jb_nominal_total_beli - bayar).toLocaleString('id'));
                    $('#total_sum_value').html(': Rp ' + r_t_jb_nominal_total_beli.toLocaleString('id'));

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
                            $('#r_t_jb_detail_m_produk_id1,.reset').trigger('change').val(
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
