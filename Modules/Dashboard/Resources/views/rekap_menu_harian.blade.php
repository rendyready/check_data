@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Rekap Penjualan Menu Tarikan
                        </h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="rekap_insert">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label">Tanggal</label>
                                        <div class="col-sm-9">
                                            <input name="tmp_tanggal_date" class="cari form-control filter_tanggal"
                                                type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" />
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
                                                name="r_t_created_by">
                                                <option value="all">Tampilkan Semua</option>
                                                <option value="selisih">Hanya Tampilkan Data Selisih</option>
                                            </select>
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
                                        <label class="col-sm-3 col-form-label">Sesi</label>
                                        <div class="col-sm-9">
                                            <select id="filter_sif" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control filter_sif"
                                                data-placeholder="Pilih Sesi" name="sif[]">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label">Transaksi</label>
                                        <div class="col-sm-9">
                                            <select id="filter_trans" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control filter_trans"
                                                data-placeholder="Pilih Tipe Transaksi" name="tipe_trans[]">
                                                <option></option>
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
                            {{-- <div class="text-center mt-2 mb-2">
                            <button id="export_excel" class="btn btn-primary btn-sm">Export Excel</button> --}}

                            <div class="table-responsive">
                                <table id="tampil_rekap"
                                    class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Waroeng</th>
                                            <th class="text-center">Nama Menu</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Nominal Reguler </th>
                                            <th class="text-center">Transaksi</th>
                                            <th class="text-center">Kategori Menu</th>
                                            <th class="text-center">Nominal Transaksi</th>
                                            <th class="text-center">Selisih Reg vs Trans</th>
                                            <th class="text-center">Nominal CR </th>
                                            <th class="text-center">Selisih Reg vs CR</th>
                                            <th class="text-center">Nominal Plus Pajak</th>
                                            <th class="text-center">Selisih Reg vs Pajak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </form>

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

    $('#cari').on('click', function (e) {
        var area = $('.filter_area option:selected').val();
        var waroeng = $('.filter_waroeng option:selected').val();
        var tanggal = $('.filter_tanggal').val();
        var trans = $('.filter_trans option:selected').val();
        var sesi = $('.filter_sif option:selected').val();
        var status = $('.filter_status').val();

        if (tanggal === "" || area === "" || waroeng === "" || sesi === "" || trans === "") {
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
            $.ajax({
            type: "GET",
            url: '{{route("menu_harian.show")}}',
            dataType: 'JSON',
            destroy: true,
            data: {
                area: area,
                waroeng: waroeng,
                tanggal: tanggal,
                trans: trans,
                sesi: sesi,
                status: status,
            },
            success: function (res) {
                if (res.type != 'error') {
                $('#tampil_rekap').DataTable({
                    destroy: true,
                    orderCellsTop: true,
                    processing: true,
                    scrollX: true,
                    autoWidth: true,
                    scrollCollapse: true,
                    buttons: [{
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    title: 'Rekap Menu - ' + trans + ' Sesi - ' + sesi + ' - ' + tanggal,
                    pageSize: 'A4',
                    pageOrientation: 'potrait',
                    }],
                    columnDefs: [{
                    targets: '_all',
                    className: 'dt-body-center'
                    }],
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    pageLength: 10,
                    ajax: {
                    url: '{{route("menu_harian.show")}}',
                    data: {
                        area: area,
                        waroeng: waroeng,
                        tanggal: tanggal,
                        trans: trans,
                        sesi: sesi,
                        status: status,
                    },
                    type: "GET",
                    dataType: "json",
                    },
                });
                } else {
                Swal.fire({
                    title: 'Informasi',
                    text: res.messages,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    customClass: {
                    confirmButton: 'bg-red-500',
                    },
                });
                }
            }
            });
        }
        });

    if(HakAksesPusat){
      $('.filter_area').on('select2:select', function(){
        var id_area = $(this).val();
        var tanggal  = $('.filter_tanggal').val();
        var prev = $(this).data('previous-value');
        if(id_area && tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("menu_harian.select_waroeng")}}',
            dataType: 'JSON',
            destroy: true,    
            data : {
                id_area: id_area,
            },
            success:function(res){    
              // console.log(res);           
                if(res){
                    $(".filter_waroeng").empty();
                    $(".filter_waroeng").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_waroeng").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_waroeng").empty();
                }
            }
            });
        }else{
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
        $(".filter_sif").empty();   
        $(".filter_trans").empty(); 
    });
  } 

  if(HakAksesArea){
    $('.filter_waroeng').on('select2:select', function(){
        var id_waroeng = $(this).val();   
        var id_tanggal  = $('.filter_tanggal').val(); 
        var prev = $(this).data('previous-value');
        if(id_waroeng && id_tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("menu_harian.select_sif")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
              id_tanggal: id_tanggal,
            },
            success:function(res){   
              console.log(res);       
                if(res){
                    $(".filter_sif").empty();
                    $(".filter_sif").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_sif").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_sif").empty();
                }
            }
            });
        }else{
            Swal.fire({
                    title: 'Informasi',
                    text: "Harap lengkapi kolom tanggal",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-red-500',
                    },
                });
            $(".filter_sif").empty();
            $(".filter_waroeng").val(prev).trigger('change');
        }     
        $(".filter_trans").empty();
    });

  } else {

    $('.filter_tanggal').on('change', function(){
        var id_waroeng  = $('.filter_waroeng').val();   
        var id_tanggal  = $('.filter_tanggal').val(); 
        if(id_tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("menu_harian.select_sif")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
              id_tanggal: id_tanggal,
            },
            success:function(res){               
                if(res){
                    $(".filter_sif").empty();
                    $(".filter_sif").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_sif").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_sif").empty();
                }
            }
            });
        }else{
            $(".filter_sif").empty();
        }  
        $(".filter_trans").empty();    
    });
  }

    $('#filter_sif').on('select2:select', function() {
        var id_waroeng  = $('.filter_waroeng').val();  
        var id_sif = $(this).val();    
        if(id_sif !== 'all'){
            $.ajax({
            type:"GET",
            url: '{{route("menu_harian.select_trans")}}',
            dataType: 'JSON',
            data : {
                id_sif: id_sif,
                id_waroeng: id_waroeng,
            },
            success:function(res){               
                if(res){
                    $("#filter_trans").empty();
                    $("#filter_trans").append('<option></option>');
                    $.each(res,function(key,value){
                        $("#filter_trans").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $("#filter_trans").empty();
                }
            }
            });
        }else{
            $("#filter_trans").empty();
        }      
        $("#filter_trans").empty();
    });

    $('.filter_tanggal').flatpickr({
            // mode: "range",
            dateFormat: 'Y-m-d',           
    });

    // $('#export_excel').on('click', function() {
    //             var id = $(this).attr('value');
    //             var waroeng = $('#filter_waroeng').val();
    //             var tanggal = $('#filter_tanggal').val();
    //             var operator = $('#filter_operator').val();
    //             var sesi = $('#filter_sif').val();
    //             var url = 'rekap_menu/export_excel?waroeng='+waroeng+'&tanggal='+tanggal+'&operator='+operator+'&sesi='+sesi;
    //             window.open(url,'_blank');
    //         });

});
</script>
@endsection
