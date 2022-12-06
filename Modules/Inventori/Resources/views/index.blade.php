@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Form Input Pembelian
          </div>
          <div class="block-content text-muted">
                <form action="#">
                <div class="row">
                    <div class="col-md-3">
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label-sm" for="rekap_beli_created_by">Operator</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_beli_created_by" name="rekap_beli_created_by" value="{{Auth::user()->name}}" disabled>
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
                            <label class="col-sm-4 col-form-label" for="example-hf-text">No Nota</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text" value="10001894" disabled>
                            </div>
                        </div>
                        <div class="row mb-1">
                          <label class="col-sm-4 col-form-label-sm" for="rekap_beli_code_nota">Nota Suplier</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="rekap_beli_code_nota" name="rekap_beli_code_nota" value="" placeholder="Nota Supplier">
                          </div>
                      </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_beli_tgl">Tanggal</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" id="rekap_beli_tgl" name="rekap_beli_tgl">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_beli_jth_tmp">Jth Tempo</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" id="rekap_beli_jth_tmp" name="rekap_beli_jth_tmp">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row mb-2">
                            <label class="col-sm-4 col-form-label" for="rekap_beli_sp_id">Kode Supplier</label>
                            <div class="col-sm-8">
                              <select class="js-select2 form-control-sm" style="width: 100%;" name="rekap_beli_sp_id" id="rekap_beli_sp_id" data-placeholder="pilih supplier" required>
                                <option></option>
                                <option value="1">PT. Matahari</option>
                                <option value="2">Bunga Mekar</option>
                                <option value="3">Melati</option>
                                <option value="4">Umum</option>
                              </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_beli_sp_nama">Nama</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_beli_sp_nama" name="rekap_beli_sp_nama">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_beli_telp">No Telpn</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_beli_telp" name="rekap_beli_telp">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_beli_alamat">Alamat</label>
                            <div class="col-sm-8">
                             <textarea name="rekap_beli_alamat" id="rekap_beli_alamat" cols="30" rows="3"></textarea>
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
                        <th><button type="button" class="btn tambah btn-success">Add</button></th>
                    </thead>
                    <tbody>
                        <tr>
                        <td><select class="js-select2 nama_barang" name="rekap_beli_brg_code[]" id="rekap_beli_brg_code" style="width: 100%;"data-placeholder="Pilih Nama Barang" required><option></option></select></td>
                        <td><input type="number" min="0.01" step="0.01" class="form-control form-control-sm qty" name="rekap_beli_detail_qty[]" id="rekap_beli_detail_qty" required></td>
                        <td><input type="text" class="form-control form-control-sm harga" name="rekap_beli_detail_harga[]" id="rekap_beli_detail_harga" required></td>
                        <td><input type="text" class="form-control form-control-sm persendisc" name="rekap_beli_detail_disc[]" id="rekap_beli_detail_disc"></td>
                        <td><input type="text" class="form-control form-control-sm rupiahdisc" name="rekap_beli_detail_discrp[]" id="rekap_beli_detail_discrp"></td>
                        <td><input type="text" class="form-control form-control-sm subtot" name="rekap_beli_detail_subtot[]" id="rekap_beli_detail_subtot"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Disc</th>
                        <th>Disc Rp</th>
                        <th>Sub Harga</th>
                        <th><button type="button" class="btn tambah btn-success">Add</button></th>
                    </tfoot>
                </table>
                <div class="row">
                <div class="col-md-5">
                    <h3>Total <span id="total_sum_value"></span></h3>
                </div>
                <div class="col-md-7">
                    <div class="row mb-1">
                        <label class="col-sm-3 col-form-label" for="rekap_beli_disc">Diskon</label>
                        <div class="col-sm-2">
                          <input type="text" class="form-control form-control-sm disc_tot" id="rekap_beli_disc" name="rekap_beli_disc" placeholder="%">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm disc_tot_rp" id="rekap_beli_disc_rp" name="rekap_beli_disc_rp" placeholder="Rp">
                          </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-3 col-form-label" for="rekap_beli_ppn">PPN</label>
                        <div class="col-sm-2">
                          <input type="text" class="form-control form-control-sm ppn" id="rekap_beli_ppn" name="rekap_beli_ppn" placeholder="%">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm ppnrp" id="rekap_beli_ppn_rp" name="rekap_beli_ppn_rp" placeholder="Rp" disabled>
                          </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label" for="rekap_beli_ongkir">Ongkos Kirim</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm ongkir" value="0" id="rekap_beli_ongkir" name="rekap_beli_ongkir">
                        </div>
                    </div>
                    <div class="row mb-1">
                      <label class="col-sm-4 col-form-label" for="rekap_beli_tot_no_ppn">Jumlah Tanpa PPN</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm rekap_beli_tot_no_ppn" id="rekap_beli_tot_no_ppn" name="rekap_beli_tot_no_ppn" disabled>
                      </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label" for="rekap_beli_tot_nom">Jumlah + PPN + Ongkir</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm rekap_beli_tot_nom" id="rekap_beli_tot_nom" name="rekap_beli_tot_nom" disabled>
                        </div>
                    </div>
                    <div class="row mb-1">
                      <label class="col-sm-4 col-form-label" for="rekap_beli_terbayar">Dibayar</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm bayar" id="rekap_beli_terbayar" name="rekap_beli_terbayar">
                      </div>
                  </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label" for="rekap_beli_tersisa">Sisa</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm sisa" id="rekap_beli_tersisa" name="rekap_beli_tersisa" disabled>
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
    Codebase.helpersOnLoad(['jq-select2']);
	var no =1;
    var  selectValues = { "1": "Minyak Goreng", "2": "Beras C4","3":"Terasi" }; //Contoh bentuk data

	$('.tambah').on('click',function(){
	    no++;
		$('#form').append('<tr id="row'+no+'">'+
                        '<td><select class="js-select2 nama_barang" name="rekap_beli_brg_code[]" id="rekap_beli_brg_code'+no+'" style="width: 100%;" data-placeholder="Pilih Nama Barang" required><option></option></select></td>'+
                        '<td><input type="number" min="0.01" step="0.01" class="form-control form-control-sm qty" name="rekap_beli_detail_qty[]" id="rekap_beli_detail_qty" required></td>'+
                        '<td><input type="text" class="form-control form-control-sm harga" name="rekap_beli_detail_harga[]" id="rekap_beli_detail_harga" required></td>'+
                        '<td><input type="text" class="form-control form-control-sm persendisc" name="rekap_beli_detail_disc[]" id="rekap_beli_detail_disc"></td>'+
                        '<td><input type="text" class="form-control form-control-sm rupiahdisc" name="rekap_beli_detail_discrp[]" id="rekap_beli_detail_discrp"></td>'+
                        '<td><input type="text" class="form-control form-control-sm subtot txtCal" name="rekap_beli_detail_subtot[]" id="rekap_beli_detail_subtot"></td>'+
                        '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove">Hapus</button></td></tr>');
        
            $.each(selectValues, function(key, value) {
            $('#rekap_beli_brg_code'+no)
            .append($('<option>', { value : key })
            .text(value));
    });
        Codebase.helpersOnLoad(['jq-select2']);
        });
 
   $.each(selectValues, function(key, value) {
     $('.nama_barang')
          .append($('<option>', { value : key })
          .text(value));
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
              var price = $tblrow.find("[name='rekap_beli_detail_harga[]']").val();
              var persendisc = $tblrow.find("[name='rekap_beli_detail_disc[]']").val();
              var nilaipersendisc = 100-persendisc;
              var rupiahdisc = $tblrow.find("[name='rekap_beli_detail_discrp[]']").val();
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
          var disc_tot = $("[name='rekap_beli_disc']").val();
          var disctotrp = $("[name='rekap_beli_disc_rp']").val();
          var ppn = $("[name='rekap_beli_ppn']").val();
          var bayar = $("[name='rekap_beli_terbayar']").val();
          var ongkir = $("[name='rekap_beli_ongkir']").val();
        
          var grandtotal = grdtot*parseFloat((100-disc_tot)/100)-disctotrp;
          var ppnrp = parseFloat(ppn/100)*grandtotal;
          var rekap_beli_tot_nom = parseFloat(grandtotal)+ parseFloat(ppnrp)+ parseFloat(ongkir);
          $('.ppnrp').val(ppnrp.toFixed(2));
          $('.rekap_beli_tot_no_ppn').val(grandtotal.toFixed(2));
          $('.rekap_beli_tot_nom').val(rekap_beli_tot_nom.toFixed(2));
          $('.sisa').val((rekap_beli_tot_nom-bayar).toFixed(2));
    });

       
});
</script>
@endsection