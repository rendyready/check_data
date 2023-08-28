@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Laporan Jurnal</h3>
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
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label">Pembayaran</label>
                                        <div class="col-sm-9">
                                            <select id="filter_pembayaran" style="width: 100%;"
                                                data-placeholder="Pilih Pembayaran"
                                                class="cari f-area js-select2 form-control filter_pembayaran"
                                                name="waroeng">
                                                <option></option>
                                                @foreach ($data->payment as $payment)
                                                    <option value="{{ $payment->m_payment_method_id }}">
                                                        {{ $payment->m_payment_method_name }}
                                                    </option>
                                                @endforeach
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
                            <table id="jurnal_tampil" class="table table-bordered table-striped table-vcenter nowrap">
                                <thead class="justify-content-center">
                                    <tr>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Nomor Akun</th>
                                        <th class="text-center">Akun</th>
                                        <th class="text-center" style="white-space: normal;">Keterangan</th>
                                        <th class="text-center">Debit</th>
                                        <th class="text-center">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody id="dataReload">
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight: bold; background-color: #fac1c1;">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center" id="debitTotalFooter"></th>
                                        <th class="text-center" id="kreditTotalFooter"></th>
                                    </tr>
                                </tfoot>
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

            //filter tampil
            $('#cari').on('click', function() {
                var waroeng = $('.filter_waroeng').val();
                var tanggal = $('.filter_tanggal').val();
                var payment = $('.filter_pembayaran').val();
                var table = $('#jurnal_tampil').DataTable({
                    destroy: true,
                    autoWidth: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: 'Laporan Jurnal - ' + tanggal,
                        pageSize: 'A4',
                        pageOrientation: 'portrait',
                    }],
                    ajax: {
                        url: '{{ route('otomatis.tampil_jurnal') }}',
                        data: {
                            waroeng: waroeng,
                            tanggal: tanggal,
                            payment: payment,
                        },
                        type: "GET",
                    },
                    columns: [{
                            data: 'tanggal',
                            class: 'text-center'
                        },
                        {
                            data: 'no_akun',
                            class: 'text-center'
                        },
                        {
                            data: 'akun',
                            class: 'text-center'
                        },
                        {
                            data: 'particul',
                            class: 'text-center',
                            render: function(data) {
                                return '<div style="white-space: normal;">' + data +
                                    '</div>';
                            }
                        },
                        {
                            data: 'debit',
                            class: 'text-center',
                            render: function(data) {
                                return '<div style="white-space: normal;">' + data +
                                    '</div>';
                            }
                        },
                        {
                            data: 'kredit',
                            class: 'text-center'
                        },
                    ],
                    drawCallback: function(settings) {
                        var api = this.api();
                        var data = api.rows({
                            page: 'current'
                        }).data();

                        var debitTotal = 0;
                        var kreditTotal = 0;

                        for (var i = 0; i < data.length; i++) {
                            if (data[i]['debit']) {
                                debitTotal += parseFloat(data[i]['debit'].replace(/[^0-9.-]+/g,
                                    ""));
                            }
                            if (data[i]['kredit']) {
                                kreditTotal += parseFloat(data[i]['kredit'].replace(
                                    /[^0-9.-]+/g, ""));
                            }
                        }
                        console.log(kreditTotal);
                        $(api.column(4).footer()).html(debitTotal.toLocaleString());
                        $(api.column(5).footer()).html(kreditTotal.toLocaleString());
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
                        $("#select_operator").hide();
                        $(".filter_waroeng").empty();
                        $(".filter_operator").empty();
                    } else {
                        $("#select_waroeng").show();
                        $("#select_operator").show();
                    }

                    if (id_area && tanggal) {
                        $.ajax({
                            type: "GET",
                            url: '{{ route('otomatis.select_waroeng') }}',
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
                        alert('Harap lengkapi kolom tanggal');
                        $(".filter_waroeng").empty();
                        $(".filter_area").val(prev).trigger('change');
                    }
                    $(".filter_operator").empty();
                });
            }

            $('#filter_tanggal').flatpickr({
                dateFormat: 'Y-m-d',
                mode: "range",
            });

        });
    </script>
@endsection
