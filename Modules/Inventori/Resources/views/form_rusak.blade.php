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
                        {{-- <div class="row mb-1">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Pukul</label>
                            <div class="col-sm-8">
                                <h3 id="time">13:00</h3>
                            </div>
                        </div> --}}
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
                              <input type="date" class="form-control form-control-sm" id="rekap_rusak_tgl" name="rekap_rusak_tgl" value="{{$data->tgl_now}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="row mb-1">
                          <label class="col-sm-5 col-form-label" for="rekap_rusak">User Waroeng</label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control form-control-sm" id="rekap_rusak_m_w_nama" name="rekap_rusak_m_w_nama" value="{{$waroeng_nama->m_w_nama}}" readonly>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="table-responsive">
                <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                    <thead>
                        <th>Nama Barang</th>
                        <th>Keterangan</th>
                        <th>Qty</th>
                        <th>Harga@</th>
                        <th>Sub Harga</th>
                        <th><button type="button" class="btn tambah btn-success"><i class="fa fa-plus"></i></button></th>
                    </thead>
                    <tbody>
                        <tr>
                        <td><select class="js-select2 nama_barang" name="rekap_rusak_detail_m_produk_id[]" id="rekap_rusak_detail_m_produk_id" style="width: 100%;"data-placeholder="Pilih Nama Barang" required><option></option></select></td>
                        <td><textarea class="form-control form-control-sm" name="rekap_rusak_detail_catatan[]" id="rekap_rusak_detail_catatan" cols="50" required placeholder="keterangan rusak"></textarea></td>
                        <td><input type="number" step="0.01" class="form-control number form-control-sm qty" name="rekap_rusak_detail_qty[]" id="rekap_rusak_detail_qty" required></td>
                        <td><input type="number" class="form-control number form-control-sm harga" name="rekap_rusak_detail_harga[]" id="rekap_rusak_detail_harga1" readonly></td>
                        <td><input type="number" class="form-control number form-control-sm subharga" name="rekap_rusak_detail_sub_harga[]" id="rekap_rusak_detail_sub_harga" readonly></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <th>Nama Barang</th>
                      <th>Keterangan</th>
                      <th>Qty</th>
                      <th>Harga@</th>
                      <th>Sub Harga</th>
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
                        '<td><textarea class="form-control form-control-sm" name="rekap_rusak_detail_catatan[]" id="rekap_rusak_detail_catatan" cols="50" required placeholder="keterangan rusak"></textarea></td>'+
                        '<td><input type="number" min="0.01" step="0.01" class="form-control form-control-sm qty" name="rekap_rusak_detail_qty[]" id="rekap_rusak_detail_qty" required></td>'+
                        '<td><input type="number" class="form-control number form-control-sm harga" name="rekap_rusak_detail_harga[]" id="rekap_rusak_detail_harga'+no+'" readonly></td>'+
                        '<td><input type="number" class="form-control number form-control-sm subharga" name="rekap_rusak_detail_sub_harga[]" id="rekap_rusak_detail_sub_harga" readonly></td>'+
                        '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>');
    });
    $('#form').on('click select2:open','.tambah, #rekap_rusak_detail_m_produk_id'+no, function(){
          Codebase.helpersOnLoad(['jq-select2']);
          var id = $(this).val();
          var val_id = $('[name="rekap_rusak_detail_m_produk_id[]"]').map(function () {
                return this.value; // $(this).val()
          }).get();
              $.each(barang, function(key, value) {
              $('#rekap_rusak_detail_m_produk_id'+no)
              .append($('<option>', { value : key })
              .text(value));
              });  
              $('select > option').removeAttr('disabled');
                if (id != null) {
                  $.each(val_id, function(index, value) {
                    $('select > option').filter(function () {
                      return $(this).val() == value
                    }).prop('disabled', true)
                  });
              }
        });
       
   $.each(barang, function(key, value) {
     $('.nama_barang')
          .append($('<option>', { value : key })
          .text(value));
    });
  });
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
    var val_id = $('[name="rekap_rusak_detail_m_produk_id[]"]').map(function () {
                return this.value; // $(this).val()
          }).get();
    $('select > option').removeAttr('disabled');
      $.each(val_id, function(index, value) {
       $('select > option').filter(function () {
              return $(this).val() == value
          }).prop('disabled', true)
        });
    
      var $tblrows = $("#form");
      $tblrows.find('.qty').trigger('input');
	});
  $('#form').on('change','.nama_barang', function(e) {
      var values = $('[name="rekap_rusak_detail_m_produk_id[]"]').map(function() {
        return this.value.trim();
      }).get();
      var unique =  [...new Set(values)];
      if (values.length != unique.length) {
        e.preventDefault();
        alert('Nama Barang Sudah Digunakan Pilih Yang Lain');
      }
    });
  $(".number").on("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
    });  

       
});
</script>
@endsection