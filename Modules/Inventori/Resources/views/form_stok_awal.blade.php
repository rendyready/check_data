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
                        <input type="text" class="form-control form-control-sm" id="rekap_po_created_by" name="rekap_po_created_by" value="{{Auth::user()->name}}" readonly>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="row mb-1">
                      <label class="col-sm-4 col-form-label" for="tgl_now">Tanggal</label>
                      <div class="col-sm-8">
                        <input type="date" class="form-control form-control-sm" id="tgl_now" name="tgl_now" value="{{$tgl_now}}" readonly>
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="row mb-2">
                      <label class="col-sm-4 col-form-label" for="m_stok_gudang_id">Gudang</label>
                      <div class="col-sm-8">
                        <select class="js-select2 form-control-sm" style="width: 100%;" name="m_stok_gudang_id" id="m_stok_gudang_id" data-placeholder="Pilih Gudang">
                          <option value=""></option>
                          @foreach ($gudang as $item)
                              <option value="{{$item->m_gudang_id}}">{{ucwords($item->m_gudang_nama)}} - {{$item->m_w_nama}}</option>
                          @endforeach
                        </select>
                      </div>
                  <div class="row mb-4">
                      <label class="col-sm-4 col-form-label" for="rekap_po_tgl">Pencarian</label>
                    <div class="col-sm-8 py-2 px-lg-4">
                      <button id="cari" class="btn btn-lg btn-warning btn-cari"> Cari</button>
                    </div>
                  </div>
              </div>
            </div>
            <form action="">
                <table id="form_input" class="table table-sm table-bordered table-striped table-vcenter">
                  <thead>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Stok Awal</th>
                    <th>Satuan</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td><select class="js-select2 nama_barang" name="rekap_inv_penjualan_detail_m_produk_id[]" id="rekap_inv_penjualan_detail_m_produk_id" style="width: 100%;"data-placeholder="Pilih Nama Barang" required><option></option></select></td>
                      <td><input type="number" min="0.01" step="0.01" class="form-control form-control-sm qty" name="rekap_inv_penjualan_detail_qty[]" id="rekap_inv_penjualan_detail_qty" required></td>
                      <td><input type="text" class="form-control form-control-sm harga" name="rekap_inv_penjualan_detail_harga[]" id="rekap_inv_penjualan_detail_harga" readonly></td>
                    </tr>
                  </tbody>
                </table>
                <div class="block-content block-content-full text-end bg-transparent">
                  <button type="submit"  class="btn btn-sm btn-success">Simpan</button>
                </div>
              </div>
              </form>
                <table id="tb_stok" class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Stok Awal</th>
                        <th>Satuan</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Stok Awal</th>
                        <th>Satuan</th>
                    </tfoot>
                </table>
            <!-- Select2 in a modal -->
  <div class="modal" id="form-supplier" tabindex="-1" role="dialog" aria-labelledby="form-supplier" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-themed shadow-none mb-0">
          <div class="block-header block-header-default bg-pulse">
            <h3 class="block-title" id="myModalLabel"></h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content">
            <!-- Select2 is initialized at the bottom of the page -->
            <form id="formAction" name="form_action" method="post">
              <div class="mb-4">
                <input name="action" type="hidden" id="action">
                <input name="m_supplier_id" type="hidden" id="m_supplier_id">
                <div class="form-group">
                    <label for="m_supplier_nama">Nama Barang</label>
                      <div>
                        <input class="form-control" type="text" name="m_supplier_nama" id="m_supplier_nama" style="width: 100%;" required>
                      </div>
                </div>
                <div class="form-group">
                  <label for="m_supplier_alamat">Qty Stok Awal</label>
                    <div>
                      <textarea class="form-control" type="text" name="m_supplier_alamat" id="m_supplier_alamat" style="width: 100%;" cols="3" rows="2" required></textarea>
                    </div>
                </div>
                
              </div>
              </div>
              <div class="block-content block-content-full text-end bg-body">
                <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-success" id="submit">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Select2 in a modal -->
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
  $.ajaxSetup({
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });
    Codebase.helpersOnLoad(['jq-notify']);
    var table, save_method;
    $('#cari').on('click',function () {
            var g_id = $('#m_stok_gudang_id').val();
            $(function() {
            table = $('#tb_stok').DataTable({
              buttons:[],
              destroy:true,
              ajax: {
              url: "/inventori/stok_awal/list/"+g_id,
              type: "GET",
                },
                columns: [
                  { data: 'm_stok_id'},
                  { data: 'm_stok_m_produk_nama' },
                  { data: 'm_stok_awal' },
                  { data: 'm_stok_satuan' },
              ]
              
            });
        });
    });
      $(".buttonInsert").on('click', function() {
            $('[name="action"]').val('add');
            var id = $(this).attr('value');
            $('#form-supplier form')[0].reset();
            $("#myModalLabel").html('Tambah Supplier');
            $("#form-supplier").modal('show');
      });
            $('#formAction').submit( function(e){
                if(!e.isDefaultPrevented()){
                    $.ajax({
                        url : "{{ route('supplier.action') }}",
                        type : "POST",
                        data : $('#form-supplier form').serialize(),
                        success : function(data){
                            $('#form-supplier').modal('hide');
                            $.notify({
                              align: 'right',       
                              from: 'top',                
                              type: 'success',               
                              icon: 'fa fa-success me-5',    
                              message: 'Berhasil Menambahkan Data'
                            });
                            table.ajax.reload();
                        },
                        error : function(){
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                    return false;
                }
            });
});
</script>
@endsection