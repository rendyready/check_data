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
                            <div class="col-md-5">
                                <div class="row mb-2">
                                    <label class="col-sm-3 col-form-label">Operator</label>
                                    <div class="col-sm-9">
                                        <select id="filter_operator" data-placeholder="Pilih Operator" style="width: 100%;"
                                            class="cari f-area js-select2 form-control filter_operator" name="operator">
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
             
            <div id="rekap_non_menu">
            <table id="tampil_rekap" class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                <thead id="head_data">
                </thead>
            </table>
            <div class="col-sm-8">
                <button type="button" id="non_menu"
                    class="btn btn-primary btn-sm mt-2 mb-3">Lihat Rekap Non Menu</button>
            </div>
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
    $("#rekap_non_menu").hide();

    // let isClicked = false;
    // let counter = 0;

    // if (!isClicked) {
    //     isClicked = true;
    //     $('#filter_tanggal').on('change', function(e) {
    //         counter++;
    //         if (counter > 2) {
    //             location.reload();
    //         }
    //     });
    // }

    $('#non_menu').on('click', function() {
        var waroeng  = $('#filter_waroeng').val();
        var tanggal  = $('#filter_tanggal').val(); 
        var url = 'rekap_kategori/rekap_non_menu?waroeng='+waroeng+'&tanggal='+tanggal;
        window.open(url,'lap_non_menu.blade.php');
    });

    let isClicked = false;

    $('#cari').on('click', function() {
        if (!isClicked) {
            isClicked = true;
        var area     = $('#filter_area').val();
        var waroeng  = $('#filter_waroeng').val();
        var tanggal  = $('#filter_tanggal').val(); 
        var sesi  = $('#filter_sesi').val();  
        $("#rekap_non_menu").show();
        
        $.ajax({
        url: '{{route("rekap_kategori.tanggal_rekap")}}',
        type: 'GET',
        dataType: 'Json',
        data : {
            tanggal: tanggal,
            waroeng: waroeng,
        },
        success: function(data) {
            console.log(data);
            $('#head_data').empty();
            var html = '<tr>';
            html += '<th class="text-center" rowspan="2">Area</th>';
            html += '<th class="text-center" rowspan="2">Waroeng</th>';
            html += '<th class="text-center" rowspan="2">Operator</th>';
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
            // columnDefs: [ 
            //         {
            //             targets: '_all',
            //             className: 'dt-body-right'
            //         },
            //     ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            ajax: {
                url: '{{route("rekap_kategori.show")}}',
                data : {
                    area: area,
                    waroeng: waroeng,
                    tanggal: tanggal,
                    sesi: sesi,
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
        location.reload();
    }
});

    //filter waroeng
    $('#filter_area').change(function(){
        var id_area = $(this).val();  
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
    });

    // // filter opr
    // $('#filter_waroeng').change(function(){
    //     var id_waroeng = $(this).val();    
    //     var id_area     = $('#filter_area').val();
    //     var id_tanggal  = $('#filter_tanggal').val();
    //     if(id_waroeng){
    //         $.ajax({
    //         type:"GET",
    //         url: '{{route("rekap_kategori.select_user")}}',
    //         dataType: 'JSON',
    //         data : {
    //           id_waroeng: id_waroeng,
    //           id_area: id_area,
    //           id_tanggal: id_tanggal,
    //         },
    //         success:function(res){               
    //             if(res){
    //                 $("#filter_operator").empty();
    //                 $("#filter_operator").append('<option></option>');
    //                 $.each(res,function(key,value){
    //                     $("#filter_operator").append('<option value="'+key+'">'+value+'</option>');
    //                 });
    //             }else{
    //             $("#filter_operator").empty();
    //             }
    //         }
    //         });
    //     }else{
    //         $("#filter_operator").empty();
    //     }       
    // });

    $('#filter_tanggal').flatpickr({
            // mode: "range",
            dateFormat: 'Y-m-d',
            // noCalendar: false,
            // allowInput: true,            
    });

});
</script>
@endsection
