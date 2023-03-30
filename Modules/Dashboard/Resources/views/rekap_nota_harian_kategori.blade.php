@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Rekap Summary Penjualan
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label" >Tanggal</label>
                                    <div class="col-sm-9">
                                        <input name="r_t_tanggal" class="cari form-control" type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" />
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
                                            <option value="0">All Area</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="row mb-2">
                                    <label class="col-sm-3 col-form-label">Waroeng</label>
                                    <div class="col-sm-9">
                                        <select id="filter_waroeng" style="width: 100%;"
                                            class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Waroeng" name="r_t_m_w_id">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-8 mb-2">
                                <label class="col-form-label text-dark" style="font-size: 15px"> Tampilkan Performa Operator? </label>
                                        <select id="operator_select" style="width : 15%" class="cari f-wrg js-select2 form-control" name="r_t_m_w_id">
                                            <option value="tidak">Tidak</option>
                                            <option value="ya">ya</option>
                                        </select>
                            </div>
                            <div class="col-sm-5" id="operator">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <select id="filter_operator" style="width: 100%;"
                                            class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Nama Operator" name="r_t_created_by">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-sm-8">
                            <button type="button" id="cari"
                                class="btn btn-primary btn-sm col-1 mt-2 mb-3">Cari</button>
                        </div>

                    </form>      
                
        <div id="tampil1">
            <table id="tampil_rekap" class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                <thead id="head_data">
                </thead>
            </table>
        </div>

            <div id="tampil2">
              <table id="tampil_rekap2" class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                <thead id="head_data">
                </thead>
            </table>
            </div>

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
    $("#tampil1").hide();
    $("#tampil2").hide();
    $("#operator").hide();

    $('#operator_select').on('select2:select', function() {
        var cek = $(this).val();
        var waroeng  = $('#filter_waroeng').val();
        if(waroeng > 1){
            if(cek == 'ya') {
                $("#operator").show();
            } else {
                $("#operator").hide();
            }
        } else {
            alert('Silahkan pilih waroeng terlebih dahulu');
            $("#operator_select").val("tidak").trigger('change');
        }
    });

    $('#cari').on('click', function() {
        var area     = $('#filter_area').val();
        var waroeng  = $('#filter_waroeng').val();
        var tanggal  = $('#filter_tanggal').val(); 
        var operator  = $('#filter_operator').val();  
        var show_operator = $("#operator_select").val(); 
        if(show_operator == 'ya'){
        $("#tampil1").hide();
        $("#tampil2").show();
        $.ajax({
        url: '{{route("rekap_kategori.tanggal_rekap")}}',
        type: 'GET',
        dataType: 'Json',
        data : {
            tanggal: tanggal,
            operator: operator,
            waroeng: waroeng,
        },
        success: function(data) {
            console.log(data);
            $('#head_data').empty();
            var html = '<tr>';
            html += '<th class="text-center" rowspan="2">Area</th>';
            html += '<th class="text-center" rowspan="2">Waroeng</th>';
            html += '<th class="text-center" rowspan="2">Tanggal</th>';
            html += '<th class="text-center" rowspan="2">Operator</th>';
            for (var i = 0; i < data.length; i++) {
                    html += '<th class="text-center" colspan="4">' + data[i] + '</th>';
            }
            html += '</tr>';
            html += '<tr>';
            var jenis_transaksi = ['tunai', 'pajak tunai', 'transfer', 'pajak transfer'];
            var jumlah_transaksi = jenis_transaksi.length;
            
            for (var i = 0; i < data.length; i++) {
                for (var j = 0; j < jumlah_transaksi; j++) {
                    html += '<th class="text-center">' + jenis_transaksi[j] + '</th>';
                }
            }
            
            html += '</tr>';
            $('#head_data').append(html);
        
        $('#tampil_rekap2').DataTable({
            destroy: true,
            orderCellsTop: true,
            processing: true,
            autoWidth: true,
            // scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            columnDefs: [ 
                    {
                        targets: '_all',
                        className: 'dt-body-right'
                    },
                ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            ajax: {
                url: '{{route("rekap_kategori.show")}}',
                data : {
                    area: area,
                    waroeng: waroeng,
                    tanggal: tanggal,
                    operator: operator,
                    show_operator: show_operator,
                },
                type : "GET",
                },
                success:function(data){ 
                    console.log(data);
                }
        });
    }
    });
        
    } else {
        $("#tampil2").hide();
        $("#tampil1").show();
        $.ajax({
        url: '{{route("rekap_kategori.tanggal_rekap")}}',
        type: 'GET',
        dataType: 'Json',
        data : {
            tanggal: tanggal,
            operator: operator,
            waroeng: waroeng,
        },
        success: function(data) {
            console.log(data);
            $('#head_data').empty();
            var html = '<tr>';
            html += '<th class="text-center" rowspan="2">Area</th>';
            html += '<th class="text-center" rowspan="2">Waroeng</th>';
            html += '<th class="text-center" rowspan="2">Tanggal</th>';
            for (var i = 0; i < data.length; i++) {
                    html += '<th class="text-center" colspan="4">' + data[i] + '</th>';
            }
            html += '</tr>';
            html += '<tr>';
            var jenis_transaksi = ['tunai', 'pajak tunai', 'transfer', 'pajak transfer'];
            var jumlah_transaksi = jenis_transaksi.length;
            
            for (var i = 0; i < data.length; i++) {
                for (var j = 0; j < jumlah_transaksi; j++) {
                    html += '<th class="text-center">' + jenis_transaksi[j] + '</th>';
                }
            }
            html += '</tr>';
            $('#head_data').append(html);

        $('#tampil_rekap').DataTable({
            button: [],
            destroy: true,
            orderCellsTop: true,
            processing: true,
            autoWidth: true,
            // scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            columnDefs: [ 
                    {
                        targets: '_all',
                        className: 'dt-body-right'
                    },
                ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            ajax: {
                url: '{{route("rekap_kategori.show")}}',
                data : {
                    area: area,
                    waroeng: waroeng,
                    tanggal: tanggal,
                    show_operator: show_operator,
                },
                type : "GET",
                },
                success:function(data){ 
                    console.log(data);
                }
        });    
        
    }
    });
    }
    });

    //filter waroeng
    $('#filter_area').change(function(){
        var id_area = $(this).val();  
    //     var show_operator = $("#operator_select").val();      
    // if(show_operator == 'tidak'){  
        if(id_area){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_kategori.select_waroeng")}}',
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
    // } else {
    //     $("#operator_select").val("tidak").trigger('change');
    //     $("#operator").hide();
    // }    
    });

    //filter pengadaan
    $('#filter_waroeng').change(function(){
        var id_waroeng = $(this).val();   
        // var show_operator = $("#operator_select").val();      
    // if(show_operator == 'tidak'){   
        if(id_waroeng){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_kategori.select_user")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
            },
            success:function(res){               
                if(res){
                    $("#filter_operator").empty();
                    $("#filter_operator").append('<option></option>');
                    $.each(res,function(key,value){
                        $("#filter_operator").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $("#filter_operator").empty();
                }
            }
            });
        }else{
            $("#filter_operator").empty();
        }    
    // } 
    // else {
    //     $("#operator_select").val("tidak").trigger('change');
    //     $("#operator").hide();
    // }     
    });

    $('#filter_tanggal').flatpickr({
            mode: "range",
            dateFormat: 'Y-m-d',
            // noCalendar: false,
            // allowInput: true,            
    });

});
</script>
@endsection
