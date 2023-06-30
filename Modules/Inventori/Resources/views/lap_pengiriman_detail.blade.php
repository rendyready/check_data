@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Detail Pengiriman Bahan Baku
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">
                      <div class="row">
                        <div class="col-md-5">
                            <div class="row mb-1">
                                <label class="col-sm-3 col-form-label" >Tanggal</label>
                                <div class="col-sm-9">
                                    <input name="r_t_tanggal" class="cari form-control form-control filter_tanggal" type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                      <div class="row">
                            <div class="col-sm-5">
                                <div class="row mb-2">
                                    <label class="col-sm-3 col-form-label">Cabang</label>
                                    <div class="col-sm-9">
                                      @if (in_array(Auth::user()->waroeng_id, $data->suplay_pusat ))
                                          <select id="filter_cabang1" style="width: 100%;"
                                              class="cari f-wrg js-select2 form-control filter_cabang" data-placeholder="Pilih Kantor Suplay" name="m_w_id">
                                              <option></option>
                                              @foreach ($data->waroeng as $waroeng)
                                                  <option value="{{ $waroeng->m_w_id }}"> {{ $waroeng->m_w_nama }} </option>
                                              @endforeach
                                          </select>
                                      @else
                                          <select id="filter_cabang2" style="width: 100%;"
                                          class="cari f-area js-select2 form-control filter_cabang" name="m_w_m_area_id" disabled>
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
                                <label class="col-sm-3 col-form-label" for="rekap_inv_penjualan_created_by">Operator</label>
                                <div class="col-sm-9">
                                    <select id="filter_operator" style="width: 100%;"
                                    class="cari f-wrg js-select2 form-control filter_operator" data-placeholder="Pilih Operator" name="rekap_beli_created_by">
                                    <option></option>
                                </select>
                                </div>
                              </div>
                          </div>
                        </div>

                      <div id="user-info-pusat" data-waroeng-id="{{ Auth::user()->waroeng_id }}" data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->suplay_pusat) ? 'true' : 'false' }}"></div>

                        <div class="col-sm-8">
                            <button type="button" id="cari" class="btn btn-primary btn-sm col-1 mt-2 mb-5">Cari</button>
                    </div>
                </form>
              <div id="show_nota" class="row">       
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

    var userInfoPusat = document.getElementById('user-info-pusat');
    var waroengId = userInfoPusat.dataset.waroengId;
    var HakAksesPusat = userInfoPusat.dataset.hasAccess === 'true';

    $('#cari').click(function(){
        var cabang  = $('.filter_cabang').val();
        var tanggal  = $('.filter_tanggal').val();
        var operator = $('.filter_operator').val(); 
        console.log(status);
        $('.show_nota').remove(); 
            $.ajax({
            type:"GET",
            url: '{{route("lap_kirim_detail.tampil_detail")}}',
            dataType: 'JSON',
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            data : 
            {
              cabang: cabang,
              tanggal: tanggal,
              operator: operator,
            },
            success:function(data){  
              $.each(data.transaksi_rekap2, function (key, value) {
                // console.log(item.r_t_id); 
                  $('#show_nota').append('<div class="col-xl-4 show_nota">'+
                        '<div class="block block-rounded mb-1">'+
                          '<div class="block-header block-header-default block-header-rtl bg-pulse">'+
                            '<h3 class="block-title text-light"><small class="fw-semibold">'+ value.rekap_beli_code +'</small><br><small>'+ value.rekap_beli_supplier_nama +'</small></h3>'+
                            '<div class="alert alert-warning py-2 mb-0">'+
                              '<h3 class="block-title text-black"><i class="fa fa-calendar opacity-50 ms-1"></i> <small>'+ value.rekap_beli_tgl +'</small>'+
                                '<br><small class="fw-semibold">'+ value.name +'</small></h3>'+
                            '</div>'+
                          '</div>'+
                          '<div class="block-content mb-4" style="background-color: rgba(224, 224, 224, 0.5)">'+
                            '<table class="table table-border table-striped table-vcenter js-dataTable-full" style="font-size: 13px;">'+
                              '<thead id="sub_nota'+ value.rekap_beli_code +'">'+
                                '</thead>'+
                              '<tbody>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Sub Total</td>'+
                                  '<td>'+
                                    ''+ formatNumber(Number(value.rekap_beli_sub_tot)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                    '<td>PPN ' + (value.rekap_beli_disc ? '('+ formatNumber(Number(value.rekap_beli_ppn)) +')' : '') + '</td>' +
                                  '<td>'+
                                    ''+ formatNumber(Number(value.rekap_beli_ppn_rp)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                    '<td>Diskon Nota ' + (value.rekap_beli_disc ? '('+ formatNumber(Number(value.rekap_beli_disc)) +')' : '') + '</td>' +
                                  '<td>'+
                                    ''+ formatNumber(Number(value.rekap_beli_disc_rp)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Total Bayar </td>'+
                                  '<td>'+
                                    ''+ formatNumber(Number(value.rekap_beli_tot_nom)) +''+
                                  '</td>'+
                                '</tr>'+
                              '</tbody>'+
                            '</table>'+
                          '</div>'+
                        '</div>'+
                      '</div>');
                  });
                    $.each(data.detail_nota, function (key, item) {
                        // console.log(item.r_t_detail_r_t_id);
                        $('#sub_nota'+ item.rekap_beli_detail_rekap_beli_code).append(
                                '<tr style="background-color: white;" class="show_nota">'+
                                  '<td>'+
                                    '<small class="fw-semibold" style="font-size: 15px;">'+ item.rekap_beli_detail_m_produk_nama +'</small> <br>'+
                                    '<small>'+ Number(item.rekap_beli_detail_qty) +' x '+ formatNumber(Number(item.rekap_beli_detail_harga)) +'</small><br>'+
                                    '<small>' + 
                                        (
                                            item.rekap_beli_detail_disc == null || item.rekap_beli_detail_disc == 0 ? 
                                            '' :
                                            'Diskon BB ('+ Number(item.rekap_beli_detail_disc) +' %)'
                                        ) + 
                                        (
                                            item.rekap_beli_detail_discrp == 0 ? 
                                            '' :
                                            item.rekap_beli_detail_disc == 1 ? 
                                            ' + '+ formatNumber(Number(item.rekap_beli_detail_discrp)) : 
                                            'Diskon BB '+ formatNumber(Number(item.rekap_beli_detail_discrp))
                                        ) + 
                                    '</small>'+
                                  '</td>'+
                                  '<td class="text-end fw-semibold" >'+ formatNumber(Number(item.rekap_beli_detail_subtot)) + ''+
                                  '</td>'+
                                '</tr>'
                          );
                      });
            }           
          });          
    });

    $('#filter_area').change(function(){
        var id_area = $(this).val();    
        if(id_area){
            $.ajax({
            type:"GET",
            url: '{{route("lap_pem_detail.select_waroeng")}}',
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

    // $('#filter_tanggal').flatpickr({
    //         mode: "range",
    //         dateFormat: 'Y-m-d',   
    // });

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

    $(".filter_tanggal").flatpickr({
            mode: "range",
            dateFormat: 'Y-m-d',   
    });

});
</script>
@endsection
