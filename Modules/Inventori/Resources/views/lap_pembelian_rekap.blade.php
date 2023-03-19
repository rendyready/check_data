@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Rekap Pembelian Bahan Baku
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
                                    <label class="col-sm-3 col-form-label" for="rekap_inv_penjualan_created_by">Pengadaan</label>
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
                
            <table id="tampil_rekap" class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full">
              <thead>
                <tr>
                  <th class="text-center">Tanggal</th>
                  <th class="text-center">Pengadaan</th>
                  <th class="text-center">Kode Nota</th>
                  <th class="text-center">Supplier</th>
                  <th class="text-center">Alamat Supplier</th>
                  <th class="text-center">Diskon (%)</th>
                  <th class="text-center">Diskon (Rp.)</th>
                  <th class="text-center">PPN (%)</th>
                  <th class="text-center">PPN (Rp.)</th>
                  <th class="text-center">Ongkir</th>
                  <th class="text-center">Total</th>
                  <th class="text-center">Terbayar</th>
                  <th class="text-center">Kurang Bayar</th>
                  <th class="text-center">Keterangan</th>
                  <th></th>
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
                        <h3 class="block-title text-light"><small class="fw-semibold" id="no_nota"></small><br><small id="suplier"></small></h3>
                        <div class="alert alert-warning py-2 mb-0">
                          <h3 class="block-title text-black"><i class="fa fa-calendar opacity-50 ms-1"></i> <small id="tgl_nota"></small>
                            <br><small class="fw-semibold" id="pengadaan"></small></h3>
                        </div>
                      </div>
                      <div class="block-content mb-4" style="background-color: rgba(224, 224, 224, 0.5)">
                        <table class="table table-border" style="font-size: 13px;">
                          @foreach ($data->rekap_beli as $beli)
                          <thead class="sub_nota" id="sub_nota{{ $beli->rekap_beli_code }}">
                          </thead> 
                          @endforeach
                            <tbody>
                            <tr style="background-color: white;" class="text-end fw-semibold">
                              <td>Sub total</td>
                              <td id="sub_total">
                              </td>
                            </tr>
                            <tr style="background-color: white;" class="text-end fw-semibold">
                              <td>PPN (<small id="ppn_persen"></small>)</td>
                              <td id="ppn">
                              </td>
                            </tr>
                            <tr style="background-color: white;" class="text-end fw-semibold">
                                <td>Diskon Nota (<small id="diskon_persen"></small>)</td>
                                <td id="diskon">
                                </td>
                              </tr>
                            <tr style="background-color: white;" class="text-end fw-semibold">
                              <td>Total Bayar</td>
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
        var pengadaan = $('#filter_pengadaan').val();
    $('#tampil_rekap').DataTable({
        button: [],
        destroy: true,
        orderCellsTop: true,
        processing: true,
        scrollX: true,
        scrollY: '300px',
        columnDefs: [ 
            { className: 'dt-right', targets: [6, 8, 9, 10, 11, 12] },
            { className: 'dt-center', targets: [5, 7] },
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        pageLength: 10,
        ajax: {
            url: '{{route("lap_pem_rekap.tampil_rekap")}}',
            data : {
                waroeng: waroeng,
                tanggal: tanggal,
                pengadaan: pengadaan,
            },
            type : "GET",
            },
            success:function(data){ 
                console.log(data);
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
            
    });

            $("#tampil_rekap").on('click','#button_detail', function() {
                var id = $(this).attr('value');
                $.ajax({
                    url: "/inventori/lap_pem_rekap/detail_rekap/"+id,
                    type: "GET",
                    dataType: 'json',
                    destroy: true,
                    success: function(data) {
                      // console.log(data.detail_nota.r_t_detail_id);
                        $('#no_nota').html(data.rekap_beli.rekap_beli_code);
                        $('#suplier').html(data.rekap_beli.rekap_beli_supplier_nama);
                        $('#tgl_nota').html(data.rekap_beli.rekap_beli_tgl);
                        $('#pengadaan').html(data.rekap_beli.name);
                        $('#sub_total').html('loading');
                        $('#ppn').html(formatNumber(Number(data.rekap_beli.rekap_beli_ppn_rp)));
                        $('#ppn_persen').html(formatNumber(Number(data.rekap_beli.rekap_beli_ppn)));
                        $('#diskon').html(formatNumber(Number(data.rekap_beli.rekap_beli_disc_rp)));
                        $('#diskon_persen').html(formatNumber(Number(data.rekap_beli.rekap_beli_disc)));
                        $('#bayar').html(formatNumber(Number(data.rekap_beli.rekap_beli_tot_nom)));
                             
                    $('.sub_sub_nota').remove();
                    $.each(data.rekap_detail, function (key, item) {
                        console.log(item.r_t_detail_m_produk_nama);
                        $('#sub_nota'+id).append(
                                '<tr class="sub_sub_nota" style="background-color: white;">'+
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
                                            formatNumber(Number(item.rekap_beli_detail_discrp)) : 
                                            'Diskon BB '+ formatNumber(Number(item.rekap_beli_detail_discrp))
                                        ) +
                                    '</small>'+
                                  '</td>'+
                                  '<td class="text-end fw-semibold" id+="sub_total">'+ formatNumber(Number(item.rekap_beli_detail_subtot)) + ''+
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
