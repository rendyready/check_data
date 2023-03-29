@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Rekap Penjualan Menu
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">
                        @csrf
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label" >Tanggal</label>
                                    <div class="col-sm-9">
                                        <input name="tmp_tanggal_date" class="cari form-control" type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" />
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-2">
                                    <label class="col-sm-3 col-form-label">Area</label>
                                    <div class="col-sm-9">
                                        <select id="filter_area" data-placeholder="Pilih Area" style="width: 100%;"
                                            class="cari f-area js-select2 form-control" name="r_t_m_area_id">
                                            <option></option>
                                            @foreach ($data->area as $area)
                                                <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }} </option>
                                            @endforeach
                                            <option value="all">All Area</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="row mb-2">
                                    <label class="col-sm-3 col-form-label">Waroeng</label>
                                    <div class="col-sm-9">
                                        <select id="filter_waroeng" style="width: 100%;"
                                            class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Waroeng" name="r_t_m_w_id[]">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label" >Shift</label>
                                    <div class="col-sm-9">
                                        <select id="filter_sif" style="width: 100%;"
                                            class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Shift" name="sif[]">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label" >Transaksi</label>
                                    <div class="col-sm-9">
                                        <select id="filter_trans" style="width: 100%;"
                                            class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Tipe Transaksi" name="tipe_trans[]">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="col-sm-8">
                            <button type="button" id="cari"
                                class="btn btn-primary btn-sm col-1 mt-2 mb-3">Cari</button>
                        </div>                
            <table id="tampil_rekap" class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                <thead id="head_data"></thead>
            </table>
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

    $('#cari').on('click', function() {
    var area     = $('#filter_area').val();
    var waroeng  = $('#filter_waroeng').val();
    var tanggal  = $('#filter_tanggal').val();
    var trans    = $('#filter_trans').val();
    var sesi     = $('#filter_sif').val();
    
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
            html += '<th class="text-center">Waroeng</th>';
            html += '<th class="text-center">Kategori Menu</th>';
            html += '<th class="text-center">Nama Menu</th>';
            for (var i = 0; i < data.length; i++) {
                html += '<th class="text-center">Qty</th>';
                var dateObj = new Date(Date.parse(data[i]));
                var dateString = dateObj.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
                html += '<th class="text-center date">' + dateString + '</th>';
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
                        title: 'Laporan Penjualan Menu Harian',
                        pageSize: 'A4',
                        pageOrientation: 'potrait',
                        exportOptions: {
                            columns: [2, 3, 4 ]
                        },
                    }
                ],
                columnDefs: [ 
                    {
                        targets: '_all',
                        className: 'dt-body-right'
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
                        sesi: sesi,
                    },
                    type : "GET",
                },
                });

            }
        });
    });

    $('#filter_area').change(function(){
        var id_area = $(this).val();    
        if(id_area){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_menu.select_waroeng")}}',
            dataType: 'JSON',
            data : {
                id_area: id_area,
            },
            success:function(res){               
                if(res){
                    $("#filter_waroeng").empty();
                    $("#filter_waroeng").append('<option></option>');
                    $.each(res,function(key,value){
                        $("#filter_waroeng").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $("#filter_waroeng").empty();
                }
            }
            });
        }else{
            $("#filter_waroeng").empty();
        }      
    });

    $('#filter_waroeng').on('select2:select', function() {
        var id_waroeng = $(this).val();    
        var id_area     = $('#filter_area').val();
        var id_tanggal  = $('#filter_tanggal').val();
        if(id_waroeng){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_menu.select_sif")}}',
            dataType: 'JSON',
            data : {
                id_waroeng: id_waroeng,
                id_area: id_area,
                id_tanggal: id_tanggal,
            },
            success:function(res){               
                if(res){
                    $("#filter_sif").empty();
                    $("#filter_sif").append('<option></option>');
                    $.each(res,function(key,value){
                        $("#filter_sif").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $("#filter_sif").empty();
                }
            }
            });
        }else{
            $("#filter_sif").val('').trigger('change');
        }      
    });

    $('#filter_sif').on('select2:select', function() {
        var id_sif = $(this).val();    
        if(id_sif){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_menu.select_trans")}}',
            dataType: 'JSON',
            data : {
                id_sif: id_sif,
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
            $("#filter_trans").val('').trigger('change');
        }      
    });

    $('#filter_tanggal').flatpickr({
            mode: "range",
            dateFormat: 'Y-m-d',           
    });

});
</script>
@endsection
