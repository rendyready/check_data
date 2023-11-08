@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Monitoring Master Jumlah Menu
                        </h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="rekap_insert">

                            <div class="row">
                                <div class="col-md-5">
                                    <label class="col-sm-6 col-form-label"> Jenis Pengecekan Data</label>
                                    <div class="row mb-2">

                                        <div class="col-sm-9">
                                            <select id="filter_area" data-placeholder="Pilih Jenis Pengecekan"
                                                style="width: 100%;" class="cari f-area js-select2 form-control filter_area"
                                                name="m_w_m_area_id">
                                                <option></option>
                                                <option value="count">By Jumlah Data</option>
                                                <option value="check">By Perbedaan Data</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-sm-8">
                                <button type="button" id="cari"
                                    class="btn btn-primary btn-sm col-1 mt-2 mb-3">Cari</button>
                            </div> --}}
                        </form>

                        <div id="tampil_count">
                            <table id="tampil_count_data"
                                class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text_center">Tanggal</th>
                                        <th class="text_center">Area</th>
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

            //tampil data
            $('#cari').on('click', function() {
                // var area = $('.filter_area').val();
                // var waroeng = $('.filter_waroeng').val();
                // var menu = $('.filter_menu').val();
                // var trans = $('.filter_transaksi').val();
                // $('#tampil_rekap').DataTable({
                //     destroy: true,
                //     orderCellsTop: true,
                //     processing: true,
                //     scrollX: true,
                //     lengthMenu: [
                //         [10, 25, 50, 100, -1],
                //         [10, 25, 50, 100, "All"]
                //     ],
                //     pageLength: 10,
                //     columnDefs: [{
                //         targets: '_all',
                //         className: 'dt-body-center'
                //     }, ],
                //     buttons: [{
                //         extend: 'excelHtml5',
                //         text: 'Export Excel',
                //         title: 'Cek Status Menu',
                //         pageSize: 'A4',
                //         pageOrientation: 'potrait',
                //     }],
                //     ajax: {
                //         url: '{{ route('compare_menu.show') }}',
                //         data: {
                //             area: area,
                //             waroeng: waroeng,
                //             menu: menu,
                //             trans: trans,
                //         },
                //         type: "GET",
                //     },
                //     success: function(data) {
                //         console.log(data);
                //     }
                // });
            });

            //filter waroeng
            $('.filter_area').on('select2:select', function() {
                // var area = $(this).val();
                // var prev = $(this).data('previous-value');

                // if (area == 'all') {
                //     $("#select_waroeng").hide();
                // } else {
                //     $("#select_waroeng").show();
                // }

                // if (area) {
                //     $.ajax({
                //         type: "GET",
                //         url: '{{ route('compare_menu.select_waroeng') }}',
                //         dataType: 'JSON',
                //         destroy: true,
                //         data: {
                //             area: area,
                //         },
                //         success: function(res) {
                //             // console.log(res);           
                //             if (res) {
                //                 $(".filter_waroeng").empty();
                //                 $(".filter_waroeng").append('<option></option>');
                //                 $.each(res, function(key, value) {
                //                     $(".filter_waroeng").append('<option value="' +
                //                         key + '">' + value + '</option>');
                //                 });
                //             } else {
                //                 $(".filter_waroeng").empty();
                //             }
                //         }
                //     });
                // }
            });

        });
    </script>
@endsection
