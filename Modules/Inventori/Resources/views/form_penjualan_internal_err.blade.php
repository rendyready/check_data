@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              FORM PENJUALAN GUDANG INTERNAL
          </div>
          <div class="block-content text-muted">
                <form action="{{route('penjualan_inv.simpan')}}" method="post">
                  @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label-sm" for="rekap_inv_penjualan_created_by">Operator</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_inv_penjualan_created_by" name="rekap_inv_penjualan_created_by" value="{{Auth::user()->name}}" readonly>
                            </div>
                        </div>
                        {{-- <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Pukul</label>
                            <div class="col-sm-8">
                                <h3 id="time">13:00</h3>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-md-4">
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_beli_code">No Nota</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_beli_code" name="rekap_beli_code" value="{{$data->code}}" readonly>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_beli_tgl">Tanggal</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" value="{{$data->tgl_now}}" id="rekap_beli_tgl" name="rekap_beli_tgl" readonly>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label-sm" for="rekap_beli_jth_tmp">Jth Tempo</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" id="rekap_beli_jth_tmp" name="rekap_beli_jth_tmp" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                      <div class="row mb-2">
                        <label class="col-sm-4 col-form-label" for="asal_gudang">Gudang Sumber</label>
                        <div class="col-sm-8">
                          <select class="js-select2 form-control-sm" style="width: 100%;" name="asal_gudang" id="asal_gudang" data-placeholder="Pilih Asal Gudang" required>
                          <option></option>
                         @foreach ($data->gudang as $item)
                             <option value="{{$item->m_gudang_code}}">{{ucwords($item->m_gudang_nama)}}</option>
                         @endforeach
                          </select>
                        </div>
                    </div>  
                      <div class="row mb-2">
                            <label class="col-sm-4 col-form-label" for="jenis_gudang">Jenis Penjualan</label>
                            <div class="col-sm-8">
                              <select class="js-select2 form-control-sm" style="width: 100%;" name="jenis_gudang" id="jenis_gudang" data-placeholder="Pilih Jenis Penjualan" required>
                              <option></option>
                              <option value="gudang utama waroeng">Waroeng</option>
                              <option value="gudang wbd waroeng">WDB</option>
                              </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-sm-4 col-form-label" for="waroeng_code">Tujuan</label>
                          <div class="col-sm-8">
                            <select class="js-select2 form-control-sm" style="width: 100%;" name="waroeng_code" id="waroeng_code" data-placeholder="Pilih Customer" required>
                            <option></option>
                            @foreach ($data->waroeng as $item)
                                <option value="{{$item->m_w_code}}">{{$item->m_w_nama}}</option>
                            @endforeach
                            </select>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="table-responsive">
                <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                    <thead>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Disc</th>
                        <th>Disc Rp</th>
                        <th>Sub Harga</th>
                        <th>Catatan</th>
                        <th><button type="button" class="btn tambah btn-success"><i class="fa fa-plus"></i></button></th>
                    </thead>
                    <tbody>
                        <tr>
                        <td><select class="js-select2 nama_barang" name="rekap_inv_penjualan_detail_m_produk_id[]" id="rekap_inv_penjualan_detail_m_produk_id" style="width: 100%;"data-placeholder="Pilih Nama Barang" required><option></option></select></td>
                        <td><input type="number" min="0.01" step="0.01" class="form-control form-control-sm qty" name="rekap_inv_penjualan_detail_qty[]" id="rekap_inv_penjualan_detail_qty" required></td>
                        <td><input type="text" class="form-control form-control-sm harga" name="rekap_inv_penjualan_detail_harga[]" id="rekap_inv_penjualan_detail_harga" required></td>
                        <td><input type="text" class="form-control form-control-sm persendisc" name="rekap_inv_penjualan_detail_disc[]" id="rekap_inv_penjualan_detail_disc"></td>
                        <td><input type="text" class="form-control form-control-sm rupiahdisc" name="rekap_inv_penjualan_detail_discrp[]" id="rekap_inv_penjualan_detail_discrp"></td>
                        <td><input type="text" class="form-control form-control-sm subtot" name="rekap_inv_penjualan_detail_subtot[]" id="rekap_inv_penjualan_detail_subtot"></td>
                        <td><textarea class="form-control form-control-sm" name="rekap_inv_penjualan_detail_catatan[]" id="rekap_inv_penjualan_detail_catatan" cols="50" required placeholder="catatan bb atau satuan"></textarea></td>
                      </tr>
                    </tbody>
                    <tfoot>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Disc</th>
                        <th>Disc Rp</th>
                        <th>Sub Harga</th>
                        <th>Catatan</th>
                        <th><button type="button" class="btn tambah btn-success"><i class="fa fa-plus"></i></button></th>
                    </tfoot>
                </table>
                <div class="row">
                <div class="col-md-6">
                    <h3>Total <span id="total_sum_value"></span></h3>
                </div>
                <div class="col-md-6">
                    <div class="row mb-1">
                      <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_tot_no_ppn">Jumlah Total</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm grdtot" id="rekap_inv_penjualan_tot_no_ppn" name="rekap_inv_penjualan_tot_no_ppn" readonly>
                      </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-3 col-form-label" for="rekap_inv_penjualan_disc">Diskon</label>
                        <div class="col-sm-2">
                          <input type="text" class="form-control form-control-sm disc_tot" id="rekap_inv_penjualan_disc" name="rekap_inv_penjualan_disc" placeholder="%">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm disc_tot_rp" id="rekap_inv_penjualan_disc_rp" name="rekap_inv_penjualan_disc_rp" placeholder="Rp">
                          </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-3 col-form-label" for="rekap_inv_penjualan_ppn">PPN</label>
                        <div class="col-sm-2">
                          <input type="text" class="form-control form-control-sm ppn" id="rekap_inv_penjualan_ppn" name="rekap_inv_penjualan_ppn" placeholder="%">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm ppnrp" id="rekap_inv_penjualan_ppn_rp" name="rekap_inv_penjualan_ppn_rp" placeholder="Rp" readonly>
                          </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_ongkir">Ongkos Kirim</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm ongkir" value="0" id="rekap_inv_penjualan_ongkir" name="rekap_inv_penjualan_ongkir">
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_tot_nom">Jumlah Akhir</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm rekap_inv_penjualan_tot_nom" id="rekap_inv_penjualan_tot_nom" name="rekap_inv_penjualan_tot_nom" readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                      <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_terbayar">Uang Muka</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm bayar" id="rekap_inv_penjualan_terbayar" name="rekap_inv_penjualan_terbayar" value="0">
                      </div>
                  </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_tersisa">Sisa</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm sisa" id="rekap_inv_penjualan_tersisa" name="rekap_inv_penjualan_tersisa" readonly>
                        </div>
                    </div>
                </div>
                </div>
                <div class="block-content block-content-full text-end bg-transparent">
                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                  </div>
                </div>
                </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Page Content -->
@endsection
@section('js')
<script type="module">
 $(document).ready(function(){
  $.ajaxSetup({
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });
    Codebase.helpersOnLoad(['jq-select2']);
	  var no =1;
    var g_id,dt;
    $('#asal_gudang').on('change',function() {
      g_id = $(this).val();
      $.get("/inventori/stok/"+g_id, function(data){
              dt = data;
              $.each(data, function(key, value) {
                $('.nama_barang')
                .append($('<option>', { value : key })
                .text(value));
              });
      });
    });
	  $('.tambah').on('click',function(){
	    no++;
      $('#form').append('<tr id="row'+no+'">'+
                        '<td><select class="js-select2 nama_barang" name="rekap_beli_detail_m_produk_id[]" id="rekap_beli_detail_m_produk_id'+no+'" style="width: 100%;" data-placeholder="Pilih Nama Barang" required > <option value="0" selected disabled hidden></option></select></td>'+
                        '<td><textarea class="form-control form-control-sm" name="rekap_beli_detail_catatan[]" id="rekap_beli_detail_catatan" cols="50" required placeholder="catatan bb atau satuan"></textarea></td>'+
                        '<td><input type="number" min="0.01" step="0.01" class="form-control number form-control-sm qty" name="rekap_beli_detail_qty[]" id="rekap_beli_detail_qty" required></td>'+
                        '<td><input type="text" class="form-control number form-control-sm harga" name="rekap_beli_detail_harga[]" id="rekap_beli_detail_harga" required></td>'+
                        '<td><input type="text" class="form-control number form-control-sm persendisc" name="rekap_beli_detail_disc[]" id="rekap_beli_detail_disc"></td>'+
                        '<td><input type="text" class="form-control number form-control-sm rupiahdisc" name="rekap_beli_detail_discrp[]" id="rekap_beli_detail_discrp"></td>'+
                        '<td><input type="text" class="form-control number form-control-sm subtot" name="rekap_beli_detail_subtot[]" id="rekap_beli_detail_subtot" readonly></td>'+
                        '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>');
        
        Codebase.helpersOnLoad(['jq-select2']);
              $.each(dt, function(key, value) {
                $('.nama_barang')
                .append($('<option>', { value : key })
                .text(value));
              });
      
    });
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
  $("#form, .qty, .harga, .persendisc, .rupiahdisc, .disc_tot, .disc_tot_rp, .ppn, .ongkir, .bayar").on('input', function () {
      var $tblrows = $("#form tbody tr");
      $tblrows.each(function (index) {
          var $tblrow = $(this);
          $tblrow.find(".qty, .harga, .persendisc, .rupiahdisc").on('input', function () {
              var qty = $tblrow.find("[name='rekap_beli_detail_qty[]']").val();
              var price = $tblrow.find("[name='rekap_beli_detail_harga[]']").val().replace(/\./g, '').replace(/\,/g, '.');
              var persendisc = $tblrow.find("[name='rekap_beli_detail_disc[]']").val();
              var nilaipersendisc = 100-persendisc;
              var rupiahdisc = $tblrow.find("[name='rekap_beli_detail_discrp[]']").val().replace(/\./g, '').replace(/\,/g, '.');
              if (rupiahdisc==null) {
                rupiahdisc = 0;
              }
              var subTotal = parseFloat(qty) * parseFloat(price) * (nilaipersendisc/100) - rupiahdisc;
              if (!isNaN(subTotal)) { 
                  $tblrow.find('.subtot').val(subTotal.toLocaleString("id"));
                  var grandTotal = 0;
                  $(".subtot").each(function () {
                      var stval = parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.'));
                      grandTotal += isNaN(stval) ? 0 : stval;
                  });
                  $('.grdtot').val(grandTotal.toLocaleString('id')); 
              }
          });
      });
       var grdtot = 0;
          $(".subtot").each(function () {
                          var stval = parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.'));
                          grdtot += isNaN(stval) ? 0 : stval;
          });
          var disc_tot = $("[name='rekap_beli_disc']").val();
          var disctotrp = $("[name='rekap_beli_disc_rp']").val().replace(/\./g, '').replace(/\,/g, '.');
          var ppn = $("[name='rekap_beli_ppn']").val();
          var bayar = $("[name='rekap_beli_terbayar']").val().replace(/\./g, '').replace(/\,/g, '.');
          var ongkir = $("[name='rekap_beli_ongkir']").val().replace(/\./g, '').replace(/\,/g, '.');
         if (ongkir==="") {
            var ongkir = 0;
         }
          var grandtotal = grdtot*parseFloat((100-disc_tot)/100)-disctotrp;
          var ppnrp = parseFloat(ppn/100)*grandtotal;
          var rekap_beli_tot_nom = parseFloat(grandtotal)+ parseFloat(ppnrp)+ parseFloat(ongkir);
          $('.ppnrp').val(ppnrp);
          $('.rekap_beli_tot_nom').val(rekap_beli_tot_nom.toLocaleString('id'));
          $('.sisa').val((rekap_beli_tot_nom-bayar).toLocaleString('id'));
          $('#total_sum_value').html(': Rp '+rekap_beli_tot_nom.toLocaleString('id'));
    });

       
});
</script>
@endsection