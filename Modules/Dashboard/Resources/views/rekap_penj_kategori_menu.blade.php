@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Rekap Penjualan Kategori Menu
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label" >Tanggal</label>
                                    <div class="col-sm-9">
                                        <input name="r_t_tanggal" class="cari form-control filter_tanggal" type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end" id="button_non_menu" width=100%>
                                <button type="button" id="non_menu"
                                    class="btn btn-primary mt-0 mb-2">Lihat Rekap Non Menu</button>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-2">
                                    <label class="col-sm-3 col-form-label">Area</label>
                                    <div class="col-sm-9">
                                        @if (in_array(Auth::user()->waroeng_id, $data->akses_pusat ))
                                            <select id="filter_area2" data-placeholder="Pilih Area" style="width: 100%;"
                                            class="cari f-area js-select2 form-control filter_area" name="m_w_m_area_id">
                                            <option></option>
                                            @foreach ($data->area as $area)
                                                <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }} </option>
                                            @endforeach
                                            </select>
                                        @else
                                            <select id="filter_area" data-placeholder="Pilih Area" style="width: 100%;"
                                            class="cari f-area js-select2 form-control filter_area" name="m_w_m_area_id" disabled>
                                            <option value="{{ ucwords($data->area_nama->m_area_id) }}">{{ ucwords($data->area_nama->m_area_nama) }}</option>
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
                                            class="cari f-wrg js-select2 form-control filter_waroeng" data-placeholder="Pilih Waroeng" name="m_w_id">
                                            <option></option>
                                            </select>
                                        @elseif (in_array(Auth::user()->waroeng_id, $data->akses_pusar))
                                            <select id="filter_waroeng3" style="width: 100%;" data-placeholder="Pilih Waroeng"
                                            class="cari f-area js-select2 form-control filter_waroeng" name="waroeng">
                                            <option></option>
                                            @foreach ($data->waroeng as $waroeng)
                                                <option value="{{ $waroeng->m_w_id }}"> {{ $waroeng->m_w_nama }} </option>
                                            @endforeach
                                            </select>
                                        @else
                                            <select id="filter_waroeng2" style="width: 100%;"
                                            class="cari f-area js-select2 form-control filter_waroeng" name="waroeng" disabled>
                                            <option value="{{ ucwords($data->waroeng_nama->m_w_id) }}">{{ ucwords($data->waroeng_nama->m_w_nama) }}</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
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
                                            class="cari f-wrg js-select2 form-control filter_operator" data-placeholder="Pilih Nama Operator" name="r_t_created_by">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="user-info" data-waroeng-id="{{ Auth::user()->waroeng_id }}" data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_area) ? 'true' : 'false' }}"></div>
                      <div id="user-info-pusat" data-waroeng-id="{{ Auth::user()->waroeng_id }}" data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_pusat) ? 'true' : 'false' }}"></div>

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
                    @foreach ($data->payment as $payment)
                    <th class="text-center">{{ $payment->m_jenis_produk_nama }}</th>
                    @endforeach
                    <th class="text-center">Total</th>
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
                      <th class="text-center">Operator</th>
                      @foreach ($data->payment as $payment)
                      <th class="text-center">{{ $payment->m_jenis_produk_nama }}</th>
                      @endforeach
                      <th class="text-center">Total</th>
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
    var userInfo = document.getElementById('user-info');
    var userInfoPusat = document.getElementById('user-info-pusat');
    var waroengId = userInfo.dataset.waroengId;
    var HakAksesArea = userInfo.dataset.hasAccess === 'true';
    var HakAksesPusat = userInfoPusat.dataset.hasAccess === 'true';

    $("#tampil1").hide();
    $("#tampil2").hide();
    $("#operator").hide();

    $("#button_non_menu").hide();

    if(HakAksesArea){
        $('.filter_waroeng').on('change', function() {
            var waroeng = $('.filter_waroeng').val();
            var tanggal = $('.filter_tanggal').val();
            var isRange = tanggal.includes('to'); 

            if (waroeng && isRange) {    
                $("#button_non_menu").hide();
            } else {
                $("#button_non_menu").show();
            }
        });

    } else if (HakAksesPusat) {
        $('.filter_area').on('change', function() {
            var area = $('.filter_area').val();
            var tanggal = $('.filter_tanggal').val();
            var isRange = tanggal.includes('to'); 

            if (area && isRange) {    
                $("#button_non_menu").hide();
            } else {
                $("#button_non_menu").show();
            }
        });

    } else {
    
        $('.filter_tanggal').on('change', function() {
            var waroeng = $('.filter_waroeng').val();
            var tanggal = $('.filter_tanggal').val();
            var isRange = tanggal.includes('to'); 

            if (waroeng && isRange) {    
                $("#button_non_menu").hide();
            } else {
                $("#button_non_menu").show();
            }
            if(isRange){
                $("#button_non_menu").hide();
            }
        });
    }

    $('.filter_tanggal').on('change', function() {
        var tanggal = $('.filter_tanggal').val();
        var isRange = tanggal.includes('to'); 
        var waroeng = $('.filter_waroeng').val();
        if(isRange){
            $("#button_non_menu").hide();
        } else if (!isRange && waroeng){
            $("#button_non_menu").show();
        }
    });

    $('#non_menu').on('click', function() {
        var waroeng  = $('.filter_waroeng').val();
        var tanggal  = $('.filter_tanggal').val(); 
        var url = 'rekap_penj_kat/rekap_non_menu?waroeng='+waroeng+'&tanggal='+tanggal;
        window.open(url,'lap_non_menu.blade.php');
    });

    $('#operator_select').on('select2:select', function() {
        var cek = $(this).val();
        var waroeng  = $('.filter_waroeng').val();
        var tanggal  = $('.filter_tanggal').val(); 
        if(HakAksesArea){
            if(waroeng > 0){
                if(cek == 'ya') {
                    $("#operator").show();
                } else {
                    $("#operator").hide();
                }
            } else {
                alert('Silahkan pilih waroeng terlebih dahulu');
                $("#operator_select").val("tidak").trigger('change');
            }
        } else {
            if(tanggal){
                if(cek == 'ya') {
                    $("#operator").show();
                } else {
                    $("#operator").hide();
                }
            } else {
                alert('Silahkan tentukan tanggal terlebih dahulu');
                $("#operator_select").val("tidak").trigger('change');
            }
        }
    });

    $('#cari').on('click', function() {
        var area     = $('.filter_area').val();
        var waroeng  = $('.filter_waroeng').val();
        var tanggal  = $('.filter_tanggal').val(); 
        var operator  = $('.filter_operator').val();  
        var show_operator = $("#operator_select").val();      
    if(show_operator == 'ya'){
        $("#tampil1").hide();
        $("#tampil2").show();
        $('#tampil_rekap2').DataTable({
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
                    className: 'dt-body-center'
                },
            ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            ajax: {
                url: '{{route("rekap_penj_kat.show")}}',
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
                url: '{{route("rekap_penj_kat.show")}}',
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

    if(HakAksesPusat){
      $('.filter_area').on('select2:select', function(){
        var id_area = $(this).val();
        var tanggal  = $('.filter_tanggal').val();
        var prev = $(this).data('previous-value');
        if(id_area && tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_penj_kat.select_waroeng")}}',
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
          alert('Harap lengkapi kolom tanggal');
            $(".filter_waroeng").empty();
        }     
        $(".filter_operator").empty();
        $("#button_non_menu").hide();
        $("#operator_select").val("tidak").trigger('change');
        $("#operator").hide();
    });
  } 

  if(HakAksesArea){
    $('.filter_waroeng').on('select2:select', function(){
        var id_waroeng = $(this).val();   
        var tanggal  = $('.filter_tanggal').val(); 
        var prev = $(this).data('previous-value');
        if(id_waroeng && tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_penj_kat.select_user")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
              tanggal: tanggal,
            },
            success:function(res){   
              console.log(res);       
                if(res){
                    $(".filter_operator").empty();
                    $(".filter_operator").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_operator").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_operator").empty();
                }
            }
            });
        }else{
          alert('Harap lengkapi kolom tanggal');
            $(".filter_operator").empty();
        }      
    });

  } else {

    $('.filter_tanggal').on('change', function(){
        var tanggal  = $('.filter_tanggal').val(); 
        if(tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_penj_kat.select_user")}}',
            dataType: 'JSON',
            data : {
              tanggal: tanggal,
            },
            success:function(res){               
                if(res){
                    $(".filter_operator").empty();
                    $(".filter_operator").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_operator").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_operator").empty();
                }
            }
            });
        }else{
            $(".filter_operator").empty();
        }      
    });
  }

  $('.filter_tanggal').flatpickr({
        mode: "range",
        dateFormat: 'Y-m-d',
  });

});
</script>
@endsection
