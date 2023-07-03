@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Rekap Penjualan Menu Summary
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
                                                    <option value="all">all area</option>
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

                                <div class="col-sm-5">
                                    <div class="row mb-2" id="select_waroeng">
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
                                <div class="col-md-5" id="select_operator">
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

                            <table id="tampil_rekap"
                                class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                                <thead id="head_data"></thead>
                            </table>
                            {{-- </div>    --}}
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

    let isClicked = false;
    
    $('#cari').on('click', function(e) {
        if (!isClicked) {
            isClicked = true;
        var area     = $('.filter_area').val();
        var waroeng  = $('.filter_waroeng').val();
        var tanggal  = $('.filter_tanggal').val();
        var trans    = $('.filter_trans').val();

        $.ajax({
            url: '{{route("rekap_menu.tanggal_rekap")}}',
            type: 'GET',
            dataType: 'Json',
            data : {
                tanggal: tanggal,
            },
            success: function(data) {
                console.log(data);
                $('#head_data').empty();
                var html = '<tr>';
                html += '<th class="text-center" rowspan="2">Waroeng</th>';
                html += '<th class="text-center" rowspan="2">Transaksi</th>';
                html += '<th class="text-center" rowspan="2">Kategori Menu</th>';
                html += '<th class="text-center" rowspan="2">Nama Menu</th>';
                for (var i = 0; i < data.length; i++) {
                    var dateObj = new Date(Date.parse(data[i]));
                    var dateString = dateObj.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
                    html += '<th class="text-center" colspan="2">' + dateString + '</th>';
                }
                html += '</tr>';
                html += '<tr>';
                var jenis_transaksi = ['Qty', 'Harga'];
                var jumlah_transaksi = jenis_transaksi.length;
                
                for (var i = 0; i < data.length; i++) {
                    for (var j = 0; j < jumlah_transaksi; j++) {
                        html += '<th class="text-center">' + jenis_transaksi[j] + '</th>';
                    }
                }
                html += '</tr>';
                $('#head_data').append(html);

                $('#tampil_rekap').DataTable({
                    destroy: true,
                    orderCellsTop: true,
                    processing: true,
                    scrollX: true,
                    autoWidth: true,
                    scrollCollapse: true,
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: 'Export Excel',
                            title: 'Rekap Menu - ' + trans + ' - ' + tanggal,
                            // exportOptions: {
                            //     columns: [1, 2, 3, 4, 5]
                            // },
                            pageSize: 'A4',
                            pageOrientation: 'potrait',
                        }
                    ],
                    columnDefs: [ 
                        {
                            targets: '_all',
                            className: 'dt-body-center'
                        },
                    ],
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    pageLength: 10,
                    ajax: {
                        url: '{{route("rekap_menu.show")}}',
                        data : {
                            area: area,
                            waroeng: waroeng,
                            tanggal: tanggal,
                            trans: trans,
                        },
                        type : "GET",
                    },
                    });
                }
            });
        
    } else {
        location.reload();
    }
});

if(HakAksesPusat){
      $('.filter_area').on('select2:select', function(){
        var id_area = $(this).val();
        var tanggal  = $('.filter_tanggal').val();
        var prev = $(this).data('previous-value');

        if (id_area == 'all'){
            $("#select_waroeng").hide();
            $("#select_operator").hide();
        } else {
            $("#select_waroeng").show();
            $("#select_operator").show();
        }

        if(id_area && tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_menu.select_waroeng")}}',
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
        $(".filter_trans").empty();  
    });
  } 

  if(HakAksesArea){
    $('.filter_waroeng').on('select2:select', function(){
        var id_waroeng = $(this).val();   
        var tanggal  = $('.filter_tanggal').val(); 
        var prev = $(this).data('previous-value');

        if (id_waroeng == 'all'){
            $("#select_operator").hide();
        } else {
            $("#select_operator").show();
        }
        
        if(id_waroeng && tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_menu.select_trans")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
              tanggal: tanggal,
            },
            success:function(res){   
              console.log(res);       
                if(res){
                    $(".filter_trans").empty();
                    $(".filter_trans").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_trans").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_trans").empty();
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
            $(".filter_trans").empty();
            $(".filter_waroeng").val(prev).trigger('change');
        }      
    });

  } else {

    $('.filter_tanggal').on('change', function(){
        var id_waroeng  = $('.filter_waroeng').val();
        var tanggal  = $('.filter_tanggal').val(); 
        if(tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_menu.select_trans")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
            },
            success:function(res){               
                if(res){
                    $(".filter_trans").empty();
                    $(".filter_trans").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_trans").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_trans").empty();
                }
            }
            });
        }else{
            $(".filter_trans").empty();
        }    
        $(".filter_trans").empty();  
    });
  }

    $('.filter_tanggal').flatpickr({
            mode: "range",
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
