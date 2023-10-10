@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Rekap Penjualan WBD Karyawan
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
                                                type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" readonly />
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
                                                    <option value="all">All Area</option>
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

                                <div class="col-sm-5" id="select_waroeng">
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
                                                    <option value="all">all waroeng</option>
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

                            <div id="user-info" data-waroeng-id="{{ Auth::user()->waroeng_id }}"
                                data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_area) ? 'true' : 'false' }}">
                            </div>
                            <div id="user-info-pusat" data-waroeng-id="{{ Auth::user()->waroeng_id }}"
                                data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_pusat) ? 'true' : 'false' }}">
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <button type="button" id="cari_member" class="btn btn-primary btn-sm mb-3 mt-3">Cari By
                                        Member</button>
                                    <button type="button" id="cari_waroeng" class="btn btn-warning btn-sm mb-3 mt-3">Cari
                                        By
                                        Waroeng</button>
                                    <a class="btn btn-sm btn-primary mb-3 mt-3" id="export_excel"
                                        style="display: none;">Export
                                        Excel <span id="export_loading" style="display: none;"><img
                                                src="{{ asset('media/gif/loading.gif') }}" alt="Loading..."
                                                style="max-width: 16px; max-height: 16px;"></span></a>
                                </div>
                            </div>
                        </form>

                        <div id="member_show" style="display: none;" class="table-responsive text-center">
                            <table id="tampil_rekap"
                                class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Personel</th>
                                        <th class="text-center">ID Personel</th>
                                        <th class="text-center">Tgl Belanja</th>
                                        <th class="text-center">Belanja WBD</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div id="waroeng_show" style="display: none;" class="table-responsive text-center">
                            <table id="tampil_waroeng"
                                class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Waroeng</th>
                                        <th class="text-center">Tanggal</th>
                                        {{-- <th class="text-center">Omset WBD Total</th> --}}
                                        <th class="text-center">Omset WBD Karyawan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Select2 in a modal -->
    <div class="modal" id="detail_wbd" tabindex="-1" role="dialog" aria-labelledby="tampil_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-themed shadow-none mb-0">
                    <div class="block-header block-header-default bg-pulse">
                        <h3 class="block-title text-center" id="myModalLabel">Rincian Pesanan WBD</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table style="margin-bottom: 10px;">
                            <tr>
                                <td><b>Tanggal </b></td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><span id="tanggal_pop"> </span></td>
                            </tr>
                            <tr>
                                <td><b>Personel </b></td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><span id="member_pop"> </span></td>
                            </tr>
                            <tr>
                                <td><b>Penempatan </b></td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><span id="waroeng_pop"> </span></td>
                            </tr>
                        </table>

                        <div class="table-responsive">
                            <table id="detailTable" class="table table-bordered nowrap">
                                <thead>
                                    <th class="text-center">Nota</th>
                                    <th class="text-center">Waroeng</th>
                                    <th class="text-center">Produk WBD</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Bayar Produk WBD</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1 mb-3"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal" id="detail_wbd_waroeng_total" tabindex="-1" role="dialog" aria-labelledby="tampil_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-themed shadow-none mb-0">
                    <div class="block-header block-header-default bg-pulse">
                        <h3 class="block-title text-center" id="myModalLabel">Rincian WBD Waroeng</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table style="margin-bottom: 10px;">
                            <tr>
                                <td><b>Tanggal </b></td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><span id="tanggal_pop_waroeng"> </span></td>
                            </tr>
                            <tr>
                                <td><b>Waroeng </b></td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><span id="waroeng_pop_waroeng"> </span></td>
                            </tr>
                        </table>

                        <div class="table-responsive">
                            <table id="detailTableWaroeng" class="table table-bordered nowrap">
                                <thead>
                                    <th class="text-center">Nota</th>
                                    <th class="text-center">Produk WBD</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Nominal WBD</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1 mb-3"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- END Select2 in a modal -->

    <div class="modal" id="detail_wbd_waroeng_member" tabindex="-1" role="dialog" aria-labelledby="tampil_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-themed shadow-none mb-0">
                    <div class="block-header block-header-default bg-pulse">
                        <h3 class="block-title text-center" id="myModalLabel">Rincian WBD Karyawan</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table style="margin-bottom: 10px;">
                            <tr>
                                <td><b>Tanggal </b></td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><span id="tanggal_pop_waroeng_member"> </span></td>
                            </tr>
                            <tr>
                                <td><b>Waroeng </b></td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><span id="waroeng_pop_waroeng_member"> </span></td>
                            </tr>
                        </table>

                        <div class="table-responsive">
                            <table id="detailTableWaroengMember" class="table table-bordered nowrap">
                                <thead>
                                    <th class="text-center">Karyawan</th>
                                    <th class="text-center">Nota</th>
                                    <th class="text-center">Produk WBD</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Nominal WBD</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1 mb-3"
                                data-bs-dismiss="modal">Close</button>
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

            var userInfo = document.getElementById('user-info');
            var userInfoPusat = document.getElementById('user-info-pusat');
            var waroengId = userInfo.dataset.waroengId;
            var HakAksesArea = userInfo.dataset.hasAccess === 'true';
            var HakAksesPusat = userInfoPusat.dataset.hasAccess === 'true';

            $('#cari_member').on('click', function() {
                var area = $('.filter_area option:selected').val();
                var waroeng = $('.filter_waroeng option:selected').val();
                var tanggal = $('.filter_tanggal').val();
                // $("#export_excel").show();

                if (tanggal === "" && (area === "" || waroeng === "")) {
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
                    $("#member_show").show();
                    $("#waroeng_show").hide();
                    $('#tampil_rekap').DataTable({
                        buttons: [{
                            extend: 'excelHtml5',
                            text: 'Export Excel',
                            title: 'Rekap WBD by Personel - ' + tanggal,
                            pageSize: 'A4',
                            pageOrientation: 'potrait',
                        }],
                        destroy: true,
                        orderCellsTop: true,
                        processing: true,
                        autoWidth: false,
                        scrollX: true,
                        scrollCollapse: true,
                        columnDefs: [{
                            targets: '_all',
                            className: 'dt-body-center'
                        }, ],
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ],
                        pageLength: 10,
                        ajax: {
                            url: '{{ route('rekap_wbd.show_member') }}',
                            data: {
                                area: area,
                                waroeng: waroeng,
                                tanggal: tanggal,
                            },
                            type: "GET",
                        },
                        columns: [{
                                data: 'name'
                            },
                            {
                                data: 'r_t_member_id'
                            },
                            {
                                data: 'r_t_tanggal'
                            },
                            {
                                data: 'nilaibeli',
                                render: function(data, type, row) {
                                    return parseFloat(data).toLocaleString(
                                        'id-ID', {
                                            maximumFractionDigits: 0
                                        });
                                },
                            },
                            {
                                data: null,
                                render: function(data, type, full, meta) {
                                    return '<button class="btn btn-sm btn-info detail-button" id="button_detail" data-tanggal="' +
                                        data.r_t_tanggal + '" data-member="' + data
                                        .r_t_member_id + '">Detail</button>';
                                }
                            }
                        ],
                        success: function(data) {
                            console.log(data);

                        }
                    });
                }
            });

            $('#cari_waroeng').on('click', function() {
                var area = $('.filter_area option:selected').val();
                var waroeng = $('.filter_waroeng option:selected').val();
                var tanggal = $('.filter_tanggal').val();
                // $("#export_excel").show();

                if (tanggal === "" && (area === "" || waroeng === "")) {
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
                    $("#member_show").hide();
                    $("#waroeng_show").show();
                    $('#tampil_waroeng').DataTable({
                        buttons: [{
                            extend: 'excelHtml5',
                            text: 'Export Excel',
                            title: 'Rekap WBD by Waroeng- ' + tanggal,
                            pageSize: 'A4',
                            pageOrientation: 'potrait',
                        }],
                        destroy: true,
                        orderCellsTop: true,
                        processing: true,
                        autoWidth: false,
                        scrollX: true,
                        scrollCollapse: true,
                        columnDefs: [{
                            targets: '_all',
                            className: 'dt-body-center'
                        }, ],
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ],
                        pageLength: 10,
                        ajax: {
                            url: '{{ route('rekap_wbd.show_waroeng') }}',
                            data: {
                                area: area,
                                waroeng: waroeng,
                                tanggal: tanggal,
                            },
                            type: "GET",
                        },
                        success: function(data) {
                            console.log(data);

                        }
                    });
                }
            });

            $("#tampil_rekap").on('click', '#button_detail', function() {
                var tanggal = $(this).data('tanggal');
                var member = $(this).data('member');

                console.log(tanggal);
                $.ajax({
                    url: "/dashboard/rekap_wbd/detail_member/" + tanggal + "/" + member,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data.data[0].r_t_tanggal);

                        var date = new Date(data.data[0].r_t_tanggal);
                        var options = {
                            year: 'numeric',
                            month: 'long',
                            day: '2-digit'
                        };
                        var formattedDate = date.toLocaleDateString('id-ID', options);
                        $('#tanggal_pop').html(formattedDate);
                        $('#member_pop').html(data.data[0].name);
                        $('#waroeng_pop').html(data.data[0].m_w_nama);
                        $('#detailTable').DataTable({
                            buttons: [],
                            destroy: true,
                            autoWidth: false,
                            paging: false,
                            ajax: {
                                url: "/dashboard/rekap_wbd/detail_member/" +
                                    tanggal + "/" + member,

                                type: "GET",
                            },
                            // data: data,
                            columns: [{
                                    data: 'r_t_nota_code'
                                },
                                {
                                    data: 'r_t_m_w_nama'
                                },
                                {
                                    data: 'r_t_detail_m_produk_nama'
                                },
                                {
                                    data: 'r_t_detail_qty',
                                    className: 'text-center'
                                },
                                {
                                    data: 'nilaibeli',
                                    className: 'text-center',
                                    render: function(data, type, row) {
                                        return parseFloat(data).toLocaleString(
                                            'id-ID', {
                                                maximumFractionDigits: 0
                                            });
                                    },
                                }
                            ]
                        });
                    }
                })
                $("#detail_wbd").modal('show');
            })

            // $("#tampil_waroeng").on('click', '#button_detail_waroeng', function() {
            //     var tanggal = $(this).data('tanggal');
            //     var waroeng = $(this).data('waroeng');
            //     // console.log(waroeng);
            //     // console.log(tanggal);
            //     $.ajax({
            //         buttons: [{
            //             extend: 'excelHtml5',
            //             text: 'Export Excel',
            //             title: 'Rekap WBD - ' + tanggal,
            //             pageSize: 'A4',
            //             pageOrientation: 'potrait',
            //         }],
            //         url: "/dashboard/rekap_wbd/detail_waroeng/" + tanggal + "/" + waroeng,
            //         type: "GET",
            //         dataType: 'json',
            //         success: function(data) {
            //             console.log(data.tanggal.tanggal);
            //             var date = new Date(data.tanggal.tanggal);
            //             var options = {
            //                 year: 'numeric',
            //                 month: 'long',
            //                 day: '2-digit'
            //             };
            //             var formattedDate = date.toLocaleDateString('id-ID', options);
            //             $('#tanggal_pop_waroeng').html(formattedDate);
            //             $('#waroeng_pop_waroeng').html(data.waroeng.waroeng);
            //             $('#detailTableWaroeng').DataTable({
            //                 buttons: [{
            //                     extend: 'excelHtml5',
            //                     text: 'Export Excel',
            //                     title: 'Rekap WBD- ' + tanggal,
            //                     pageSize: 'A4',
            //                     pageOrientation: 'potrait',
            //                 }],
            //                 destroy: true,
            //                 autoWidth: false,
            //                 paging: false,
            //                 ajax: {
            //                     url: "/dashboard/rekap_wbd/detail_waroeng/" +
            //                         tanggal + "/" + waroeng,
            //                     type: "GET",
            //                 },
            //             });
            //         }
            //     })
            //     $("#detail_wbd_waroeng_total").modal('show');
            // })

            $("#tampil_waroeng").on('click', '#button_detail_member', function() {
                var tanggal = $(this).data('tanggal');
                var waroeng = $(this).data('waroeng');
                // console.log(waroeng);
                // console.log(tanggal);
                $.ajax({
                    url: "/dashboard/rekap_wbd/detail_waroeng_member/" + tanggal + "/" + waroeng,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data.tanggal.tanggal);
                        var date = new Date(data.tanggal.tanggal);
                        var options = {
                            year: 'numeric',
                            month: 'long',
                            day: '2-digit'
                        };
                        var formattedDate = date.toLocaleDateString('id-ID', options);
                        $('#tanggal_pop_waroeng_member').html(formattedDate);
                        $('#waroeng_pop_waroeng_member').html(data.waroeng.waroeng);
                        $('#detailTableWaroengMember').DataTable({
                            buttons: [{
                                extend: 'excelHtml5',
                                text: 'Export Excel',
                                title: 'Rekap WBD- ' + tanggal,
                                pageSize: 'A4',
                                pageOrientation: 'potrait',
                            }],
                            destroy: true,
                            autoWidth: false,
                            paging: false,
                            ajax: {
                                url: "/dashboard/rekap_wbd/detail_waroeng_member/" +
                                    tanggal + "/" + waroeng,
                                type: "GET",
                            },
                        });
                    }
                })
                $("#detail_wbd_waroeng_member").modal('show');
            })

            $('#export_excel').on('click', function() {
                var area = $('.filter_area option:selected').val();
                var waroeng = $('.filter_waroeng option:selected').val();
                var tanggal = $('.filter_tanggal').val();

                var exportUrl = '{{ route('rekap_selisih.export_excel') }}?area=' + area +
                    '&waroeng=' + waroeng + '&tanggal=' + tanggal;

                $('#export_loading').show();

                $(this).prop('disabled', true);

                $.ajax({
                    url: exportUrl,
                    method: 'GET',
                    success: function(response) {
                        window.location.href = exportUrl;
                        $(this).prop('disabled', false);

                        setTimeout(function() {
                            $('#export_loading')
                                .hide();
                        }, 2000);
                    },
                    error: function() {
                        $('#export_loading').hide();
                        $('#export_excel').prop('disabled', false);
                    }
                });

            });

            if (HakAksesPusat) {
                $('.filter_area').on('select2:select', function() {
                    var id_area = $(this).val();
                    var tanggal = $('.filter_tanggal').val();
                    var prev = $(this).data('previous-value');

                    if (id_area == 'all') {
                        $("#select_waroeng").hide();
                        $(".filter_waroeng").empty();
                    } else {
                        $("#select_waroeng").show();
                    }

                    if (id_area && tanggal) {
                        $.ajax({
                            type: "GET",
                            url: '{{ route('rekap_wbd.select_waroeng') }}',
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
                                        $(".filter_waroeng").append(
                                            '<option value="' +
                                            key + '">' + value + '</option>'
                                        );
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
                    $("#button_non_menu").hide();
                });
            }

            if (HakAksesArea) {
                $('.filter_waroeng').on('select2:select', function() {
                    var id_waroeng = $(this).val();
                    var tanggal = $('.filter_tanggal').val();
                    var prev = $(this).data('previous-value');

                    if (!id_waroeng || !tanggal) {
                        Swal.fire({
                            title: 'Informasi',
                            text: "Harap lengkapi kolom tanggal",
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-red-500',
                            },
                        });
                        $(".filter_waroeng").val(prev).trigger('change');
                    }
                    if (id_waroeng == 'all') {
                        $("#button_non_menu").hide();
                    }

                });
            }

            $('.filter_tanggal').flatpickr({
                mode: "range",
                dateFormat: 'Y-m-d',
            });

        });
    </script>
@endsection
