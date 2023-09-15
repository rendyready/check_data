@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Rekap Non Menu Penjualan
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
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <button type="button" id="cari"
                                                class="btn btn-primary btn-sm mb-3 mt-1">Cari</button>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="btn-group">
                                                <button type="button" id="button_drop"
                                                    class="btn btn-sm btn-primary dropdown-toggle mt-1">
                                                    Export Excel <span id="export_loading" style="display: none;"><img
                                                            src="{{ asset('media/gif/loading.gif') }}" alt="Loading..."
                                                            style="max-width: 16px; max-height: 16px;"></span>
                                                </button>
                                                <div class="dropdown-menu" id="dropdown-menu"
                                                    style="position: absolute; top: 100%; left: 5%; background-color:rgba(235, 25, 25, 0.123);">
                                                    <button class="dropdown-item" style="font-weight:550;"
                                                        id="hari">Export
                                                        Per Hari</button>
                                                    <button class="dropdown-item" style="font-weight: 550;"
                                                        id="bulan">Export
                                                        Per Bulan</button>
                                                </div>
                                            </div>


                                            {{-- <div class="col-md-4">
                                            <a class="btn btn-sm btn-primary mb-3 mt-1" id="export_excel"
                                                style="display: none;">Export Excel <span id="export_loading"
                                                    style="display: none;"><img src="{{ asset('media/gif/loading.gif') }}"
                                                        alt="Loading..."
                                                        style="max-width: 16px; max-height: 16px;"></span></a> --}}
                                        </div>
                                    </div>
                                </div>



                        </form>

                        <div id="tampil" class="table-responsive text-center">
                            <table id="tampil_rekap"
                                class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">Area</th>
                                        <th rowspan="2" class="text-center">Waroeng</th>
                                        <th rowspan="2" class="text-center">Tanggal</th>
                                        <th rowspan="2" class="text-center">Sesi</th>
                                        <th rowspan="2" class="text-center">Operator</th>
                                        <th colspan="5" class="text-center">Dine In</th>
                                        <th colspan="5" class="text-center">Take Away</th>
                                        <th colspan="5" class="text-center">Grab</th>
                                        <th colspan="5" class="text-center">Gojek</th>
                                        <th colspan="5" class="text-center">Shopee</th>
                                        <th colspan="3" class="text-center">Grab Mart</th>
                                        <th colspan="5" class="text-center">Rincian</th>
                                        <th rowspan="2" class="text-center">Pajak Reguler</th>
                                        <th rowspan="2" class="text-center">Pajak Ojol</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="1" class="text-center">Menu</th>
                                        <th rowspan="1" class="text-center">Menu (P)</th>
                                        <th rowspan="1" class="text-center">Menu (TP)</th>
                                        <th rowspan="1" class="text-center">Non Menu</th>
                                        <th rowspan="1" class="text-center">Nota</th>

                                        <th rowspan="1" class="text-center">Menu</th>
                                        <th rowspan="1" class="text-center">Menu (P)</th>
                                        <th rowspan="1" class="text-center">Menu (TP)</th>
                                        <th rowspan="1" class="text-center">Non Menu</th>
                                        <th rowspan="1" class="text-center">Nota</th>

                                        <th rowspan="1" class="text-center">Menu</th>
                                        <th rowspan="1" class="text-center">Menu (P)</th>
                                        <th rowspan="1" class="text-center">Menu (TP)</th>
                                        <th rowspan="1" class="text-center">Non Menu</th>
                                        <th rowspan="1" class="text-center">Nota</th>

                                        <th rowspan="1" class="text-center">Menu</th>
                                        <th rowspan="1" class="text-center">Menu (P)</th>
                                        <th rowspan="1" class="text-center">Menu (TP)</th>
                                        <th rowspan="1" class="text-center">Non Menu</th>
                                        <th rowspan="1" class="text-center">Nota</th>

                                        <th rowspan="1" class="text-center">Menu</th>
                                        <th rowspan="1" class="text-center">Menu (P)</th>
                                        <th rowspan="1" class="text-center">Menu (TP)</th>
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

            $("#tampil").hide();
            $("#export_excel").show();

            $('#cari').on('click', function() {
                var area = $('.filter_area option:selected').val();
                var waroeng = $('.filter_waroeng option:selected').val();
                var tanggal = $('.filter_tanggal').val();

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

                    $("#tampil").show();
                    $('#tampil_rekap').DataTable({
                        buttons: [],
                        destroy: true,
                        orderCellsTop: true,
                        processing: true,
                        autoWidth: true,
                        scrollX: true,
                        scrollCollapse: true,
                        columnDefs: [{
                            targets: '_all',
                            className: 'dt-body-center'
                        }, ],
                        // buttons: [{
                        //     extend: 'excelHtml5',
                        //     text: 'Export Excel',
                        //     title: 'Laporan Rekap Non Menu - ' + tanggal,
                        //     pageSize: 'A4',
                        //     pageOrientation: 'portrait',
                        //     exportOptions: {
                        //         columns: [0, 1, 2, 3, 4, 5, 8, 9, 10, 13, 14, 15, 18, 19,
                        //             20, 23, 24, 25, 28, 29, 30, 33, 34, 35, 36, 37, 38,
                        //             39, 40, 41
                        //         ],
                        //     },
                        // }],
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ],
                        pageLength: 10,
                        ajax: {
                            url: '{{ route('non_menu.show') }}',
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

            $('#button_drop').on('click', function() {
                $('#dropdown-menu').toggle();
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('.btn-group').length) {
                    $('#dropdown-menu').hide();
                }
            });

            $('#hari').on('click', function() {
                var area = $('.filter_area option:selected').val();
                var waroeng = $('.filter_waroeng option:selected').val();
                var tanggal = $('.filter_tanggal').val();

                var exportUrl = '{{ route('non_menu.export_excel') }}?area=' + area +
                    '&waroeng=' + waroeng + '&tanggal=' + tanggal;

                $('#export_loading').show();

                var $buttonHari = $(this);

                $buttonHari.prop('disabled', true);

                $('.dropdown-menu').hide();

                $.ajax({
                    url: exportUrl,
                    method: 'GET',
                    success: function(response) {
                        window.location.href = exportUrl;
                        $buttonHari.prop('disabled', false);

                        setTimeout(function() {
                            $('#export_loading')
                                .hide();
                        }, 2000);
                    },
                    error: function() {
                        $('#export_loading').hide();
                    }
                });
            });

            $('#bulan').on('click', function() {
                var area = $('.filter_area option:selected').val();
                var waroeng = $('.filter_waroeng option:selected').val();
                var tanggal = $('.filter_tanggal').val();

                var exportUrl = '{{ route('non_menu.export_excel_month') }}?area=' + area +
                    '&waroeng=' + waroeng + '&tanggal=' + tanggal;

                $('#export_loading').show();

                var $buttonHari = $(this);

                $buttonHari.prop('disabled', true);

                $('.dropdown-menu').hide();

                $.ajax({
                    url: exportUrl,
                    method: 'GET',
                    success: function(response) {
                        window.location.href = exportUrl;
                        $buttonHari.prop('disabled', false);

                        setTimeout(function() {
                            $('#export_loading')
                                .hide();
                        }, 2000);
                    },
                    error: function() {
                        $('#export_loading').hide();
                        // $('#export_excel').prop('disabled', false);
                    }
                });
            });

            // $('#export_excel').on('click', function() {
            //     var area = $('.filter_area option:selected').val();
            //     var waroeng = $('.filter_waroeng option:selected').val();
            //     var tanggal = $('.filter_tanggal').val();

            //     var exportUrl = '{{ route('non_menu.export_excel') }}?area=' + area +
            //         '&waroeng=' + waroeng + '&tanggal=' + tanggal;

            //     $('#export_loading').show();

            //     $(this).prop('disabled', true);

            //     $.ajax({
            //         url: exportUrl,
            //         method: 'GET',
            //         success: function(response) {
            //             window.location.href = exportUrl;
            //             $(this).prop('disabled', false);

            //             setTimeout(function() {
            //                 $('#export_loading')
            //                     .hide();
            //             }, 2000);
            //         },
            //         error: function() {
            //             $('#export_loading').hide();
            //             $('#export_excel').prop('disabled', false);
            //         }
            //     });
            // });

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
                            url: '{{ route('non_menu.select_waroeng') }}',
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
