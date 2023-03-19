@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Rekap Pembelian Bahan Baku Harian
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label" >Tanggal</label>
                                    <div class="col-sm-9 datepicker">
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

                        <div class="row">
                            <div class="col-8 mb-2">
                                <label class="col-form-label text-dark" style="font-size: 15px"> Tampilkan Performa Pengadaan? </label>
                                        <select id="operator_select" style="width : 15%" class="cari f-wrg js-select2 form-control" name="r_t_m_w_id">
                                            <option value="tidak">Tidak</option>
                                            <option value="ya">ya</option>
                                        </select>
                            </div>
                            <div class="col-sm-5" id="operator">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <select id="filter_pengadaan" style="width: 100%;"
                                            class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Pengadaan" name="rekap_beli_created_by">
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

                    </form>      
                
        <div id="tampil1">
            <table id="tampil_rekap" class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
              <thead>
                <tr>
                    <th class="text-center">Area</th>
                    <th class="text-center">Waroeng</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Total Pembelian</th>
                    <th class="text-center">Terbayar</th>
                    <th class="text-center">Kurang Bayar</th>
                </tr>
              </thead>
              <tbody id="show_data">
              </tbody>
            </table>
        </div>

            <div id="tampil2">
            <table id="tampil_rekap2" class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                <thead>
                  <tr>
                      <th class="text-center">Area</th>
                      <th class="text-center">Waroeng</th>
                      <th class="text-center">Tanggal</th>
                      <th class="text-center">Pengadaan</th>
                      <th class="text-center">Total Pembelian</th>
                      <th class="text-center">Terbayar</th>
                      <th class="text-center">Kurang Bayar</th>
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
        if(waroeng == true){
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
        var pengadaan  = $('#filter_pengadaan').val();  
        var show_pengadaan = $("#operator_select").val();      
        console.log(tanggal);
    if(show_pengadaan == 'ya'){
        $("#tampil1").hide();
        $("#tampil2").show();
        $('#tampil_rekap2').DataTable({
            button: [],
            destroy: true,
            orderCellsTop: true,
            processing: true,
            autoWidth: true,
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            columnDefs: [
                {
                    targets: [0],
                    className: 'dt-body-center'
                },
                {
                    targets: [1, 2, 3, 4, 5, 6, 7, 8],
                    className: 'dt-body-right'
                }
            ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            ajax: {
                url: '{{route("lap_pem_harian.harian_rekap")}}',
                data : {
                    area: area,
                    waroeng: waroeng,
                    tanggal: tanggal,
                    pengadaan: pengadaan,
                    show_operator: show_pengadaan,
                },
                type : "GET",
                },
                success:function(data){ 
                    console.log(data);
                }
        });

    } else {
        $("#tampil2").hide();
        $("#tampil1").show();
        $('#tampil_rekap').DataTable({
            button: [],
            destroy: true,
            orderCellsTop: true,
            processing: true,
            autoWidth: true,
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            // columnDefs: [
            //     {
            //         targets: [0],
            //         className: 'dt-body-center'
            //     },
            //     {
            //         targets: [1, 2, 3, 4, 5, 6, 7, 8],
            //         className: 'dt-body-right'
            //     }
            // ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            ajax: {
                url: '{{route("lap_pem_harian.harian_rekap")}}',
                data : {
                    area: area,
                    waroeng: waroeng,
                    tanggal: tanggal,
                    show_operator: show_pengadaan,
                },
                type : "GET",
                },
                success:function(data){ 
                    console.log(data);
                }
        });    
        }
    });

    $('#filter_area').change(function(){
        var id_area = $(this).val();    
        if(id_area){
            $.ajax({
            type:"GET",
            url: '{{route("lap_pem_detail.select_waroeng_harian")}}',
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

    $('#filter_waroeng').change(function(){
        var id_waroeng = $(this).val();    
        if(id_waroeng){
            $.ajax({
            type:"GET",
            url: '{{route("lap_pem_detail.select_user")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
            },
            success:function(res){               
                if(res){
                    $("#filter_pengadaan").empty();
                    $("#filter_pengadaan").append('<option></option>');
                    $.each(res,function(key,value){
                        $("#filter_pengadaan").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $("#filter_pengadaan").empty();
                }
            }
            });
        }else{
            $("#filter_pengadaan").empty();
        }      
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
