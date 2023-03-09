@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Rekap Refund
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
                        </div> 

                        <div class="col-sm-8">
                            <button type="button" id="cari"
                                class="btn btn-primary btn-sm col-1 mt-2 mb-3">Cari</button>
                        </div>
                    </form>      
                
            <table id="tampil_rekap" class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full">
              <thead>
                <tr>
                  <th colspan="2" class="text-center">Tanggal</th>
                  <th colspan="2" class="text-center">Operator</th>
                  <th colspan="2" class="text-center"></th>
                  <th colspan="2" class="text-center">Sub Total</th>
                  <th colspan="2" class="text-center">Tax</th>
                  <th colspan="2" class="text-center">Service Charge</th>
                  <th colspan="2" class="text-center">Pembulatan</th>
                  <th colspan="2" class="text-center">Free Kembalian</th>
                  <th colspan="2" class="text-center">Total</th>
                </tr>
                <tr>
                  <th rowspan="1">Nota Asli</th>
                  <th rowspan="1">Nota Refund</th>
                  <th rowspan="1">Nota Asli</th>
                  <th rowspan="1">Nota Refund</th>
                  <th>Big Bos</th>
                  <th>No. Nota</th>
                  <th rowspan="1">Nota Asli</th>
                  <th rowspan="1">Nota Refund</th>
                  <th rowspan="1">Nota Asli</th>
                  <th rowspan="1">Nota Refund</th>
                  <th rowspan="1">Nota Asli</th>
                  <th rowspan="1">Nota Refund</th>
                  <th rowspan="1">Nota Asli</th>
                  <th rowspan="1">Nota Refund</th>
                  <th rowspan="1">Nota Asli</th>
                  <th rowspan="1">Nota Refund</th>
                  <th rowspan="1">Nota Asli</th>
                  <th rowspan="1">Nota Refund</th>
                  <th rowspan="1">Selisih</th>
                  <th rowspan="1"></th>
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

