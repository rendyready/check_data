@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Form Input Barang Rusak
          </div>
          <div class="block-content text-muted">
                <form action="{{route('rusak.simpan')}}" method="post">
                  @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label-sm" for="rekap_rusak_created_by">Operator</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_rusak_created_by" name="rekap_rusak_created_by" value="{{Auth::user()->name}}" readonly>
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
                            <label class="col-sm-4 col-form-label" for="rekap_rusak_code">No Bukti</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_rusak_code" name="rekap_rusak_code" value="{{$data->code}}" readonly>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="rekap_rusak_tgl">Tanggal</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" id="rekap_rusak_tgl" name="rekap_rusak_tgl" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                    <thead>
                        <th>Nama Barang</th>
                        <th>Jumlah Qty</th>
                        <th>Isi</th>
                        <th>Satuan</th>
                        <th>Catatan</th>
                        <th><button type="button" class="btn tambah btn-success"><i class="fa fa-plus"></i></button></th>
                    </thead>
                    <tbody>
                        <tr>
                        <td><select class="js-select2 nama_barang" name="rekap_rusak_detail_m_produk_id[]" id="rekap_rusak_detail_m_produk_id" style="width: 100%;"data-placeholder="Pilih Nama Barang" required><option></option></select></td>
                        <td><input type="number" min="0.01" step="0.01" class="form-control form-control-sm qty" name="rekap_rusak_detail_qty[]" id="rekap_rusak_detail_qty" required></td>
                        <td><input type="text" class="form-control form-control-sm " name="rekap_rusak_detail_isi[]" id="rekap_rusak_detail_isi" required></td>
                        <td><select class="js-select2 satuan" name="rekap_rusak_detail_satuan[]" id="rekap_rusak_detail_satuan" style="width: 100%;"data-placeholder="Pilih Satuan" required><option></option></select></td>
                        <td><textarea class="form-control form-control-sm" name="rekap_rusak_detail_catatan[]" id="rekap_rusak_detail_catatan" cols="50" required placeholder="keterangan rusak"></textarea></td>
                      </tr>
                    </tbody>
                    <tfoot>
                        <th>Nama Barang</th>
                        <th>Jumlah Qty</th>
                        <th>Isi</th>
                        <th>Satuan</th>
                        <th>Catatan</th>
                        <th><button type="button" class="btn tambah btn-success"><i class="fa fa-plus"></i></button></th>
                    </tfoot>
                </table>
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
    var satuan = new Array();
    $.get('/inventori/beli/list', function(response){
      barang = response['barang'];
      satuan = response['satuan'];
	  $('.tambah').on('click',function(){
	    no++;
		$('#form').append('<tr id="row'+no+'">'+
                        '<td><select class="js-select2 nama_barang" name="rekap_rusak_detail_m_produk_id[]" id="rekap_rusak_detail_m_produk_id'+no+'" style="width: 100%;" data-placeholder="Pilih Nama Barang" required><option></option></select></td>'+
                        '<td><input type="number" min="0.01" step="0.01" class="form-control form-control-sm qty" name="rekap_rusak_detail_qty[]" id="rekap_rusak_detail_qty" required></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="rekap_rusak_detail_isi[]" id="rekap_rusak_detail_isi" required></td>'+
                        '<td><select class="js-select2 satuan" name="rekap_rusak_detail_satuan[]" id="rekap_rusak_detail_satuan'+no+'" style="width: 100%;"data-placeholder="Pilih Satuan" required><option></option></select></td>'+
                        '<td><textarea class="form-control form-control-sm" name="rekap_rusak_detail_catatan[]" id="rekap_rusak_detail_catatan" cols="50" required placeholder="keterangan rusak"></textarea></td>'+
                        '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>');
        
            $.each(barang, function(key, value) {
            $('#rekap_rusak_detail_m_produk_id'+no)
            .append($('<option>', { value : key })
            .text(value));
            });
            $.each(satuan, function(key, value) {
            $('#rekap_rusak_detail_satuan'+no)
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
    $.each(satuan, function(key, value) {
     $('.satuan')
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