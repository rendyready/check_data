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
                        <form action="{{ route('rusak.simpan') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm"
                                            for="rekap_rusak_created_by">Operator</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_rusak_created_by" name="rekap_rusak_created_by"
                                                value="{{ Auth::user()->name }}" readonly>
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
                                            <input type="text" class="form-control form-control-sm" id="rekap_rusak_code"
                                                name="rekap_rusak_code" value="{{ $data->code }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label" for="rekap_rusak_tgl">Tanggal</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control form-control-sm" id="rekap_rusak_tgl"
                                                name="rekap_rusak_tgl" value="{{ $data->tgl_now }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label-sm" for="rekap_rusak">User Waroeng</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_rusak_m_w_nama" name="rekap_rusak_m_w_nama"
                                                value="{{ $waroeng_nama->m_w_nama }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label" for="rekap_rusak">Gudang</label>
                                        <div class="col-sm-7">
                                            <select class="js-select2" name="m_gudang_id"
                                                id="m_gudang_id"
                                                style="width: 100%;"data-placeholder="Pilih Gudang" required>
                                                <option></option>
                                                @foreach ($data->gudang as $item)
                                                    <option value="{{$item->m_gudang_code}}">{{ucwords($item->m_gudang_nama)}}</option>
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
                                        <th>Keterangan</th>
                                        <th>Qty</th>
                                        <th>Harga@</th>
                                        <th>Sub Harga</th>
                                        <th><button type="button" class="btn tambah btn-success"><i
                                                    class="fa fa-plus"></i></button></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><select class="js-select2 nama_barang"
                                                    name="rekap_rusak_detail_m_produk_id[]"
                                                    id="rekap_rusak_detail_m_produk_id1"
                                                    style="width: 100%;"data-placeholder="Pilih Nama Barang" required>
                                                    <option></option>
                                                </select></td>
                                            <td>
                                                <textarea class="form-control form-control-sm" name="rekap_rusak_detail_catatan[]" id="rekap_rusak_detail_catatan"
                                                    cols="50" required placeholder="keterangan rusak"></textarea>
                                            </td>
                                            <td><input type="number" step="0.01"
                                                    class="form-control number form-control-sm qty"
                                                    name="rekap_rusak_detail_qty[]" id="rekap_rusak_detail_qty1" required>
                                            </td>
                                            <td><input type="number" class="form-control number form-control-sm harga"
                                                    name="rekap_rusak_detail_hpp[]" id="rekap_rusak_detail_hpp1"
                                                    readonly></td>
                                            <td><input type="number" class="form-control number form-control-sm subtotal"
                                                    name="rekap_rusak_detail_sub_total[]" id="rekap_rusak_detail_sub_total"
                                                    readonly></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <th>Nama Barang</th>
                                        <th>Keterangan</th>
                                        <th>Qty</th>
                                        <th>Harga@</th>
                                        <th>Sub Harga</th>
                                        <th><button type="button" class="btn tambah btn-success"><i
                                                    class="fa fa-plus"></i></button></th>
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
	  var no =2;
	  $('.tambah').on('click',function(){
	    no++;
		$('#form').append('<tr id="row'+no+'">'+
                        '<td><select class="js-select2 nama_barang" name="rekap_rusak_detail_m_produk_id[]" id="rekap_rusak_detail_m_produk_id'+no+'" style="width: 100%;" data-placeholder="Pilih Nama Barang" required><option></option></select></td>'+
                        '<td><textarea class="form-control form-control-sm" name="rekap_rusak_detail_catatan[]" id="rekap_rusak_detail_catatan" cols="50" required placeholder="keterangan rusak"></textarea></td>'+
                        '<td><input type="number" min="0.01" step="0.01" class="form-control form-control-sm qty" name="rekap_rusak_detail_qty[]" id="rekap_rusak_detail_qty" required></td>'+
                        '<td><input type="number" class="form-control number form-control-sm harga" name="rekap_rusak_detail_hpp[]" id="rekap_rusak_detail_hpp'+no+'" readonly></td>'+
                        '<td><input type="number" class="form-control number form-control-sm subtotal" name="rekap_rusak_detail_sub_total[]" id="rekap_rusak_detail_sub_total" readonly></td>'+
                        '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>');
        Codebase.helpersOnLoad(['jq-select2']);
        });

	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
      var $tblrows = $("#form");
      $tblrows.find('.qty').trigger('input');
	});
    $(document).on('select2:open', '.nama_barang', function(){
          console.log("Saving value " + $(this).val());
          var index = $(this).attr('id'); 
          var g_id = $('#m_gudang_id').val();
          if ((g_id == '')) {
            alert('pilih gudang dahulu');
          }
          $.get("/inventori/stok/"+g_id, function(data){
            $.each(data, function(key, value) {
              $('#'+index)
              .append($('<option>', { value : key })
              .text(value));
              }); 
          });
          $(this).data('val', $(this).val());
          $(this).data('id',index);
      }).on('change','.nama_barang', function(e){
          var prev = $(this).data('val');
          var current = $(this).val();
          var g_id = $('#m_gudang_id').val();
          var id = $(this).data('id');
          var harga_id = id.slice(30);
          $.get("/inventori/stok_harga/"+g_id+"/"+current, function(data){
            $('#rekap_rusak_detail_hpp'+harga_id).val(data.m_stok_hpp);
          });
                var values = $('[name="rekap_rusak_detail_m_produk_id[]"]').map(function() {
        return this.value.trim();
      }).get();
      var unique =  [...new Set(values)];
      if (values.length != unique.length) {
        e.preventDefault();
        alert('Nama Barang Sudah Digunakan Pilih Yang Lain');
         $('#'+id).val(prev).trigger('change');
      }
      });
    $(".number").on("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
    });
    $("#form, .qty, .harga").on('input', function () {
      var $tblrows = $("#form tbody tr");
      $tblrows.each(function (index) {
          var $tblrow = $(this);
          $tblrow.find(".qty, .harga").on('input', function () {
              var qty = $tblrow.find("[name='rekap_rusak_detail_qty[]']").val();
              var price = $tblrow.find("[name='rekap_rusak_detail_hpp[]']").val();
              var subTotal = parseFloat(qty) * parseFloat(price);
              if (!isNaN(subTotal)) { 
                  $tblrow.find('.subtotal').val(subTotal.toFixed(2));
                  var grandTotal = 0;
                  $(".subtotal").each(function () {
                      var stval = parseFloat($(this).val());
                      grandTotal += isNaN(stval) ? 0 : stval;
                  });
              }
          });
      });
    });  

       
});
</script>
@endsection
