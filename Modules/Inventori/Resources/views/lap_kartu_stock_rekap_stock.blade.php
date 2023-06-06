@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Rekap Stock
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">

                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" >Tanggal</label>
                                    <div class="col-sm-9">
                                        <input name="r_t_tanggal" class="cari form-control filter_tanggal" type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" readonly/>
                                    </div>
                                </div>
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

                            <div class="col-sm-6">
                                <div class="row mb-3">
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
                            <div class="col-md-5">
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="rekap_inv_penjualan_created_by">Gudang</label>
                                    <div class="col-sm-9">
                                        @if (!in_array(Auth::user()->waroeng_id, $data->akses_area ))
                                            <select id="filter_gudang1" data-placeholder="Pilih Gudang" style="width: 100%;"
                                            class="cari f-area js-select2 form-control filter_gudang" name="m_w_m_area_id">
                                            <option></option>
                                            @foreach ($data->gudang as $gudang)
                                                <option value="{{ $gudang->m_gudang_code }}"> {{ $gudang->m_gudang_nama }} </option>
                                            @endforeach
                                            </select>
                                        @else
                                            <select id="filter_gudang2" style="width: 100%;"
                                            class="cari f-wrg js-select2 form-control filter_gudang" data-placeholder="Pilih Gudang" name="m_stok_gudang_code">
                                            <option></option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="rekap_inv_penjualan_created_by">Klasifikasi</label>
                                    <div class="col-sm-9">
                                        <select id="filter_bb" data-placeholder="Pilih Klasifikasi Bahan Baku" style="width: 100%;"
                                            class="cari f-area js-select2 form-control filter_bb" name="m_w_m_area_id">
                                            <option></option>
                                            @foreach ($data->bb as $bb)
                                                <option value="{{ $bb->m_klasifikasi_produk_id }}"> {{ $bb->m_klasifikasi_produk_nama }} </option>
                                            @endforeach
                                            <option value="all">All Klasifikasi BB</option></option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                        </div> 

                        <div id="user-info" data-waroeng-id="{{ Auth::user()->waroeng_id }}" data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_area) ? 'true' : 'false' }}"></div>
                      <div id="user-info-pusat" data-waroeng-id="{{ Auth::user()->waroeng_id }}" data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_pusat) ? 'true' : 'false' }}"></div>

                        <div class="col-sm-8">
                            <button type="button" id="cari"
                                class="btn btn-primary btn-sm col-1 mt-2 mb-3">Cari</button>
                        </div>
                    </form>    
                
            <table id="tampil_rekap" class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full">
              <thead>
                <tr>
                  <th class="text-center">Gudang</th>
                  {{-- <th class="text-center">Klasifikasi</th> --}}
                  <th class="text-center">Bahan Baku</th>
                  <th class="text-center">Stok Awal</th>
                  <th class="text-center">Masuk</th>
                  <th class="text-center">Keluar</th>
                  <th class="text-center">Stok Akhir</th>
                  <th class="text-center">Satuan</th>
                  <th class="text-center">HPP Barang</th>
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

    var userInfo = document.getElementById('user-info');
    var userInfoPusat = document.getElementById('user-info-pusat');
    var waroengId = userInfo.dataset.waroengId;
    var HakAksesArea = userInfo.dataset.hasAccess === 'true';
    var HakAksesPusat = userInfoPusat.dataset.hasAccess === 'true';

    $('#cari').on('click', function() {
        var tanggal = $('.filter_tanggal').val();
        var area    = $('.filter_area').val();
        var waroeng = $('.filter_waroeng').val();
        var gudang  = $('.filter_gudang').val();
        // var bb      = $('.filter_bb').val();

    $('#tampil_rekap').DataTable({
        buttons: [],
        destroy: true,
        orderCellsTop: true,
        processing: true,
        scrollX: true,
        // autoWidth : '100%',
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        pageLength: 10,
        columnDefs: [ 
            { className: 'dt-center', targets: '_all' },
        ],
        ajax: {
            url: '{{route("rekap_stock.tampil_rekap")}}',
            data : {
                tanggal: tanggal,
                area: area,
                waroeng: waroeng,
                gudang: gudang,
                // bb: bb,
            },
            type : "GET",
            },
            success:function(data){ 
                console.log(data);
            },
        });
    });

    //filter waroeng
    $('.filter_area').change(function(){
        var id_area = $(this).val();
        if(id_area){
            $.ajax({
            type:"GET",
            url: '{{route("kartu_stock.select_waroeng")}}',
            dataType: 'JSON',
            destroy: true,    
            data : {
                id_area: id_area,
            },
            success:function(res){               
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
            $(".filter_waroeng").empty();
        }      
    });

    if(HakAksesArea){
        $('.filter_waroeng').on('select2:select', function(){
            var waroeng = $(this).val();   
            var prev = $(this).data('previous-value');
                $.ajax({
                type:"GET",
                url: '{{route("kartu_stock.select_gudang_rekap")}}',
                dataType: 'JSON',
                data : {
                    waroeng: waroeng,
                },
                success:function(res){   
                console.log(res);       
                    if(res){
                        $(".filter_gudang").empty();
                        $(".filter_gudang").append('<option></option>');
                        $.each(res,function(key,value){
                            $(".filter_gudang").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }else{
                    $(".filter_gudang").empty();
                    }
                }
                });
        });
    }

    $('.filter_tanggal').flatpickr({
            mode: "range",
            dateFormat: 'Y-m-d',  
    });

});
</script>
@endsection
