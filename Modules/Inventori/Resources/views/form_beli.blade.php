@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            FORM INPUT PEMBELIAN MANDIRI
                    </div>
                    <div class="block-content text-muted">
                        <form id="formAction">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label-sm"
                                            for="r_t_jb_created_by">Operator</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm"
                                                id="r_t_jb_created_by" name="r_t_jb_created_by"
                                                value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label-sm" for="example-hf-text">Waroeng</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm"
                                                id="r_t_jb_waroeng" name="r_t_jb_waroeng"
                                                value="{{ $data->waroeng_nama->m_w_nama }}" readonly>
                                                <input type="hidden" id="m_w_id" name="m_w_id" value="{{$data->m_w_id}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label-sm" for="r_t_jb_m_gudang_code">Masuk
                                            Gudang</label>
                                        <div class="col-sm-9">
                                            <select class="js-select2 gudang_code form-control-sm" style="width: 100%;"
                                                name="r_t_jb_m_gudang_code" id="r_t_jb_m_gudang_code"
                                                data-placeholder="Pilih Gudang" required>
                                                <option></option>
                                                @foreach ($data->gudang as $item)
                                                    <option value="{{ $item->m_gudang_code }}">
                                                        {{ ucwords($item->m_gudang_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label-sm" for="m_jenis_belanja">
                                            Belanja</label>
                                        <div class="col-sm-9">
                                            <select class="js-select2 m_jenis_belanja form-control-sm" style="width: 100%;"
                                                name="m_jenis_belanja" id="m_jenis_belanja"
                                                data-placeholder="Pilih Jenis Belanja" required>
                                                <option></option>
                                                @foreach ($data->m_jenis_belanja as $item)
                                                    <option value="{{ $item->m_jenis_belanja_nama }}">
                                                        {{ ucwords($item->m_jenis_belanja_nama) }}</option>
                                                @endforeach
                                            </select>
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
                                        <label class="col-sm-5 col-form-label-sm" for="r_t_jb_code_nota">Nota
                                            Supplier</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm"
                                                id="r_t_jb_code_nota" name="r_t_jb_code_nota" value=""
                                                placeholder="Nota Supplier">
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
                                <div class="col-md-4">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label-sm" for="r_t_jb_m_supplier_code">Kode
                                            Supplier</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 form-control-sm" style="width: 100%;"
                                                name="r_t_jb_m_supplier_code" id="r_t_jb_m_supplier_code"
                                                data-placeholder="pilih supplier" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm"
                                            for="r_t_jb_m_supplier_nama">Nama</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control supplier form-control-sm"
                                                id="r_t_jb_m_supplier_nama" name="r_t_jb_m_supplier_nama" readonly
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="r_t_jb_m_supplier_telp">No
                                            Telpn</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control supplier form-control-sm"
                                                id="r_t_jb_m_supplier_telp" name="r_t_jb_m_supplier_telp" readonly
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm"
                                            for="r_t_jb_m_supplier_alamat">Alamat</label>
                                        <div class="col-sm-8">
                                            <textarea class="supplier" name="r_t_jb_m_supplier_alamat" id="r_t_jb_m_supplier_alamat" cols="23"
                                                rows="3" readonly required></textarea>
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
                                                    <option>
                                                    </option>
                                                </select></td>
                                            <td>
                                                <textarea class="form-control fc reset form-control-sm" name="r_t_jb_detail_catatan[]"
                                                    id="r_t_jb_detail_catatan" cols="50" required placeholder="catatan bb atau satuan harus di isi !!"></textarea>
                                            </td>
                                            <td><input type="text"
                                                    class="form-control fc reset number form-control-sm qty"
                                                    name="r_t_jb_detail_qty[]" id="r_t_jb_detail_qty" required>
                                            </td>
                                            <td><input type="text"
                                                    class="form-control fc reset number form-control-sm harga"
                                                    name="r_t_jb_detail_harga[]" id="r_t_jb_detail_harga"
                                                    required></td>
                                            <td><input type="text"
                                                    class="form-control number fc reset form-control-sm persendisc"
                                                    name="r_t_jb_detail_disc[]" id="r_t_jb_detail_disc"></td>
                                            <td><input type="text"
                                                    class="form-control number fc reset form-control-sm rupiahdisc"
                                                    name="r_t_jb_detail_discrp[]" id="r_t_jb_detail_discrp"></td>
                                            <td><input type="text"
                                                    class="form-control number reset form-control-sm subtot"
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
                                                    id="r_t_jb_disc" name="r_t_jb_disc" placeholder="%" value="0">
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
                                                    id="r_t_jb_ppn" name="r_t_jb_ppn" placeholder="%" value="0">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control number form-control-sm ppnrp"
                                                    id="r_t_jb_nominal_ppn" name="r_t_jb_nominal_ppn" placeholder="Rp"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="r_t_jb_nominal_ongkir">Ongkos
                                                Kirim</label>
                                            <div class="col-sm-6">
                                                <input type="text"
                                                    class="form-control form-control-sm number reset ongkir"
                                                    id="r_t_jb_nominal_ongkir" name="r_t_jb_nominal_ongkir">
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
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label"
                                                for="r_t_jb_nominal_bayar">Dibayar</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control number form-control-sm bayar"
                                                    id="r_t_jb_nominal_bayar" name="r_t_jb_nominal_bayar">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
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
                        <table class="table-responsive">
                            <table id="tb_beli"
                                class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Supplier</th>
                                    <th>Jumlah </th>
                                    <th>Operator</th>
                                    <th>Jam Input</th>
                                    <th>Detail</th>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th>No</th>
                                    <th>Nama Supplier</th>
                                    <th>Jumlah </th>
                                    <th>Operator</th>
                                    <th>Jam Input</th>
                                    <th>Detail</th>
                                </tfoot>
                            </table>
                        </table>
                        <!-- Select2 in a modal -->
                        <div class="modal modal-lg" id="form-hist" tabindex="-1" role="dialog"
                            aria-labelledby="form-hist" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="block block-themed shadow-none mb-0">
                                        <div class="block-header block-header-default bg-pulse">
                                            <h3 class="block-title" id="myModalLabel"></h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i class="fa fa-fw fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <!-- Select2 is initialized at the bottom of the page -->
                                            <div class="table-responsive">
                                                <table id="tb_beli_histori"
                                                    class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                                                    <thead>
                                                        <th>No</th>
                                                        <th>Nama Barang</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>Disc Rp</th>
                                                        <th>Total</th>
                                                        <th>Keterangan </th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                        <th>No</th>
                                                        <th>Nama Barang</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>Disc Rp</th>
                                                        <th>Total</th>
                                                        <th>Keterangan </th>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-full text-end bg-body">
                                            <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Select2 in a modal -->
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
        var datas, table, asal;
        var isConfirmationShown = false;
        $(document).ready(function() {
            get_code();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });
            Codebase.helpersOnLoad(['jq-select2']);
            var getDataAndReloadTable = function() {
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

                table = $('#tb_beli').DataTable({
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
                        "url": "beli/history/" + asal,
                        "type": "GET"
                    }
                });
            };

            $(document).
            on("select2:open", '#r_t_jb_m_gudang_code', function() {
                $(this).data("id", $(this).val());
            }).
            on('change', '#r_t_jb_m_gudang_code', function() {
                asal = $(this).val();
                var id = $(this).data("id");
                    if ($('.fc').serialize().length > 191) {
                        if (!isConfirmationShown) {
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
                                );
                                getDataAndReloadTable();
                                $('.remove').remove();
                                $('.reset').trigger('changer').val('');
                            } else {
                                isConfirmationShown =
                                    true; // Set isConfirmationShown kembali ke false agar dialog konfirmasi dapat ditampilkan lagi jika diperlukan
                                $('#r_t_jb_m_gudang_code').val(id).trigger('change');
                                isConfirmationShown = false;
                            }
                        });
                    }
                } else {
                    getDataAndReloadTable();
                }
            });


            var no = 2;
            var supplier = new Array();

            function addRow() {
                $('#form').append('<tr class="remove" id="row' + no + '">' +
                    '<td><select class="js-select2 nama_barang" name="r_t_jb_detail_m_produk_id[]" id="r_t_jb_detail_m_produk_id' +
                    no +
                    '" style="width: 100%;" data-placeholder="Pilih Nama Barang" required > <option></option></select></td>' +
                    '<td><textarea class="form-control form-control-sm" name="r_t_jb_detail_catatan[]" id="r_t_jb_detail_catatan' +
                    no +
                    '" cols="50" required placeholder="catatan bb atau satuan harus di isi !!"></textarea></td>' +
                    '<td><input type="text" class="form-control number form-control-sm qty" name="r_t_jb_detail_qty[]" id="r_t_jb_detail_qty' +
                    no + '" required></td>' +
                    '<td><input type="text" class="form-control number form-control-sm harga" name="r_t_jb_detail_harga[]" id="r_t_jb_detail_harga' +
                    no + '" required></td>' +
                    '<td><input type="text" class="form-control number form-control-sm persendisc" name="r_t_jb_detail_disc[]" id="r_t_jb_detail_disc' +
                    no + '"></td>' +
                    '<td><input type="text" class="form-control number form-control-sm rupiahdisc" name="r_t_jb_detail_discrp[]" id="r_t_jb_detail_discrp' +
                    no + '"></td>' +
                    '<td><input type="text" class="form-control number form-control-sm subtot" name="r_t_jb_detail_subtot[]" id="r_t_jb_detail_subtot' +
                    no + '" readonly></td>' +
                    '<td><button type="button" id="' + no +
                    '" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>');
                Codebase.helpersOnLoad(['jq-select2']);
                $.each(datas, function(key, value) {
                    $('#r_t_jb_detail_m_produk_id' + no)
                        .append($('<option>', {
                                value: key
                            })
                            .text(value));
                });
                no++;
                $('#formAction tr:last-child td:nth-child(1) select').focus();
            }
            $.get('/inventori/beli/list', function(response) {
                supplier = response['supplier'];
                $.each(supplier, function(key, value) {
                    $('#r_t_jb_m_supplier_code')
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
                    var bayar = $("[name='r_t_jb_nominal_bayar']").val().replace(/\./g, '').replace(/\,/g,
                        '.') || 0;
                    var ongkir = $("[name='r_t_jb_nominal_ongkir']").val().replace(/\./g, '').replace(/\,/g, '.') ||
                        0;
                    var grandtotal = grdtot * parseFloat((100 - disc_tot) / 100) - disctotrp;
                    var ppnrp = parseFloat(ppn / 100) * grandtotal;
                    var r_t_jb_nominal_total_beli = parseFloat(grandtotal) + parseFloat(ppnrp) + parseFloat(ongkir);
                    $('.ppnrp').val(ppnrp);
                    $('.r_t_jb_nominal_total_beli').val(r_t_jb_nominal_total_beli.toLocaleString('id'));
                    if ((bayar - r_t_jb_nominal_total_beli) > 0) {
                        Codebase.helpers('jq-notify', {
                            align: 'right', // 'right', 'left', 'center'
                            from: 'top', // 'top', 'bottom'
                            type: 'danger', // 'info', 'success', 'warning', 'danger'
                            icon: 'fa fa-info me-5', // Icon class
                            message: 'Nominal Bayar Tidak Boleh Lebih Dari Tagihan'
                        });
                        $('.bayar').val('');
                        $tblrows.find('.persendisc').trigger('input');
                    } else {
                        $('.sisa').val((r_t_jb_nominal_total_beli - bayar).toLocaleString('id'));
                    }
                    $('#total_sum_value').html(': Rp ' + r_t_jb_nominal_total_beli.toLocaleString('id'));
                });
            $('#r_t_jb_m_supplier_code').on('change', function() {
                var id = $(this).val();
                var mw_id = $('#m_w_id').val();
                if (id == '500001') {
                    const date = new Date('{{ $data->tgl_now }}').toISOString().slice(0, 10);
                    $('.supplier').attr('readonly', false).trigger('change').val('');
                    $("#r_t_jb_jth_tmp").val(date).trigger('change');
                } else {
                    $('.supplier').attr('readonly', true);
                    $.ajax({
                        url: "/inventori/supplier/get_detail/" + id + "/" + mw_id,
                        type: "GET",
                        dataType: 'json',
                        success: function(respond) {
                            $("#r_t_jb_m_supplier_nama").val(respond.m_supplier_nama).trigger(
                                'change');
                            $("#r_t_jb_m_supplier_alamat").val(respond.m_supplier_alamat)
                                .trigger('change');
                            $("#r_t_jb_m_supplier_telp").val(respond.m_supplier_telp).trigger(
                                'change');
                            const date = new Date('{{ $data->tgl_now }}');
                            date.setDate(date.getDate() + parseInt(respond
                                .m_supplier_jth_tempo));
                            var jth_tmp = new Date(date).toISOString().slice(0, 10);
                            $("#r_t_jb_jth_tmp").val(jth_tmp).trigger('change');
                        },
                        error: function() {}
                    });
                }
            });
            $('.tambah').on('click', function() {
                addRow();
            });
            $('#formAction').on('keydown', 'input[name="r_t_jb_detail_subtot[]"]:last', function(e) {
                if (e.which == 9) { // 9 is the code for the "Tab" key
                    e.preventDefault(); // prevent default "Tab" behavior
                    addRow(); // simulate a click on the "Add Field" button
                }
            });
            $('#formAction').submit(function(e) {
                e.preventDefault();
                var dibayar = $('#r_t_jb_nominal_bayar').val();
                var ajaxData = {
                    url: "{{ route('beli.simpan') }}",
                    type: "POST",
                    data: $('form').serialize(),
                    success: function(data) {
                        Codebase.helpers('jq-notify', {
                            align: 'right',
                            from: 'top',
                            type: 'success',
                            icon: 'fa fa-info me-5',
                            message: 'Input Pembelian Berhasil'
                        });
                        table.ajax.reload();
                        $('.remove').remove();
                        $('#r_t_jb_detail_m_produk_id1,.reset,.supplier').trigger('change').val(
                            '');
                        $('.grdtot').val(0);
                        $('.bayar').val('');
                        $('#form').find('.persendisc').trigger('input');
                        get_code();
                        $('html, body').animate({
                            scrollTop: 0
                        }, 'slow');
                    },
                    error: function() {
                        alert("Tidak dapat menyimpan data!");
                    }
                };
                if (dibayar == 0) {
                    Swal.fire({
                        title: 'Apakah Anda Yakin Belanja Non Tunai?',
                        text: "Anda Akan Input Pembelian Secara Non Tunai",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax(ajaxData);
                        }
                    });
                } else {
                    $.ajax(ajaxData);
                }
            });
            $(document).on('click', '.detail', function() {
                $("#form-hist").modal('show');
                var id = $(this).attr('value');
                $("#myModalLabel").html('No Nota ' + id);
                $('#tb_beli_histori').DataTable({
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
                        "url": "beli/history_detail/" + id,
                        "type": "GET"
                    }
                });
            })

        });
    </script>
@endsection
