@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              FORM PENJUALAN BARANG GUDANG
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
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Pukul</label>
                            <div class="col-sm-8">
                                <h3 id="time">13:00</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_code">No Nota</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_inv_penjualan_code" name="rekap_inv_penjualan_code" value="{{$data->code}}" readonly>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_tgl">Tanggal</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" id="rekap_inv_penjualan_tgl" name="rekap_inv_penjualan_tgl" required>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label-sm" for="rekap_inv_penjualan_jth_tmp">Jth Tempo</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" id="rekap_inv_penjualan_jth_tmp" name="rekap_inv_penjualan_jth_tmp" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row mb-2">
                            <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_supplier_id">Kode Pelanggan</label>
                            <div class="col-sm-8">
                              <select class="js-select2 form-control-sm" style="width: 100%;" name="rekap_inv_penjualan_supplier_id" id="rekap_inv_penjualan_supplier_id" data-placeholder="pilih customer" required>
                              <option></option>
                              </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_supplier_nama">Nama</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control supplier form-control-sm" id="rekap_inv_penjualan_supplier_nama" name="rekap_inv_penjualan_supplier_nama">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_supplier_telp">No Telpn</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control supplier form-control-sm" id="rekap_inv_penjualan_supplier_telp" name="rekap_inv_penjualan_supplier_telp">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_supplier_alamat">Alamat</label>
                            <div class="col-sm-8">
                             <textarea class="supplier" name="rekap_inv_penjualan_supplier_alamat" id="rekap_inv_penjualan_supplier_alamat" cols="30" rows="3"></textarea>
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
    var  barang = new Array();
    var supplier = new Array();
    $.get('/inventori/beli/list', function(response){
      barang = response['barang'];
      supplier = response['supplier'];
	  $('.tambah').on('click',function(){
	    no++;
		$('#form').append('<tr id="row'+no+'">'+
                        '<td><select class="js-select2 nama_barang" name="rekap_inv_penjualan_detail_m_produk_id[]" id="rekap_inv_penjualan_detail_m_produk_id'+no+'" style="width: 100%;" data-placeholder="Pilih Nama Barang" required><option></option></select></td>'+
                        '<td><input type="number" min="0.01" step="0.01" class="form-control form-control-sm qty" name="rekap_inv_penjualan_detail_qty[]" id="rekap_inv_penjualan_detail_qty" required></td>'+
                        '<td><input type="text" class="form-control form-control-sm harga" name="rekap_inv_penjualan_detail_harga[]" id="rekap_inv_penjualan_detail_harga" required></td>'+
                        '<td><input type="text" class="form-control form-control-sm persendisc" name="rekap_inv_penjualan_detail_disc[]" id="rekap_inv_penjualan_detail_disc"></td>'+
                        '<td><input type="text" class="form-control form-control-sm rupiahdisc" name="rekap_inv_penjualan_detail_discrp[]" id="rekap_inv_penjualan_detail_discrp"></td>'+
                        '<td><input type="text" class="form-control form-control-sm subtot" name="rekap_inv_penjualan_detail_subtot[]" id="rekap_inv_penjualan_detail_subtot"></td>'+
                        '<td><textarea class="form-control form-control-sm" name="rekap_inv_penjualan_detail_catatan[]" id="rekap_inv_penjualan_detail_catatan" cols="50" required placeholder="catatan bb atau satuan"></textarea></td>'+
                        '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>');
        
            $.each(barang, function(key, value) {
            $('#rekap_inv_penjualan_detail_m_produk_id'+no)
            .append($('<option>', { value : key })
            .text(value));
    });
        Codebase.helpersOnLoad(['jq-select2']);
        });
       
   $.each(barang, function(key, value) {
     $('.nama_barang')
          .append($('<option>', { value : key })
          .text(value));
    });
    $.each(supplier, function(key, value) {
     $('#rekap_inv_penjualan_supplier_id')
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

              var qty = $tblrow.find("[name='rekap_inv_penjualan_detail_qty[]']").val();
              var price = $tblrow.find("[name='rekap_inv_penjualan_detail_harga[]']").val();
              var persendisc = $tblrow.find("[name='rekap_inv_penjualan_detail_disc[]']").val();
              var nilaipersendisc = 100-persendisc;
              var rupiahdisc = $tblrow.find("[name='rekap_inv_penjualan_detail_discrp[]']").val();
              if (rupiahdisc==null) {
                rupiahdisc = 0;
              }
              var subTotal = parseFloat(qty) * parseFloat(price) * (nilaipersendisc/100) - rupiahdisc;
          
              if (!isNaN(subTotal)) { 

                  $tblrow.find('.subtot').val(subTotal.toFixed(2));
                  var grandTotal = 0;

                  $(".subtot").each(function () {
                      var stval = parseFloat($(this).val());
                      grandTotal += isNaN(stval) ? 0 : stval;
                  });

                  $('.grdtot').val(grandTotal.toFixed(2)); 
              }
          });
      });
       var grdtot = 0;
          $(".subtot").each(function () {
                          var stval = parseFloat($(this).val());
                          grdtot += isNaN(stval) ? 0 : stval;
          });
          var disc_tot = $("[name='rekap_inv_penjualan_disc']").val();
          var disctotrp = $("[name='rekap_inv_penjualan_disc_rp']").val();
          var ppn = $("[name='rekap_inv_penjualan_ppn']").val();
          var bayar = $("[name='rekap_inv_penjualan_terbayar']").val();
          var ongkir = $("[name='rekap_inv_penjualan_ongkir']").val();
        
          var grandtotal = grdtot*parseFloat((100-disc_tot)/100)-disctotrp;
          var ppnrp = parseFloat(ppn/100)*grandtotal;
          var rekap_inv_penjualan_tot_nom = parseFloat(grandtotal)+ parseFloat(ppnrp)+ parseFloat(ongkir);
          $('.ppnrp').val(ppnrp.toFixed(2));
          $('.rekap_inv_penjualan_tot_nom').val(rekap_inv_penjualan_tot_nom.toFixed(2));
          $('.sisa').val((rekap_inv_penjualan_tot_nom-bayar).toFixed(2));
          $('#total_sum_value').html(': Rp '+rekap_inv_penjualan_tot_nom.toFixed(2));
    });

       
});
</script>
@endsection