@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Rekap Non Menu Penjualan
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label" >Tanggal</label>
                                    <div class="col-sm-9">
                                        <input name="r_t_tanggal" class="cari form-control filter_tanggal" type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" readonly/>
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

                        <div id="user-info" data-waroeng-id="{{ Auth::user()->waroeng_id }}" data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_area) ? 'true' : 'false' }}"></div>
                      <div id="user-info-pusat" data-waroeng-id="{{ Auth::user()->waroeng_id }}" data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_pusat) ? 'true' : 'false' }}"></div>

                        <div class="col-sm-8">
                            <button type="button" id="cari"
                                class="btn btn-primary btn-sm col-1 mt-2 mb-3">Cari</button>
                        </div>

                    </form>      
             
            <div class="table-responsive">
            <table id="tampil_rekap" class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">Area</th>
                        <th rowspan="2" class="text-center">Waroeng</th>
                        <th rowspan="2" class="text-center">Tanggal</th>
                        <th rowspan="2" class="text-center">Sesi</th>
                        <th rowspan="2" class="text-center">Operator</th>
                        <th colspan="3" class="text-center">Dine In</th>
                        <th colspan="3" class="text-center">Take Away</th>
                        <th colspan="3" class="text-center">Grab</th>
                        <th colspan="3" class="text-center">Gojek</th>
                        <th colspan="3" class="text-center">Shopee</th>
                        <th colspan="3" class="text-center">Grab Mart</th>
                        <th colspan="6" class="text-center">Rincian</th>
                    </tr>
                    <tr>
                        <th rowspan="1" class="text-center">Nota</th>
                        <th rowspan="1" class="text-center">Menu</th>
                        <th rowspan="1" class="text-center">Non Menu</th>

                        <th rowspan="1" class="text-center">Nota</th>
                        <th rowspan="1" class="text-center">Menu</th>
                        <th rowspan="1" class="text-center">Non Menu</th>

                        <th rowspan="1" class="text-center">Nota</th>
                        <th rowspan="1" class="text-center">Menu</th>
                        <th rowspan="1" class="text-center">Non Menu</th>

                        <th rowspan="1" class="text-center">Nota</th>
                        <th rowspan="1" class="text-center">Menu</th>
                        <th rowspan="1" class="text-center">Non Menu</th>

                        <th rowspan="1" class="text-center">Nota</th>
                        <th rowspan="1" class="text-center">Menu</th>
                        <th rowspan="1" class="text-center">Non Menu</th>

                        <th rowspan="1" class="text-center">Nota</th>
                        <th rowspan="1" class="text-center">WBD SS</th>
                        <th rowspan="1" class="text-center">WBD Frozen</th>

                        <th rowspan="1" class="text-center">Nota</th>
                        <th rowspan="1" class="text-center">Es Cream</th>
                        <th rowspan="1" class="text-center">Air Mineral</th>
                        <th rowspan="1" class="text-center">Kerupuk</th>
                        <th rowspan="1" class="text-center">WBD BB</th>
                        <th rowspan="1" class="text-center">WBD Frozen</th>
                    </tr>
                </thead>
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

    var userInfo = document.getElementById('user-info');
    var userInfoPusat = document.getElementById('user-info-pusat');
    var waroengId = userInfo.dataset.waroengId;
    var HakAksesArea = userInfo.dataset.hasAccess === 'true';
    var HakAksesPusat = userInfoPusat.dataset.hasAccess === 'true';

    $("#button_non_menu").hide();

    if(HakAksesArea){
        $('.filter_waroeng').on('change', function() {
        var waroeng  = $('.filter_waroeng').val();
        var tanggal  = $('.filter_tanggal').val(); 
        if(waroeng && tanggal){
            $("#button_non_menu").show();  
        }
    });
    } else {
        $('.filter_tanggal').on('change', function() {
        var waroeng  = $('.filter_waroeng').val();
        var tanggal  = $('.filter_tanggal').val(); 
        if(waroeng && tanggal){
            $("#button_non_menu").show();  
        }
    });
    }

    $('#non_menu').on('click', function() {
        var waroeng  = $('.filter_waroeng').val();
        var tanggal  = $('.filter_tanggal').val(); 
        var url = 'rekap_kategori/rekap_non_menu?waroeng='+waroeng+'&tanggal='+tanggal;
        window.open(url,'lap_non_menu.blade.php');
    });

    $('#cari').on('click', function() {
        var area     = $('.filter_area').val();
        var waroeng  = $('.filter_waroeng').val();
        var tanggal  = $('.filter_tanggal').val(); 

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
                        className: 'dt-body-center'
                    },
                ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            ajax: {
                url: '{{route("non_menu.show")}}',
                data : {
                    area: area,
                    waroeng: waroeng,
                    tanggal: tanggal,
                },
                type : "GET",
                },
                success:function(data){ 
                    console.log(data);
                }
        });    
    });

if(HakAksesPusat){
      $('.filter_area').on('select2:select', function(){
        var id_area = $(this).val();
        var tanggal  = $('.filter_tanggal').val();
        var prev = $(this).data('previous-value');
        if(id_area && tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("non_menu.select_waroeng")}}',
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
            $(".filter_area").val(prev).trigger('change');
        }      
        $("#button_non_menu").hide();
    });
  } 

  if(HakAksesArea){
    $('.filter_waroeng').on('select2:select', function(){
        var id_waroeng = $(this).val();   
        var tanggal  = $('.filter_tanggal').val(); 
        var prev = $(this).data('previous-value');
        if(!id_waroeng || !tanggal){
            alert('Harap lengkapi kolom tanggal');
            $(".filter_waroeng").val(prev).trigger('change');
        }  
    });
  }

    $('#filter_tanggal').flatpickr({
            // mode: "range",
            dateFormat: 'Y-m-d',         
    });

});
</script>
@endsection
