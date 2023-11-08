@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Monitoring Master Menu
                        </h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="rekap_insert">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label">Area</label>
                                        <div class="col-sm-9">
                                            <select id="filter_area" data-placeholder="Pilih Area" style="width: 100%;"
                                                class="cari f-area js-select2 form-control filter_area"
                                                name="m_w_m_area_id">
                                                <option></option>
                                                @foreach ($data->area as $area)
                                                    <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }}
                                                    </option>
                                                @endforeach
                                                <option value="all">all area</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="row mb-2" id="select_waroeng">
                                        <label class="col-sm-4 col-form-label">Waroeng</label>
                                        <div class="col-sm-8">
                                            <select id="filter_waroeng" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control filter_waroeng"
                                                data-placeholder="Pilih Waroeng" name="m_w_id">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5" id="select_menu">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="rekap_inv_penjualan_created_by">Jenis
                                            Menu</label>
                                        <div class="col-sm-9">
                                            <select id="filter_menu" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control filter_menu"
                                                data-placeholder="Pilih Jenis Menu" name="r_t_created_by">
                                                <option></option>
                                                <option value="all">all jenis menu</option>
                                                @foreach ($data->menu as $menu)
                                                    <option value="{{ $menu->m_jenis_produk_id }}">
                                                        {{ $menu->m_jenis_produk_nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5" id="select_trans">
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_created_by">Jenis
                                            Transaksi</label>
                                        <div class="col-sm-8">
                                            <select id="filter_transaksi" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control filter_transaksi"
                                                data-placeholder="Pilih Jenis Transaksi" name="r_t_created_by">
                                                <option></option>
                                                <option value="all">all jenis transaksi</option>
                                                @foreach ($data->trans as $trans)
                                                    <option value="{{ $trans->m_t_t_id }}"> {{ $trans->m_t_t_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <button type="button" id="cari"
                                    class="btn btn-primary btn-sm col-1 mt-2 mb-3">Cari</button>
                            </div>
                        </form>

                        <table id="tampil_rekap"
                            class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text_center">Area</th>
                                    <th class="text_center">Waroeng</th>
                                    <th class="text_center">Menu</th>
                                    <th class="text_center">Harga</th>
                                    <th class="text_center">Jenis Transaksi</th>
                                    <th class="text_center">Jenis Nota</th>
                                    <th class="text_center">Status Menu</th>
                                    <th class="text_center">Pajak</th>
                                    <th class="text_center">Service Charge</th>
                                    <th class="text_center">Status Kirim</th>
                                    <th class="text_center">Last Update</th>
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

            //tampil data
            $('#cari').on('click', function() {
                var area = $('.filter_area option:selected').val();
                var waroeng = $('.filter_waroeng option:selected').val();
                var menu = $('.filter_menu option:selected').val();
                var trans = $('.filter_transaksi option:selected').val();
                if ((menu === "" || area === "") && waroeng === "" && trans === "") {
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
                    var table = $('#tampil_rekap').DataTable({
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
                            url: '{{ route('status_menu.show') }}',
                            data: {
                                area: area,
                                waroeng: waroeng,
                                menu: menu,
                                trans: trans,
                            },
                            type: "GET",
                        },
                        success: function(data) {
                            console.log(data);

                        },
                    });
                    table.ajax.reload();
                }
            });

            //filter waroeng
            $('.filter_area').on('select2:select', function() {
                var area = $(this).val();
                var prev = $(this).data('previous-value');

                if (area == 'all') {
                    $("#select_waroeng").hide();
                    $(".filter_waroeng").empty();
                } else {
                    $("#select_waroeng").show();
                }

                if (area) {
                    $.ajax({
                        type: "GET",
                        url: '{{ route('status_menu.select_waroeng') }}',
                        dataType: 'JSON',
                        destroy: true,
                        data: {
                            area: area,
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
                }
            });

        });
    </script>
@endsection
