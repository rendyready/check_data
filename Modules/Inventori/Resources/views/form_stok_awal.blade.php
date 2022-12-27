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
              <div class="col-md-4">
                  <div class="row mb-1">
                      <label class="col-sm-4 col-form-label" for="tgl_now">Tanggal</label>
                      <div class="col-sm-8">
                        <input type="date" class="form-control form-control-sm" id="tgl_now" name="tgl_now" value="{{$tgl_now}}" readonly>
                      </div>
                  </div>
              </div>
              <div class="col-md-5">
                  <div class="row mb-2">
                      <label class="col-sm-4 col-form-label" for="rekap_po_supplier_id">Nama Waroeng</label>
                      <div class="col-sm-8">
                        <select class="js-select2 form-control-sm" style="width: 100%;" name="rekap_po_supplier_id" id="rekap_po_supplier_id" data-placeholder="Pilih Waroeng">
                        <option></option>
                        @foreach ($waroeng as $item)
                        @if ($item->m_w_id ==  $stok_mw)
                        <option value="{{$item->m_w_id}}" selected>{{$item->m_w_nama}}</option>  
                        @else
                        <option value="{{$item->m_w_id}}">{{$item->m_w_nama}}</option>  
                        @endif
                        @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="row mb-2">
                      <label class="col-sm-4 col-form-label" for="rekap_po_supplier_nama">Gudang</label>
                      <div class="col-sm-8">
                        <select class="js-select2 form-control-sm" style="width: 100%;" name="m_stok_gudang" id="m_stok_gudang" data-placeholder="Pilih Gudang">
                          <option value=""></option>
                          <option value="gudang utama" selected>Gudang Utama</option>
                          <option value="gudang produksi">Gudang Produksi</option>
                          <option value="gudang wbd">Gudang WBD</option>
                        </select>
                      </div>
                  <div class="row mb-4">
                      <label class="col-sm-4 col-form-label" for="rekap_po_tgl">Pencarian</label>
                    <div class="col-sm-8 py-2 px-lg-4">
                      <button class="btn btn-lg btn-warning"> Cari</button>
                    </div>
                  </div>
              </div>
            </div>
                <table id="tb_supplier" class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Stok Awal</th>
                        <th>Satuan</th>
                    </thead>
                    <tbody>
                      @php
                          $no=0;
                      @endphp
                      @foreach ($data as $item)
                      <tr>
                        <td>{{$no++}}</td>
                        <td>{{$item->m_stok_m_produk_nama}}</td>
                        <td>{{$item->stok_awal}}</td>
                        <td>{{$item->m_stok_satuan}}</td>
                      </tr>
                      @endforeach
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
                <div class="form-group">
                  <label for="m_supplier_kota">Kota Supplier</label>
                    <div>
                      <input class="form-control" type="text" name="m_supplier_kota" id="m_supplier_kota" style="width: 100%;" required>
                    </div>
              </div>
              <div class="form-group">
                <label for="m_supplier_telp">Telp Supplier</label>
                  <div>
                    <input class="form-control" type="number" name="m_supplier_telp" id="m_supplier_telp" style="width: 100%;" required>
                  </div>
            </div>
            <div class="form-group">
              <label for="m_supplier_ket">Keterangan Supplier</label>
                <div>
                  <textarea class="form-control" type="text" name="m_supplier_ket" id="m_supplier_ket" style="width: 100%;" cols="3" rows="2" required></textarea>
                </div>
            </div>
            <div class="form-group">
              <label for="m_supplier_jth_tempo">Durasi Jatuh Tempo Pembayaran</label>
                <div>
                  <input class="form-control" type="number" min="0" name="m_supplier_jth_tempo" id="m_supplier_jth_tempo" style="width: 100%;" required>
                </div>
          </div>
            <div class="form-group">
              <label for="m_supplier_rek">No Rekening</label>
                <div>
                  <input class="form-control" type="number" name="m_supplier_rek" id="m_supplier_rek" style="width: 100%;">
                </div>
            </div>
          <div class="form-group">
            <label for="m_supplier_rek_nama">Nama Rekening</label>
              <div>
                <input class="form-control" type="text" name="m_supplier_rek_nama" id="m_supplier_rek_nama" style="width: 100%;" >
              </div>
          </div>
          <div class="form-group">
            <label for="m_supplier_bank_nama">Nama Bank</label>
              <div>
                <input class="form-control" type="text" name="m_supplier_bank_nama" id="m_supplier_bank_nama" style="width: 100%;" >
              </div>
          </div>
          <div class="form-group">
            <label for="m_supplier_saldo_awal">Saldo Awal</label>
              <div>
                <input class="form-control" type="number" name="m_supplier_saldo_awal" id="m_supplier_saldo_awal" style="width: 100%;">
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
    var mw = $('')
        $(function() {
            table = $('#tb_supplier').DataTable();
        });
      $(".buttonInsert").on('click', function() {
            $('[name="action"]').val('add');
            var id = $(this).attr('value');
            $('#form-supplier form')[0].reset();
            $("#myModalLabel").html('Tambah Supplier');
            $("#form-supplier").modal('show');
      });
      $("#tb_supplier").on('click','.buttonEdit', function() {
                var id = $(this).attr('value');
                $('[name="action"]').val('edit');
                $('#form-supplier form')[0].reset();
                $("#myModalLabel").html('Ubah Supplier');
                $.ajax({
                    url: "/inventori/supplier/edit/"+id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                        $("#m_supplier_id").val(respond.m_supplier_id).trigger('change');
                        $("#m_supplier_nama").val(respond.m_supplier_nama).trigger('change');
                        $("#m_supplier_alamat").val(respond.m_supplier_alamat).trigger('change');
                        $("#m_supplier_kota").val(respond.m_supplier_kota).trigger('change');
                        $("#m_supplier_telp").val(respond.m_supplier_telp).trigger('change');
                        $("#m_supplier_ket").val(respond.m_supplier_ket).trigger('change');
                        $("#m_supplier_rek").val(respond.m_supplier_rek).trigger('change');
                        $("#m_supplier_rek_nama").val(respond.m_supplier_rek_nama).trigger('change');
                        $("#m_supplier_bank_nama").val(respond.m_supplier_bank_nama).trigger('change');
                        $("#m_supplier_saldo_awal").val(respond.m_supplier_saldo_awal).trigger('change');
                    },
                    error: function() {
                    }
                });
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