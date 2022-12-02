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
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Transaksi</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text" value="Admin" disabled>
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
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Tanggal</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Jth Tempo</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row mb-2">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Kode Supplier</label>
                            <div class="col-sm-8">
                              <select class="js-select2 form-control-sm" style="width: 100%;" name="kode_supplier" id="kode_supplier" data-placeholder="pilih supplier">
                                <option></option>
                                <option value="1">PT. Matahari</option>
                                <option value="2">Bunga Mekar</option>
                                <option value="3">Melati</option>
                                <option value="4">Umum</option>
                              </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Nama</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="nama" name="example-hf-text">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">No Telpn</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="telp" name="example-hf-text">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Alamat</label>
                            <div class="col-sm-8">
                             <textarea name="Alamat" id="alamat" cols="30" rows="3"></textarea>
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
                        <td><select class="js-select2 nama_barang" name="name[]" id="nama_barang" style="width: 100%;"data-placeholder="Pilih Nama Barang"><option></option></select></td>
                        <td><input type="number" step="0.01" class="form-control form-control-sm" name="name[]" id=""></td>
                        <td><input type="text" class="form-control form-control-sm" name="name[]" id=""></td>
                        <td><input type="text" class="form-control form-control-sm" name="name[]" id=""></td>
                        <td><input type="text" class="form-control form-control-sm" name="name[]" id=""></td>
                        <td><input type="text" class="form-control form-control-sm txtCal" name="name[]" id=""></td>
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
                <div class="col-md-6">
                    <h3>Total <span id="total_sum_value"></span></h3>
                </div>
                <div class="col-md-6">
                    <div class="row mb-1">
                        <label class="col-sm-3 col-form-label" for="example-hf-text">Diskon</label>
                        <div class="col-sm-2">
                          <input type="text" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text" placeholder="%">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text" placeholder="Rp">
                          </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-3 col-form-label" for="example-hf-text">PPN</label>
                        <div class="col-sm-2">
                          <input type="text" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text" placeholder="%">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text"placeholder="Rp">
                          </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label" for="example-hf-text">Ongkos Kirim</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text">
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label" for="example-hf-text">Jumlah</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text" disabled>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label class="col-sm-4 col-form-label" for="example-hf-text">Sisa</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm" id="example-hf-text" name="example-hf-text" disabled>
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
                        '<td><select class="js-select2 nama_barang" name="name[]" id="nama_barang'+no+'" style="width: 100%;" data-placeholder="Pilih Nama Barang"><option></option></select></td>'+
                        '<td><input type="number" class="form-control form-control-sm" name="name[]" id=""></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="name[]" id=""></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="name[]" id=""></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="name[]" id=""></td>'+
                        '<td><input type="text" class="form-control form-control-sm txtCal" name="name[]" id=""></td>'+
                        '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove">Hapus</button></td></tr>');
        
            $.each(selectValues, function(key, value) {
            $('#nama_barang'+no)
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
    $("#form").on('input', '.txtCal', function () {
       var calculated_total_sum = 0;
     
       $("#form .txtCal").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              calculated_total_sum += parseFloat(get_textbox_value);
              }                  
            });
              $("#total_sum_value").html('Rp '+calculated_total_sum);
       });
       var $tblrows = $("#tblProducts tbody tr");

            $tblrows.each(function (index) {
                var $tblrow = $(this);

                $tblrow.find('.qty').on('change', function () {

                    var qty = $tblrow.find("[name=qty]").val();
                    var price = $tblrow.find("[name=price]").val();
                    var subTotal = parseInt(qty, 10) * parseFloat(price);

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
});
</script>
@endsection