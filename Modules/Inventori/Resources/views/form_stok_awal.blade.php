@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Form Input Stok Awal
                    </div>
                    <div class="block-content text-muted">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row mb-1">
                                    <label class="col-sm-4 col-form-label-sm" for="rekap_po_created_by">Operator</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="rekap_po_created_by"
                                            name="rekap_po_created_by" value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row mb-1">
                                    <label class="col-sm-4 col-form-label" for="tgl_now">Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control form-control-sm" id="tgl_now"
                                            name="tgl_now" value="{{ $tgl_now }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label" for="m_stok_gudang_id">Gudang</label>
                                    <div class="col-sm-8">
                                        <select class="js-select2 form-control-sm" style="width: 100%;"
                                            name="m_stok_gudang_id" id="m_stok_gudang_id" data-placeholder="Cari Gudang"
                                            required>
                                            <option value=""></option>
                                            @foreach ($gudang as $item)
                                                <option value="{{ $item->m_gudang_id }}">{{ ucwords($item->m_gudang_nama) }}
                                                    - {{ $item->m_w_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <form id="formAction">
                                <table id="form_input" class="table table-sm table-bordered table-striped table-vcenter">
                                    <thead>
                                        <th>Nama Barang</th>
                                        <th>Stok Awal</th>
                                        <th>Satuan</th>
                                        <th><button type="button" class="btn tambah btn-success"><i
                                                    class="fa fa-plus"></i></button></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><select class="js-select2 nama_barang reset" name="m_stok_m_produk_id[]"
                                                    id="m_stok_m_produk_id"
                                                    style="width: 100%;"data-placeholder="Pilih Nama Barang" required>
                                                    <option value=""></option>
                                                </select></td>
                                            <td><input type="number" min="0"
                                                    class="form-control form-control-sm number reset" name="m_stok_awal[]"
                                                    id="m_stok_awal" required></td>
                                            <td><input type="text" class="form-control form-control-sm reset"
                                                    id="m_satuan" readonly></td>
                                            <td><input type="number" min="0"
                                                    class="form-control number form-control-sm" name="m_stok_hpp[]"
                                                    id="m_stok_hpp" required></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="block-content block-content-full text-end bg-transparent">
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                        </div>
                        </form>
                        <table id="tb_stok"
                            class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Stok Awal</th>
                                <th>Hpp</th>
                                <th>Satuan</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Stok Awal</th>
                                <th>Hpp</th>
                                <th>Satuan</th>
                            </tfoot>
                        </table>
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
    Codebase.helpersOnLoad(['jq-notify']);
    var table;
    $('#m_stok_gudang_id').on('change',function () {
            var g_id = $('#m_stok_gudang_id').val();
            $(function() {
            table = $('#tb_stok').DataTable({
              buttons:[],
              destroy:true,
              ajax: {
              url: "/inventori/stok_awal/list/"+g_id,
              type: "GET",
                }
            });
        });
    });
    var  barang = new Array();
    var satuan = new Array();
    $.get('/inventori/beli/list', function(response){
      barang = response['barang'];
      satuan = response['satuan'];
      var no=1;
      $('.tambah').on('click',function(){
        no++;
      $('#form_input').append('<tr id="row'+no+'" class="remove_all">'+
                          '<td><select class="js-select2 nama_barang" name="m_stok_m_produk_id[]" id="m_stok_m_produk_id'+no+'" style="width: 100%;"data-placeholder="Pilih Nama Barang" required><option></option></select></td>'+
                          '<td><input type="number" min="0" class="form-control number form-control-sm" name="m_stok_awal[]" id="m_stok_awal" required></td>'+
                          '<td><input type="number" min="0" class="form-control number form-control-sm" name="m_stok_hpp[]" id="m_stok_hpp" required></td>'+
                          '<td><input type="text" class="form-control form-control-sm satuan" id="m_satuan'+no+'" readonly></td>'+
                          '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td></tr>');

      });
      Codebase.helpersOnLoad(['jq-select2']);
      $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#row'+button_id+'').remove();
      });
      $('#form_input').on('click','.tambah', function(){
          Codebase.helpersOnLoad(['jq-select2']);
              $.each(barang, function(key, value) {
              $('#m_stok_m_produk_id'+no).append('<option></option>');  
              $('#m_stok_m_produk_id'+no)
              .append($('<option>', { value : key })
              .text(value));
              });  
        });
      $.each(barang, function(key, value) {
        $('.nama_barang')
              .append($('<option>', { value : key })
              .text(value));
        });
    });
    $(document).on('select2:open', '.nama_barang', function(){
          console.log("Saving value " + $(this).val());
          var index = $(this).attr('id'); 
          $(this).data('val', $(this).val());
          $(this).data('id',index);
      }).on('change','.nama_barang', function(e){
          var prev = $(this).data('val');
          var current = $(this).val();
          var id = $(this).data('id');
          var satuan_id = id.slice(18);  
          $.get("/master/m_satuan/"+current, function(data){
            $('#m_satuan'+satuan_id).val(data.m_satuan_kode);
          });
                var values = $('[name="m_stok_m_produk_id[]"]').map(function() {
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
            $('#formAction').submit( function(e){
                if(!e.isDefaultPrevented()){
                  var g_id = $('#m_stok_gudang_id').val();
                  var formData = $('form').serializeArray();
                  formData.push({name:"m_stok_gudang_id",value:g_id});
                    $.ajax({
                        url : "{{ route('stok_awal.simpan') }}",
                        type : "POST",
                        data : formData,
                        success : function(data){
                            Codebase.helpers('jq-notify', {
                            align: 'right', // 'right', 'left', 'center'
                            from: 'top', // 'top', 'bottom'
                            type: data.type, // 'info', 'success', 'warning', 'danger'
                            icon: 'fa fa-info me-5', // Icon class
                            message: data.message
                            });
                            $('.remove_all').remove();
                            $('.reset').val('');
                            var g_id = $('#m_stok_gudang_id').val();
                            $(function() {
                            $('#tb_stok').DataTable({
                                buttons:[],
                                destroy:true,
                                ajax: {
                                url: "/inventori/stok_awal/list/"+g_id,
                                type: "GET",
                                    }
                                });
                            });
                        },
                        error : function(err){
                            alert(err.responseJSON.message);
                        }
                    });
                    return false;
                }
            });
});
</script>
@endsection
