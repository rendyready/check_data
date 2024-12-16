@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Monitoring Data Rekap
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

                            <div class="col-sm-8">
                                <button type="button" id="cari"
                                    class="btn btn-primary btn-sm col-1 mt-2 mb-3">Check</button>
                            </div>
                        </form>

                        <div id="tampil_count">
                            <table id="tampil_count_data"
                                class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text_center">Tanggal</th>
                                        <th class="text_center">ID Waroeng</th>
                                        <th class="text_center">Waroeng</th>
                                        <th class="text_center">Nama Table</th>
                                        <th class="text_center">Jumlah Pusat</th>
                                        <th class="text_center">Jumlah Area</th>
                                        <th class="text_center">Waktu Pengecekan</th>
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
@endsection
@section('js')
    <!-- js -->
    <script type="module">
        $(document).ready(function() {
            Codebase.helpersOnLoad(['jq-select2']);

            function formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            $('#tampil_count').hide();

            $('#filter_tanggal').flatpickr({
                mode: "range",
                dateFormat: 'Y-m-d',
            });

            //tampil data
            $('#cari').on('click', function() {
                var tanggal = $('#filter_tanggal').val();
                $('#tampil_count').show();

                $('#tampil_count_data').DataTable({
                    destroy: true,
                    orderCellsTop: true,
                    processing: true,
                    scrollX: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    pageLength: 10,
                    columnDefs: [{
                        targets: '_all',
                        className: 'dt-body-center'
                    }, ],
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: 'Cek Status Menu',
                        pageSize: 'A4',
                        pageOrientation: 'potrait',
                    }],
                    ajax: {
                        url: '{{ route('count.tampil') }}',
                        data: {
                            tanggal: tanggal,
                        },
                        type: "GET",
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });
            });

        });
    </script>
@endsection
