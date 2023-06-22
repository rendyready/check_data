@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Form Input PO (Purchase Order)
          </div>
          <div class="block-content text-muted">
                <form action="{{route('po.simpan')}}" method="post">
                  @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label-sm" for="rekap_po_created_by">Operator</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_po_created_by" name="rekap_po_created_by" value="{{Auth::user()->name}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_po_code">No Nota PO</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_po_code" name="rekap_po_code" value="{{$data->code}}" readonly>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_po_tgl">Tanggal</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" id="rekap_po_tgl" name="rekap_po_tgl" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row mb-2">
                            <label class="col-sm-4 col-form-label" for="rekap_po_supplier_id">Kode Supplier</label>
                            <div class="col-sm-8">
                              <select class="js-select2 form-control-sm" style="width: 100%;" name="rekap_po_supplier_id" id="rekap_po_supplier_id" data-placeholder="pilih supplier" required>
                              <option></option>
                              </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_po_supplier_nama">Nama</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control supplier form-control-sm" id="rekap_po_supplier_nama" name="rekap_po_supplier_nama">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_po_supplier_telp">No Telpn</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control supplier form-control-sm" id="rekap_po_supplier_telp" name="rekap_po_supplier_telp">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_po_supplier_alamat">Alamat</label>
                            <div class="col-sm-8">
                             <textarea class="supplier" name="rekap_po_supplier_alamat" id="rekap_po_supplier_alamat" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                    <thead>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Catatan</th>
                        <th><button type="button" class="btn tambah btn-success"><i class="fa fa-plus"></i></button></th>
                    </thead>
                    <tbody>
                        <tr>
                        <td><select class="js-select2 nama_barang" name="rekap_po_detail_m_produk_code[]" id="rekap_po_detail_m_produk_code" style="width: 100%;"data-placeholder="Pilih Nama Barang" required><option></option></select></td>
                        <td><input type="number" class="form-control number form-control-sm qty" name="rekap_po_detail_qty[]" id="rekap_po_detail_qty" required></td>
                        <td><textarea class="form-control form-control-sm" name="rekap_po_detail_catatan[]" id="rekap_po_detail_catatan" cols="50" required placeholder="catatan bb atau satuan"></textarea></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <th>Nama Barang</th>
                      <th>Qty</th>
                      <th>Catatan</th>
                        <th><button type="button" class="btn tambah btn-success"><i class="fa fa-plus"></i></button></th>
                    </tfoot>
                </table>
                <div class="block-content block-content-full text-end bg-transparent">
                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
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
                        '<td><select class="js-select2 nama_barang" name="rekap_po_detail_m_produk_code[]" id="rekap_po_detail_m_produk_code'+no+'" style="width: 100%;" data-placeholder="Pilih Nama Barang" required><option></option></select></td>'+
                        '<td><input type="number" class="form-control number form-control-sm qty" name="rekap_po_detail_qty[]" id="rekap_po_detail_qty" required></td>'+
                        '<td><textarea class="form-control form-control-sm" name="rekap_po_detail_catatan[]" id="rekap_po_detail_catatan" cols="50" required placeholder="catatan bb atau satuan"></textarea></td>'+
                        '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>');
        
            $.each(barang, function(key, value) {
            $('#rekap_po_detail_m_produk_id'+no)
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
     $('#rekap_po_supplier_id')
          .append($('<option>', { value : key })
          .text(value));
    });
  });
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});

       
});
</script>
@endsection