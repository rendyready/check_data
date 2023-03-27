@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Detail Nota Penjualan
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">
                      <div class="row">
                        <div class="col-md-5">
                            <div class="row mb-1">
                                <label class="col-sm-3 col-form-label" >Tanggal</label>
                                <div class="col-sm-9 datepicker">
                                    <input name="r_t_tanggal" class="cari form-control form-control" type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" readonly/>
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
                                            class="cari f-area js-select2 form-control" name="m_w_m_area_id">
                                            <option></option>
                                            @foreach ($data->area as $area)
                                                <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="row mb-2">
                                    <label class="col-sm-3 col-form-label">Waroeng</label>
                                    <div class="col-sm-9">
                                        <select id="filter_waroeng" style="width: 100%;"
                                            class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Waroeng" name="m_w_id">
                                            <option></option>
                                        </select>
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
                                        class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Operator" name="r_t_created_by">
                                        <option></option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                              <div class="row mb-3">
                                  <label class="col-sm-3 col-form-label" for="status">Status</label>
                                  <div class="col-sm-9">
                                      <select id="filter_status" style="width: 100%;"
                                      class="cari f-wrg2 js-select2 form-control" data-placeholder="Pilih Status Pembayaran" name="r_t_created_by">
                                      <option></option>
                                      <option value="paid">Terbayar</option>
                                      <option value="unpaid">Tidak Terbayar</option>
                                  </select>
                                  </div>
                              </div>
                          </div>
                        </div> 
                        <div class="col-sm-8">
                            <button type="button" id="cari" class="btn btn-primary btn-sm col-1 mt-2 mb-5">Cari</button>
                    </div>
                </form>
              <div id="show_nota" class="row">       
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

    $('#cari').click(function(){
        var waroeng  = $('#filter_waroeng').val();
        var tanggal  = $('#filter_tanggal').val();
        var operator = $('#filter_operator').val(); 
        var status   = $('#filter_status').val();  
        console.log(status);
        $('.show_nota').remove(); 
        if(status == 'paid'){
            $.ajax({
            type:"GET",
            url: '{{route("detail.show")}}',
            dataType: 'JSON',
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            data : 
            {
              waroeng: waroeng,
              tanggal: tanggal,
              operator: operator,
              status: status,
            },
            success:function(data){  
              $.each(data.transaksi_rekap2, function (key, value) {
                // console.log(item.r_t_id);
                  $('#show_nota').append('<div class="col-xl-4 show_nota">'+
                        '<div class="block block-rounded mb-1">'+
                          '<div class="block-header block-header-default block-header-rtl bg-pulse">'+
                            '<h3 class="block-title text-light"><small class="fw-semibold">'+ value.r_t_nota_code +'</small><br><small>'+ value.m_t_t_name +'</small></h3>'+
                            '<div class="alert alert-warning py-2 mb-0">'+
                              '<h3 class="block-title text-black"><i class="fa fa-calendar opacity-50 ms-1"></i> <small>'+ value.r_t_tanggal +'</small>'+
                                '<br><small class="fw-semibold">'+ value.name +'</small></h3>'+
                            '</div>'+
                          '</div>'+
                          '<div class="block-content mb-4" style="background-color: rgba(224, 224, 224, 0.5)">'+
                            '<table class="table table-border table-striped table-vcenter js-dataTable-full" style="font-size: 13px;">'+
                              '<thead id="sub_nota'+ value.r_t_id +'">'+
                                '</thead>'+
                              '<tbody>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Total</td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_t_nominal)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Tax (10%)</td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_t_nominal_pajak)) +''+
                                  '</td>'+
                                '</tr>'+

                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Service Charge</td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_t_nominal_sc)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Diskon</td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_t_nominal_diskon)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Voucher</td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_t_nominal_voucher)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Tarik Tunai</td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_t_nominal_tarik_tunai)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Pembulatan</td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_t_nominal_pembulatan)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Free Kembalian</td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_t_nominal_free_kembalian)) +''+
                                  '</td>'+
                                '</tr>'+

                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Bayar ('+ value.m_payment_method_type +') </td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_t_nominal_total_bayar) - Number(value.r_t_nominal_free_kembalian) - Number(value.r_t_nominal_pembulatan)) +''+
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
                        $('#sub_nota'+ item.r_t_detail_r_t_id).append(
                                '<tr style="background-color: white;" class="show_nota">'+
                                  '<td>'+
                                    '<small class="fw-semibold" style="font-size: 15px;">'+ item.r_t_detail_m_produk_nama +'</small> <br>'+
                                    '<small>'+ item.r_t_detail_qty +' x '+ formatNumber(Number(item.r_t_detail_price)) +'</small>'+
                                  '</td>'+
                                  '<td class="text-end fw-semibold" >'+ formatNumber(Number(item.r_t_detail_nominal)) + ''+
                                  '</td>'+
                                '</tr>'
                          );
                      });
            }           
          });  
        } else {

          $.ajax({
            type:"GET",
            url: '{{route("detail.show")}}',
            dataType: 'JSON',
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            data : 
            {
              waroeng: waroeng,
              tanggal: tanggal,
              operator: operator,
              status: status,
            },
            success:function(data){  
              $.each(data.transaksi_rekap2, function (key, value) {
                // console.log(item.r_t_id);
                  $('#show_nota').append('<div class="col-xl-4 show_nota">'+
                        '<div class="block block-rounded mb-1">'+
                          '<div class="block-header block-header-default block-header-rtl bg-warning">'+
                            '<h3 class="block-title text-light"><small class="fw-semibold">'+ value.r_l_b_nota_code +'</small><br><small>Approve by <br> '+ value.name +'</small></h3>'+
                            '<div class="alert alert-warning py-2 mb-0">'+
                              '<h3 class="block-title text-black"><i class="fa fa-calendar opacity-50 ms-1"></i> <small>'+ value.r_l_b_tanggal +'</small>'+
                                '<br><small class="fw-semibold">'+ value.name +'</small></h3>'+
                            '</div>'+
                          '</div>'+
                          '<div class="block-content mb-4" style="background-color: rgba(224, 224, 224, 0.5)">'+
                            '<table class="table table-border table-striped table-vcenter js-dataTable-full" style="font-size: 13px;">'+
                              '<thead id="sub_nota'+ value.r_l_b_id +'">'+
                                '</thead>'+
                              '<tbody>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Total</td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_l_b_nominal)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Tax (10%)</td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_l_b_nominal_pajak)) +''+
                                  '</td>'+
                                '</tr>'+
                                '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                  '<td>Total Lostbill </td>'+
                                  '<td class="mask">'+
                                    ''+ formatNumber(Number(value.r_l_b_nominal) + Number(value.r_l_b_nominal_pajak)) +''+
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
                        $('#sub_nota'+ item.r_l_b_detail_r_l_b_id).append(
                                '<tr style="background-color: white;" class="show_nota">'+
                                  '<td>'+
                                    '<small class="fw-semibold" style="font-size: 15px;">'+ item.r_l_b_detail_m_produk_nama +'</small> <br>'+
                                    '<small>'+ item.r_l_b_detail_qty +' x '+ formatNumber(Number(item.r_l_b_detail_price)) +'</small>'+
                                  '</td>'+
                                  '<td class="text-end fw-semibold" >'+ formatNumber(Number(item.r_l_b_detail_nominal)) + ''+
                                  '</td>'+
                                '</tr>'
                          );
                      });
            }           
          });

        }         
    });

    $('#filter_area').change(function(){
        var id_area = $(this).val();    
        if(id_area){
            $.ajax({
            type:"GET",
            url: '{{route("detail.select_waroeng")}}',
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

    $('#filter_tanggal').flatpickr({
            mode: "range",
            dateFormat: 'Y-m-d',   
    });

    $('#filter_waroeng').change(function(){
        var id_waroeng = $(this).val();    
        if(id_waroeng){
            $.ajax({
            type:"GET",
            url: '{{route("detail.select_user")}}',
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
    });

});
</script>
@endsection
