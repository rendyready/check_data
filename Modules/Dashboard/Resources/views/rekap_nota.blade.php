@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Rekap Nota Penjualan
                        </h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="rekap_insert">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label">Tanggal</label>
                                        <div class="col-sm-9">
                                            <input name="r_t_tanggal" class="cari form-control filter_tanggal"
                                                type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label">Area</label>
                                        <div class="col-sm-9">
                                            @if (in_array(Auth::user()->waroeng_id, $data->akses_pusat))
                                                <select id="filter_area2" data-placeholder="Pilih Area" style="width: 100%;"
                                                    class="cari f-area js-select2 form-control filter_area"
                                                    name="m_w_m_area_id">
                                                    <option></option>
                                                    @foreach ($data->area as $area)
                                                        <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select id="filter_area" data-placeholder="Pilih Area" style="width: 100%;"
                                                    class="cari f-area js-select2 form-control filter_area"
                                                    name="m_w_m_area_id" disabled>
                                                    <option value="{{ ucwords($data->area_nama->m_area_id) }}">
                                                        {{ ucwords($data->area_nama->m_area_nama) }}</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label">Waroeng</label>
                                        <div class="col-sm-9">
                                            @if (in_array(Auth::user()->waroeng_id, $data->akses_pusat))
                                                <select id="filter_waroeng1" style="width: 100%;"
                                                    class="cari f-wrg js-select2 form-control filter_waroeng"
                                                    data-placeholder="Pilih Waroeng" name="m_w_id">
                                                    <option></option>
                                                </select>
                                            @elseif (in_array(Auth::user()->waroeng_id, $data->akses_pusar))
                                                <select id="filter_waroeng3" style="width: 100%;"
                                                    data-placeholder="Pilih Waroeng"
                                                    class="cari f-area js-select2 form-control filter_waroeng"
                                                    name="waroeng">
                                                    <option></option>
                                                    @foreach ($data->waroeng as $waroeng)
                                                        <option value="{{ $waroeng->m_w_id }}"> {{ $waroeng->m_w_nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select id="filter_waroeng2" style="width: 100%;"
                                                    class="cari f-area js-select2 form-control filter_waroeng"
                                                    name="waroeng" disabled>
                                                    <option value="{{ ucwords($data->waroeng_nama->m_w_id) }}">
                                                        {{ ucwords($data->waroeng_nama->m_w_nama) }}</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                            for="rekap_inv_penjualan_created_by">Operator</label>
                                        <div class="col-sm-9">
                                            <select id="filter_operator" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control filter_operator"
                                                data-placeholder="Pilih Operator" name="r_t_created_by">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                            for="rekap_inv_penjualan_created_by">Status</label>
                                        <div class="col-sm-9">
                                            <select id="filter_status" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control filter_status"
                                                data-placeholder="Pilih Status Ditampilkan" name="r_t_created_by">
                                                <option value="all">Tampilkan Semua</option>
                                                <option value="ojol">Hanya Tampilkan Selisih Ojol</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="user-info" data-waroeng-id="{{ Auth::user()->waroeng_id }}"
                                data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_area) ? 'true' : 'false' }}">
                            </div>
                            <div id="user-info-pusat" data-waroeng-id="{{ Auth::user()->waroeng_id }}"
                                data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_pusat) ? 'true' : 'false' }}">
                            </div>

                            <div class="col-sm-8">
                                <button type="button" id="cari"
                                    class="btn btn-primary btn-sm col-1 mt-2 mb-3">Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="tampil_rekap"
                                class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Operator</th>
                                        <th>No. Nota</th>
                                        <th>Big Boss</th>
                                        <th>Tax</th>
                                        <th>Total</th>
                                        <th>SC</th>
                                        <th>Diskon</th>
                                        <th>Voucher</th>
                                        <th>Tarik Tunai</th>
                                        <th>Pembulatan</th>
                                        <th>Free Kembalian</th>
                                        <th>Total Bayar</th>
                                        <th>Total Reguler</th>
                                        <th>Metode</th>
                                        <th>Jenis Payment</th>
                                        <th>Selisih Ojol</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="show_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Select2 in a modal -->
    <div class="modal" id="detail_nota" tabindex="-1" role="dialog" aria-labelledby="form-rekening" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block-content">
                    <!-- Select2 is initialized at the bottom of the page -->
                    <div class="mb-4">
                        <div class="block block-rounded mb-1">
                            <div class="block-header block-header-default block-header-rtl bg-pulse">
                                <h3 class="block-title text-light"><small class="fw-semibold"
                                        id="no_nota"></small><br><small id="ket_trans">Dine-In</small></h3>
                                <div class="alert alert-warning py-2 mb-0">
                                    <h3 class="block-title text-black"><i class="fa fa-calendar opacity-50 ms-1"></i>
                                        <small id="tgl_nota"></small>
                                        <br><small class="fw-semibold" id="nama_kons"></small>
                                    </h3>
                                </div>
                            </div>
                            <div class="block-content mb-4" style="background-color: rgba(224, 224, 224, 0.5)">
                                <table class="table table-border" style="font-size: 13px;">
                                    <thead id="sub_nota"></thead>
                                    <tbody>
                                        <tr style="background-color: white;" class="text-end fw-semibold">
                                            <td>Total</td>
                                            <td id="total">
                                            </td>
                                        </tr>
                                        <tr style="background-color: white;" class="text-end fw-semibold">
                                            <td>Tax (10%)</td>
                                            <td id="pajak">
                                            </td>
                                        </tr>
                                        <tr style="background-color: white;" class="text-end fw-semibold">
                                            <td>Service Charge</td>
                                            <td id="sc">
                                            </td>
                                        </tr>
                                        <tr style="background-color: white;" class="text-end fw-semibold">
                                            <td>Diskon</td>
                                            <td id="diskon">
                                            </td>
                                        </tr>
                                        <tr style="background-color: white;" class="text-end fw-semibold">
                                            <td>Voucher</td>
                                            <td id="voucher">
                                            </td>
                                        </tr>
                                        <tr style="background-color: white;" class="text-end fw-semibold">
                                            <td>Tarik Tunai</td>
                                            <td id="tarik">
                                            </td>
                                        </tr>
                                        <tr style="background-color: white;" class="text-end fw-semibold">
                                            <td>Pembulatan</td>
                                            <td id="pembulatan">
                                            </td>
                                        </tr>
                                        <tr style="background-color: white;" class="text-end fw-semibold">
                                            <td>Free Kembalian</td>
                                            <td id="free">
                                            </td>
                                        </tr>
                                        <tr style="background-color: white;" class="text-end fw-semibold">
                                            <td>Total Bayar (<small id="pembayaran"></small>)</td>
                                            <td id="bayar">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="mb-3 text-end">
                                    <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Select2 in a modal -->

