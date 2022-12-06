@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
        <div class="col-md-12 col-xl-12">
            <div class="block block-themed h-100 mb-0">
                <div class="block-header bg-pulse">
                    <h3 class="block-title">
                        Form Input Pembelian
                </div>
                <div class="block-content text-muted">
                    <form id="form-add" action="#">
                        <div class="form-group row col-md-12 col-xl-12 ">
                            <div class="row col-md-6 col-xl-6">
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label" for="example-hf-email">Nama Area</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Your Email..">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label" for="example-hf-password">Nama Waroeng</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="example-hf-password" name="example-hf-password" placeholder="Your Password..">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label" for="example-hf-password">Alamat Waroeng</label>
                                    <div class="col-sm-8">
                                        <input type="textarea" class="form-control" id="example-hf-password" name="example-hf-password" placeholder="Your Password..">
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-6 col-xl-6">
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label" for="example-hf-email">Status Waroeng </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Your Email..">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label" for="example-hf-email">Jenis Waroeng </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Your Email..">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label" for="example-hf-email">Jenis Nota Waroeng </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Your Email..">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label" for="example-hf-email">Pajak Waroeng </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Your Email..">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label" for="example-hf-email">SC Waroeng </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Your Email..">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label" for="example-hf-email">Modal Tipe Waroeng </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="example-hf-email" name="example-hf-email" placeholder="Your Email..">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-6 col-xl-4 ms-auto">
                            <div class="row col-md-4 md-auto">
                                <div class="block-content block-content-full text-end bg-transparent">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                            <div class="row col-md-4 md-auto">
                                <div class="block-content block-content-full text-end bg-transparent">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->
@endsection
@section('js')
<script type="module">
    $(document).ready(function() {
        Codebase.helpersOnLoad(['jq-select2']);
        var no = 1;
        var selectValues = {
            "1": "Minyak Goreng",
            "2": "Beras C4",
            "3": "Terasi"
        }; //Contoh bentuk data

        $('.tambah').on('click', function() {
            no++;
            $('#form').append('<tr id="row' + no + '">' +
                '<td><select class="js-select2 nama_barang" name="rekap_beli_brg_code[]" id="rekap_beli_brg_code' + no + '" style="width: 100%;" data-placeholder="Pilih Nama Barang" required><option></option></select></td>' +
                '<td><input type="number" min="0.01" step="0.01" class="form-control form-control-sm qty" name="rekap_beli_detail_qty[]" id="rekap_beli_detail_qty" required></td>' +
                '<td><input type="text" class="form-control form-control-sm harga" name="rekap_beli_detail_harga[]" id="rekap_beli_detail_harga" required></td>' +
                '<td><input type="text" class="form-control form-control-sm persendisc" name="rekap_beli_detail_disc[]" id="rekap_beli_detail_disc"></td>' +
                '<td><input type="text" class="form-control form-control-sm rupiahdisc" name="rekap_beli_detail_discrp[]" id="rekap_beli_detail_discrp"></td>' +
                '<td><input type="text" class="form-control form-control-sm subtot txtCal" name="rekap_beli_detail_subtot[]" id="rekap_beli_detail_subtot"></td>' +
                '<td><button type="button" id="' + no + '" class="btn btn-danger btn_remove">Hapus</button></td></tr>');

            $.each(selectValues, function(key, value) {
                $('#rekap_beli_brg_code' + no)
                    .append($('<option>', {
                            value: key
                        })
                        .text(value));
            });
            Codebase.helpersOnLoad(['jq-select2']);
        });

        $.each(selectValues, function(key, value) {
            $('.nama_barang')
                .append($('<option>', {
                        value: key
                    })
                    .text(value));
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
        $("#form").on('input', function() {
            var $tblrows = $("#form tbody tr");
            $tblrows.each(function(index) {
                var $tblrow = $(this);

                $tblrow.find(".qty, .harga, .persendisc, .rupiahdisc").on('input', function() {

                    var qty = $tblrow.find("[name='rekap_beli_detail_qty[]']").val();
                    var price = $tblrow.find("[name='rekap_beli_detail_harga[]']").val();
                    var persendisc = $tblrow.find("[name='rekap_beli_detail_disc[]']").val();
                    var nilaipersendisc = 100 - persendisc;
                    var rupiahdisc = $tblrow.find("[name='rekap_beli_detail_discrp[]']").val();
                    if (rupiahdisc == null) {
                        rupiahdisc = 0;
                    }
                    var subTotal = parseFloat(qty) * parseFloat(price) * (nilaipersendisc / 100) - rupiahdisc;

                    if (!isNaN(subTotal)) {

                        $tblrow.find('.subtot').val(subTotal.toFixed(2));
                        var grandTotal = 0;

                        $(".subtot").each(function() {
                            var stval = parseFloat($(this).val());
                            grandTotal += isNaN(stval) ? 0 : stval;
                        });

                        $('.grdtot').val(grandTotal.toFixed(2));
                    }
                });

            });
        });
        $('#form, .qty, .harga, .persendisc, .rupiahdisc, .disc_tot').on('input', function() {
            var grdtot = 0;
            $(".subtot").each(function() {
                var stval = parseFloat($(this).val());
                grdtot += isNaN(stval) ? 0 : stval;
            });
            var disc_tot = $("[name='rekap_beli_disc']").val();
            var grandtotal = grdtot * parseFloat((100 - disc_tot) / 100);
            $('.grdtot').val(grandtotal.toFixed(2));
        });


    });
</script>
@endsection