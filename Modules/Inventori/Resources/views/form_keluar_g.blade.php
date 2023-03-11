@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            FORM KELUAR DARI GUDANG
                    </div>
                    <div class="block-content text-muted">
                        <form action="{{ route('m_gudang_out.simpan') }}" method="post">
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
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label" for="rekap_tf_gudang_code">No Bukti</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_tf_gudang_code" name="rekap_tf_gudang_code"
                                                value="{{ $data->code }}" readonly>
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
                                        <label class="col-sm-5 col-form-label-sm" for="rekap_rusak">Operator</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_rusak_m_w_nama" name="rekap_rusak_m_w_nama"
                                                value="{{ $waroeng_nama->m_w_nama }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label" for="rekap_tf_gudang_asal_code">Gudang
                                            Asal</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 gudang_code" name="rekap_tf_gudang_asal_code"
                                                id="rekap_tf_gudang_asal_code"
                                                style="width: 100%;"data-placeholder="Pilih Gudang" required>
                                                <option></option>
                                                @foreach ($data->gudang as $item)
                                                    <option value="{{ $item->m_gudang_code }}">
                                                        {{ ucwords($item->m_gudang_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label" for="rekap_tf_gudang_tujuan_id">Gudang
                                            Tujuan</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2" name="rekap_tf_gudang_tujuan_code"
                                                id="rekap_tf_gudang_tujuan_code"
                                                style="width: 100%;"data-placeholder="Pilih Gudang" required>
                                                <option></option>
                                                @foreach ($data->gudang as $item)
                                                    <option value="{{ $item->m_gudang_code }}">
                                                        {{ ucwords($item->m_gudang_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($message = Session::get('sukses'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                                    <thead>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Harga@</th>
                                        <th>Sub Harga</th>
                                        <th><button type="button" class="btn tambah btn-success"><i
                                                    class="fa fa-plus"></i></button></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><select class="js-select2 nama_barang" name="rekap_tf_gudang_m_produk_id[]"
                                                    id="rekap_tf_gudang_m_produk_id1"
                                                    style="width: 100%;"data-placeholder="Pilih Nama Barang" required>
                                                    <option></option>
                                                </select></td>
                                            <td><input type="text" class="form-control number form-control-sm qty"
                                                    name="rekap_tf_gudang_qty_kirim[]"
                                                    id="rekap_tf_gudang_qty_kirim1" required>
                                                <span class="stok" id="stok1"></span>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm satuan"
                                                    id="satuan1" readonly></td>
                                            <td><input type="text" class="form-control number hpp form-control-sm harga"
                                                    name="rekap_tf_gudang_hpp[]" id="rekap_tf_gudang_hpp1" readonly>
                                            </td>
                                            <td><input type="text" class="form-control number form-control-sm subtotal"
                                                    name="rekap_tf_gudang_sub_total[]" id="rekap_tf_gudang_sub_total"
                                                    readonly></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Harga@</th>
                                        <th>Sub Harga</th>
                                        <th><button type="button" class="btn tambah btn-success"><i
                                                    class="fa fa-plus"></i></button></th>
                                    </tfoot>
                                </table>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Total <span id="total_sum_value"></span></h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="rekap_tf_gudang_grand_tot">Jumlah
                                                Akhir</label>
                                            <div class="col-sm-6">
                                                <input type="text"
                                                    class="form-control form-control-sm rekap_tf_gudang_grand_tot"
                                                    id="rekap_tf_gudang_grand_tot" name="rekap_tf_gudang_grand_tot"
                                                    readonly>
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
      var datas;
    $('#rekap_tf_gudang_tujuan_code, #rekap_tf_gudang_asal_code').on('change',function () {
        var asal = $('#rekap_tf_gudang_asal_code').val();
        var tujuan = $('#rekap_tf_gudang_tujuan_code').val();
        if (asal == tujuan) {
            alert('Tujuan dan Asal Gudang Tidak Boleh Sama !!!');
            $('#rekap_tf_gudang_tujuan_code').val('').trigger('change');
        }
        $.get("/inventori/stok/"+asal, function(data){
            datas = data;
            $.each(data, function(key, value) {
              $('#rekap_tf_gudang_m_produk_id1')
              .append($('<option>', { value : key })
              .text(value));
            });
        });  
    });
    Codebase.helpersOnLoad(['jq-select2']);
	  var no =2;
	  $('.tambah').on('click',function(){
	    no++;
		$('#form').append('<tr id="row'+no+'">'+
                        '<td><select class="js-select2 nama_barang" name="rekap_tf_gudang_m_produk_id[]" id="rekap_tf_gudang_m_produk_id'+no+'" style="width: 100%;" data-placeholder="Pilih Nama Barang" required><option></option></select></td>'+
                        '<td><input type="text" class="form-control number form-control-sm qty" name="rekap_tf_gudang_qty_kirim[]" id="rekap_tf_gudang_qty_kirim" required><span class="stok" id="stok'+no+'"></span></td>'+
                        '<td><input type="text" class="form-control form-control-sm satuan" id="satuan'+no+'" readonly></td>'+
                        '<td><input type="text" class="form-control number form-control-sm hpp harga" name="rekap_tf_gudang_hpp[]" id="rekap_tf_gudang_hpp'+no+'" readonly></td>'+
                        '<td><input type="text" class="form-control number form-control-sm subtotal" name="rekap_tf_gudang_sub_total[]" id="rekap_tf_gudang_sub_total" readonly></td>'+
                        '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>');
        Codebase.helpersOnLoad(['jq-select2']);
        $.each(datas, function(key, value) {
              $('#rekap_tf_gudang_m_produk_id'+no)
              .append($('<option>', { value : key })
              .text(value));
         }); 
        });
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
      var $tblrows = $("#form");
      $tblrows.find('.qty').trigger('input');
      console.log(test);
	});
    $("#form, .qty, .harga, .ongkir").on('input', function () {
      var $tblrows = $("#form tbody tr");
      $tblrows.each(function (index) {
          var $tblrow = $(this);
          $tblrow.find(".qty, .harga").on('input', function () {
              var qty = $tblrow.find("[name='rekap_tf_gudang_qty_kirim[]']").val().replace(/\./g, '').replace(/\,/g, '.');
              var price = $tblrow.find("[name='rekap_tf_gudang_hpp[]']").val().replace(/\./g, '').replace(/\,/g, '.');
              var subTotal = parseFloat(qty) * parseFloat(price);
              if (!isNaN(subTotal)) { 
                  $tblrow.find('.subtotal').val(subTotal.toLocaleString("id"));
                  var grandTotal = 0;
                  $(".subtotal").each(function () {
                      var stval = parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.'));
                      grandTotal += isNaN(stval) ? 0 : stval;
                  });
                  $('.grdtot').val(grandTotal.toLocaleString("id")); 
              }
          });
      });
      var grdtot = 0;
          $(".subtotal").each(function () {
                          var stval = parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.'));
                          grdtot += isNaN(stval) ? 0 : stval;
          });
          $('#rekap_tf_gudang_grand_tot').val(grdtot.toLocaleString("id"));
          $('#total_sum_value').html(': Rp '+grdtot.toLocaleString("id"));
    });
    $('.close').on('click',function () {
        $('.alert').remove();
    })  

       
});
</script>
@endsection
