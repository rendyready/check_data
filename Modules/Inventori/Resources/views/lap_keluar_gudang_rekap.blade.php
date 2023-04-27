@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Rekap Keluar & Terima Bahan Baku
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">

                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label" >Tanggal </label>
                                    <div class="col-sm-9">
                                        <input name="r_t_tanggal" class="cari form-control filter_tanggal" type="text" placeholder="Pilih Tanggal Barang Masuk" id="filter_tanggal" readonly/>
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
                            <div class="col-md-5">
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="rekap_inv_penjualan_created_by">Pengadaan</label>
                                    <div class="col-sm-9">
                                        <select id="filter_pengadaan" style="width: 100%;"
                                        class="cari f-wrg js-select2 form-control filter_pengadaan" data-placeholder="Pilih Pengadaan" name="rekap_beli_created_by">
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
            <table id="tampil_rekap" class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full">
                <thead>
                  <tr>
                    <th class="text-center">Tanggal Masuk Gudang</th>
                    <th class="text-center">Tanggal Keluar Gudang</th>
                    <th class="text-center">Pengadaan</th>
                    <th class="text-center">Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
        </div>
      </div>
    </div>
    </div>
</div>

 <!-- Select2 in a modal -->
 <div class="modal" id="detail_nota" tabindex="-1" role="dialog" aria-labelledby="form-rekening" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="block-content">
          <!-- Select2 is initialized at the bottom of the page -->
            <div class="mb-4">
                  <div class="block block-rounded mb-1">
                    <div class="block-header block-header-default block-header-rtl bg-pulse">
                      <h3 class="block-title text-light"><i class="fa fa-calendar opacity-50 ms-1"></i> <small id="tgl_out"></small><small> (out)</small><br><small class="fw-semibold" id="no_nota"></small></h3>
                      <div class="alert alert-warning py-2 mb-0">
                        <h3 class="block-title text-black"><i class="fa fa-calendar opacity-50 ms-1"></i> <small id="tgl_in"></small><small> (in)</small>
                          <br><small class="fw-semibold" id="pengadaan"></small></h3>
                      </div>
                    </div>
                    <div class="block-content mb-4" style="background-color: rgba(224, 224, 224, 0.5)">
                      <table class="table table-border" style="font-size: 13px;">
                        @foreach ($data->gudang as $gudang)
                        <thead class="sub_nota" id="sub_nota{{ $gudang->rekap_tf_gudang_code }}">
                        </thead> 
                        @endforeach
                          <tbody>
                          <tr style="background-color: white;" class="text-end fw-semibold">
                            <td>total</td>
                            <td id="total">
                            </td>
                          </tr>
                          </tr>
                        </tbody>
                      </table>
                      <div class="mb-3 text-end">
                      <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
      </div>
    </div>
  </div>
<!-- END Select2 in a modal -->

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
        var waroeng     = $('.filter_waroeng').val();
        var tanggal     = $('.filter_tanggal').val();
        var pengadaan   = $('.filter_pengadaan').val();

    $('#tampil_rekap').DataTable({
        button: [],
        destroy: true,
        orderCellsTop: true,
        processing: true,
        scrollX: true,
        autoWidth: false,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        pageLength: 10,
        columnDefs: [
                {
                    targets: '_all',
                    className: 'dt-center'
                }
            ],
        ajax: {
            url: '{{route("lap_gudang_rekap.tampil_rekap")}}',
            data : {
                waroeng: waroeng,
                tanggal: tanggal,
                pengadaan: pengadaan,
            },
            type : "GET",
            },
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
            url: '{{route("lap_gudang_detail.select_waroeng")}}',
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
        $(".filter_operator").empty(); 
        $(".filter_status").val(prev).trigger('change');
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
            url: '{{route("lap_gudang_detail.select_user")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
                tanggal: tanggal,
            },
            success:function(res){   
              console.log(res);       
                if(res){
                    $(".filter_pengadaan").empty();
                    $(".filter_pengadaan").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_pengadaan").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_pengadaan").empty();
                }
            }
            });
        }else{
          alert('Harap lengkapi kolom tanggal');
            $(".filter_pengadaan").empty();
            $(".filter_waroeng").val(prev).trigger('change');
        }    
        $(".filter_status").val(prev).trigger('change');  
    });

  } else {

    $('.filter_tanggal').on('change', function(){
        var id_waroeng  = $('.filter_waroeng').val(); 
        var tanggal  = $('.filter_tanggal').val(); 
        var prev = $(this).data('previous-value');
        if(id_waroeng && tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("lap_gudang_detail.select_user")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
              tanggal: tanggal,
            },
            success:function(res){               
                if(res){
                    $(".filter_pengadaan").empty();
                    $(".filter_pengadaan").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_pengadaan").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_pengadaan").empty();
                }
            }
            });
        }else{
            $(".filter_pengadaan").empty();
        }     
        $(".filter_pengadaan").empty(); 
        $(".filter_status").val(prev).trigger('change');
    });
  }

    $('.filter_tanggal').flatpickr({
        mode: "range",
        dateFormat: 'Y-m-d',
    });
    
    $('#tampil_rekap').on('click','#button_detail', function() {
      var id        = $(this).attr('value');
      $('#show_nota').empty();
      $.ajax({
          url: "/inventori/lap_gudang_rekap/detail_rekap/"+id,
            type: "GET",
            dataType: 'json',
            destroy: true,
            success: function(data) {
            console.log(data.detail1.rekap_tf_gudang_code);

                    $('#no_nota').html(data.detail1.rekap_tf_gudang_code);
                    $('#gudang').html(data.detail1.m_gudang_nama);
                      $('#tgl_in').html(data.detail1.tgl_keluar);
                      $('#tgl_out').html(data.detail1.tgl_tujuan);
                    $('#pengadaan').html(data.detail1.name);
                    $('#total').html(formatNumber(Number(data.detail1.total)));
                             
                    $('.sub_sub_nota').remove();
                    $.each(data.detail2, function (key, item) {  
                        console.log(item.rekap_tf_gudang_m_produk_nama);
                        $('#sub_nota'+id).append(
                                '<tr class="sub_sub_nota" style="background-color: white;">'+
                                    '<td>'+
                                    '<small class="fw-semibold" style="font-size: 15px;">'+ item.rekap_tf_gudang_m_produk_nama +'</small><small> (hpp : Rp. '+ formatNumber(Number(item.rekap_tf_gudang_hpp)) +')</small><br>'+
                                   '<small> <small style="font-size: 11px;" class="fw-semibold">masuk gudang : </small>'+ Number(item.rekap_tf_gudang_qty_keluar) +' '+ item.rekap_tf_gudang_satuan_keluar +'</small> <br> <small> <small style="font-size: 11px;" class="fw-semibold">keluar gudang : </small> : '+ Number(item.rekap_tf_gudang_qty_terima) +' '+ item.rekap_tf_gudang_satuan_terima +'</small></td><td class="text-end fw-semibold" id+="sub_total">'+ formatNumber(Number(item.rekap_tf_gudang_sub_total)) +'</td>'+
                                '</tr>'
                          );
                      });
                  }  
                });
                $("#detail_nota").modal('show');
            }); 

});
</script>
@endsection