@endsection
@section('js')
    <!-- js -->
    <script type="module">
        $(document).ready(function() {
            Codebase.helpersOnLoad(['jq-select2']);

            function formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            var userInfo = document.getElementById('user-info');
            var userInfoPusat = document.getElementById('user-info-pusat');
            var waroengId = userInfo.dataset.waroengId;
            var HakAksesArea = userInfo.dataset.hasAccess === 'true';
            var HakAksesPusat = userInfoPusat.dataset.hasAccess === 'true';

            $('#cari').on('click', function() {
                var waroeng = $('.filter_waroeng option:selected').val();
                var tanggal = $('.filter_tanggal').val();
                var operator = $('.filter_operator option:selected').val();
                var status = $('.filter_status').val();

                if (tanggal === "" || operator === "" || waroeng === "") {
                    Swal.fire({
                        title: 'Informasi',
                        text: 'Silahkan lengkapi semua kolom',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-red-500',
                        },
                    });
                } else {
                    $('#tampil_rekap').DataTable({
                        destroy: true,
                        orderCellsTop: true,
                        processing: true,
                        scrollX: true,
                        columnDefs: [{
                            targets: '_all',
                            className: 'dt-body-center'
                        }, ],
                        buttons: [{
                            extend: 'excelHtml5',
                            text: 'Export Excel',
                            title: 'Rekap Nota - ' + tanggal,
                            pageSize: 'A4',
                            pageOrientation: 'potrait',
                        }],
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ],
                        pageLength: 10,
                        ajax: {
                            url: '{{ route('rekap.show') }}',
                            data: {
                                waroeng: waroeng,
                                tanggal: tanggal,
                                operator: operator,
                                status: status,
                            },
                            type: "GET",
                        },
                        success: function(data) {
                            console.log(data);
                            Swal.fire({
                                title: 'Informasi',
                                text: 'error gaes',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'bg-red-500',
                                },
                            });
                        },
                        error: function(data) {
                            console.log(data);
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                }
            });

            if (HakAksesPusat) {
                $('.filter_area').on('select2:select', function() {
                    var id_area = $(this).val();
                    var tanggal = $('.filter_tanggal').val();
                    var prev = $(this).data('previous-value');
                    if (id_area && tanggal) {
                        $.ajax({
                            type: "GET",
                            url: '{{ route('rekap.select_waroeng') }}',
                            dataType: 'JSON',
                            destroy: true,
                            data: {
                                id_area: id_area,
                            },
                            success: function(res) {
                                // console.log(res);           
                                if (res) {
                                    $(".filter_waroeng").empty();
                                    $(".filter_waroeng").append('<option></option>');
                                    $.each(res, function(key, value) {
                                        $(".filter_waroeng").append('<option value="' +
                                            key + '">' + value + '</option>');
                                    });
                                } else {
                                    $(".filter_waroeng").empty();
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Informasi',
                            text: "Harap lengkapi kolom tanggal",
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-red-500',
                            },
                        });
                        $(".filter_waroeng").empty();
                        $(".filter_area").val(prev).trigger('change');
                    }
                    $(".filter_operator").empty();
                });
            }

            if (HakAksesArea) {
                $('.filter_waroeng').on('select2:select', function() {
                    var id_waroeng = $(this).val();
                    var tanggal = $('.filter_tanggal').val();
                    var prev = $(this).data('previous-value');
                    if (id_waroeng && tanggal) {
                        $.ajax({
                            type: "GET",
                            url: '{{ route('rekap.select_user') }}',
                            dataType: 'JSON',
                            data: {
                                id_waroeng: id_waroeng,
                                tanggal: tanggal,
                            },
                            success: function(res) {
                                console.log(res);
                                if (res) {
                                    $(".filter_operator").empty();
                                    $(".filter_operator").append('<option></option>');
                                    $.each(res, function(key, value) {
                                        $(".filter_operator").append('<option value="' +
                                            key + '">' + value + '</option>');
                                    });
                                } else {
                                    $(".filter_operator").empty();
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Informasi',
                            text: "Harap lengkapi kolom tanggal",
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-red-500',
                            },
                        });
                        $(".filter_operator").empty();
                        $(".filter_waroeng").val(prev).trigger('change');
                    }
                });

            } else {

                $('.filter_tanggal').on('change', function() {
                    var tanggal = $('.filter_tanggal').val();
                    if (tanggal) {
                        $.ajax({
                            type: "GET",
                            url: '{{ route('rekap.select_user') }}',
                            dataType: 'JSON',
                            data: {
                                tanggal: tanggal,
                            },
                            success: function(res) {
                                if (res) {
                                    $(".filter_operator").empty();
                                    $(".filter_operator").append('<option></option>');
                                    $.each(res, function(key, value) {
                                        $(".filter_operator").append('<option value="' +
                                            key + '">' + value + '</option>');
                                    });
                                } else {
                                    $(".filter_operator").empty();
                                }
                            }
                        });
                    } else {
                        $(".filter_operator").empty();
                    }
                });
            }

            $('.filter_tanggal').flatpickr({
                mode: "range",
                dateFormat: 'Y-m-d',
            });

            $("#tampil_rekap").on('click', '#button_detail', function() {
                var id = $(this).attr('value');
                $.ajax({
                    url: "/dashboard/rekap/detail/" + id,
                    type: "GET",
                    dataType: 'json',
                    destroy: true,
                    success: function(data) {
                        // console.log(data.detail_nota.r_t_detail_id);
                        $('#no_nota').html(data.transaksi_rekap.r_t_nota_code);
                        $('#tgl_nota').html(data.transaksi_rekap.r_t_tanggal);
                        $('#nama_kons').html(data.transaksi_rekap.name);
                        $('#total').html(formatNumber(Number(data.transaksi_rekap
                            .r_t_nominal)));
                        $('#pajak').html(formatNumber(Number(data.transaksi_rekap
                            .r_t_nominal_pajak)));
                        $('#bayar').html(formatNumber(Number(data.transaksi_rekap
                            .r_t_nominal_total_bayar) - Number(data.transaksi_rekap
                            .r_t_nominal_pembulatan) - Number(data.transaksi_rekap
                            .r_t_nominal_free_kembalian)));
                        $('#pembayaran').html(data.transaksi_rekap.m_payment_method_name);
                        $('#sc').html(formatNumber(Number(data.transaksi_rekap
                            .r_t_nominal_sc)));
                        $('#diskon').html(formatNumber(Number(data.transaksi_rekap
                            .r_t_nominal_diskon)));
                        $('#voucher').html(formatNumber(Number(data.transaksi_rekap
                            .r_t_nominal_voucher)));
                        $('#tarik').html(formatNumber(Number(data.transaksi_rekap
                            .r_t_nominal_tarik_tunai)));
                        $('#pembulatan').html(formatNumber(Number(data.transaksi_rekap
                            .r_t_nominal_pembulatan)));
                        $('#free').html(formatNumber(Number(data.transaksi_rekap
                            .r_t_nominal_free_kembalian)));

                        $('.sub_sub_nota').remove();
                        //transaksi
                        $.each(data.detail_nota, function(key, item) {
                            var rekap_id = item.r_t_detail_r_t_id.toString().replace(
                                /\./g, '');
                            console.log(item.r_t_detail_m_produk_nama);
                            $('#sub_nota').append(
                                '<tr class="sub_sub_nota" style="background-color: white;">' +
                                '<td>' +
                                '<small class="fw-semibold" style="font-size: 15px;" id="produk">' +
                                item.r_t_detail_m_produk_nama + '</small> <br>' +
                                '<small id="qty">' + item.r_t_detail_qty +
                                '</small> x <small id="price">' + formatNumber(
                                    Number(item.r_t_detail_price)) + '</small>' +
                                '</td>' +
                                '<td class="text-end fw-semibold" id+="sub_total">' +
                                formatNumber(Number(item.r_t_detail_nominal)) + '' +
                                '</td>' +
                                '</tr>'
                            );
                        });
                        //garansi
                        var garansi_notnull = data.garansi_notnull;
                        console.log(garansi_notnull);
                        if (garansi_notnull !== null) {
                            $.each(data.garansi, function(key, item) {
                                var rekap_id = item.rekap_garansi_r_t_id.toString()
                                    .replace(
                                        /\./g, '');
                                $('#sub_nota').append(
                                    '<tr class="sub_sub_nota" style="background-color: #F0E68C;">' +
                                    '<td>' +
                                    '<small class="fw-semibold" style="font-size: 15px;" id="produk">' +
                                    item.rekap_garansi_m_produk_nama +
                                    '</small> <br>' +
                                    '<small id="qty">' + item.rekap_garansi_qty +
                                    '</small> x <small id="price">' + formatNumber(
                                        Number(item.rekap_garansi_price)) +
                                    ' (Garansi) </small>' +
                                    '</td>' +
                                    '<td class="text-end fw-semibold" id+="sub_total">' +
                                    formatNumber(Number(item
                                        .rekap_garansi_nominal)) + '' +
                                    '</td>' +
                                    '</tr>'
                                );
                            });
                        }

                        //refund
                        var refund_notnull = data.refund_notnull;
                        console.log(refund_notnull);
                        if (refund_notnull !== null) {
                            $.each(data.refund, function(key, item) {
                                var rekap_id = item.r_r_r_t_id.toString().replace(
                                    /\./g, '');
                                $('#sub_nota').append(
                                    '<tr class="sub_sub_nota" style="background-color: #FFEFD5;">' +
                                    '<td>' +
                                    '<small class="fw-semibold" style="font-size: 15px;" id="produk">' +
                                    item.r_r_detail_m_produk_nama +
                                    '</small> <br>' +
                                    '<small id="qty">' + item.r_r_detail_qty +
                                    '</small> x <small id="price">' + formatNumber(
                                        Number(item.r_r_detail_price)) +
                                    ' (Refund) </small>' +
                                    '</td>' +
                                    '<td class="text-end fw-semibold" id+="sub_total">' +
                                    formatNumber(Number(item.r_r_detail_nominal)) +
                                    '' +
                                    '</td>' +
                                    '</tr>'
                                );
                            });
                        }
                    },
                });
                $("#detail_nota").modal('show');
            });

        });
    </script>
@endsection