<!-- Select2 in a modal -->
<div class="modal" id="detail_nota" tabindex="-1" role="dialog" aria-labelledby="form-rekening" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="block-content">
            <!-- Select2 is initialized at the bottom of the page -->
              <div class="mb-4">
                    <div class="block block-rounded mb-1">
                      <div class="block-header block-header-default block-header-rtl bg-pulse">
                        <h3 class="block-title text-light"><small class="fw-semibold" id="no_nota"></small><br><small id="ket_trans"></small></h3>
                        <div class="alert alert-warning py-2 mb-0">
                          <h3 class="block-title text-black"><i class="fa fa-calendar opacity-50 ms-1"></i> <small id="tgl_nota"></small>
                            <br><small class="fw-semibold" id="nama_kons"></small></h3>
                        </div>
                      </div>
                      <div class="block-content mb-4" style="background-color: rgba(224, 224, 224, 0.5)">
                        <table class="table table-border" style="font-size: 13px;">
                          @foreach ($data->transaksi_rekap as $rekap)
                          <thead class="sub_nota" id="sub_nota{{ $rekap->r_r_id }}">
                          </thead> 
                          @endforeach
                            <tbody>
                            <tr style="background-color: white;" class="text-end fw-semibold">
                              <td>Total</td>
                              <td id="total">
                              </td>
                            </tr>
                            <tr style="background-color: white;" class="text-end fw-semibold">
                              <td>Tax (10%)</td>
                              <td id="pajak">
                              </td>
                            </tr>

                            <tr style="background-color: white;" class="text-end fw-semibold">
                              <td>Service Charge</td>
                              <td id="sc">
                              </td>
                            </tr>
                            <tr style="background-color: white;" class="text-end fw-semibold">
                              <td>Pembulatan</td>
                              <td id="pembulatan">
                              </td>
                            </tr>
                            <tr style="background-color: white;" class="text-end fw-semibold">
                              <td>Free Kembalian</td>
                              <td id="free">
                              </td>
                            </tr>
                            
                            <tr style="background-color: white;" class="text-end fw-semibold">
                              <td>Total Bayar (<small id="pembayaran"></small>)</td>
                              <td id="bayar">
                              </td>
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

    $('#cari').on('click', function() {
        var waroeng  = $('#filter_waroeng').val();
        var tanggal  = $('#filter_tanggal').val();
        var operator = $('#filter_operator').val();
    $('#tampil_rekap').DataTable({
        button: [],
        destroy: true,
        orderCellsTop: true,
        processing: true,
        scrollX: true,
        scrollY: '300px',
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        pageLength: 10,
        ajax: {
            url: '{{route("rekap_refund.show")}}',
            data : {
                waroeng: waroeng,
                tanggal: tanggal,
                operator: operator,
            },
            type : "GET",
            },
            success:function(data){ 
                console.log(data);
            }
      });
    });

    //filter waroeng
    $('#filter_area').change(function(){
        var id_area = $(this).val();
        if(id_area){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_refund.select_waroeng")}}',
            dataType: 'JSON',
            destroy: true,    
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

    //filter operator
    $('#filter_waroeng').change(function(){
        var id_waroeng = $(this).val();    
        if(id_waroeng){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_refund.select_user")}}',
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

    //filter tanggal
    $('#filter_tanggal').flatpickr({
            mode: "range",
            dateFormat: 'Y-m-d',
            // noCalendar: false,
            // allowInput: true,            
    });

    $("#tampil_rekap").on('click','#button_detail', function() {
                var id = $(this).attr('value');
                // console.log(id);
                // $("#myModalLabel").html('Detail Nota');
                $.ajax({
                    url: "/dashboard/rekap_refund/detail/"+id,
                    type: "GET",
                    dataType: 'json',
                    destroy: true,
                    success: function(data) {
                      // console.log(data.detail_nota.r_t_detail_id);
                        $('#no_nota').html(data.transaksi_rekap.r_r_nota_code);
                        $('#tgl_nota').html(data.transaksi_rekap.r_r_tanggal);
                        $('#nama_kons').html(data.transaksi_rekap.name);
                        $('#total').html(formatNumber(Number(data.transaksi_rekap.r_r_nominal_refund)));
                        $('#pajak').html(formatNumber(Number(data.transaksi_rekap.r_r_nominal_refund_pajak)));
                        $('#bayar').html(formatNumber(Number(data.transaksi_rekap.r_r_nominal_refund_total)));
                        // $('#pembayaran').html(data.transaksi_rekap.m_payment_method_name);
                        $('#sc').html(formatNumber(Number(data.transaksi_rekap.r_r_nominal_refund_sc)));
                        $('#pembulatan').html(formatNumber(Number(data.transaksi_rekap.r_r_nominal_pembulatan_refund)));
                        $('#free').html(formatNumber(Number(data.transaksi_rekap.r_r_nominal_free_kembalian_refund)));
                             
                    $('.sub_sub_nota').remove();
                    $.each(data.detail_nota, function (key, item) {
                        console.log(item.r_r_detail_m_produk_nama);
                        $('#sub_nota'+id).append(
                                '<tr class="sub_sub_nota" style="background-color: white;">'+
                                  '<td>'+
                                    '<small class="fw-semibold" style="font-size: 15px;" id="produk">'+ item.r_r_detail_m_produk_nama +'</small> <br>'+
                                    '<small id="qty">'+ item.r_r_detail_qty +'</small> x <small id="price">'+ formatNumber(Number(item.r_r_detail_price)) +'</small>'+
                                  '</td>'+
                                  '<td class="text-end fw-semibold" id+="sub_total">'+ formatNumber(Number(item.r_r_detail_nominal)) + ''+
                                  '</td>'+
                                '</tr>'
                          );
                      });
                    },
                });
                $("#detail_nota").modal('show');
            }); 

});
</script>
@endsection