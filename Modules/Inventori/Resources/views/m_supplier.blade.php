@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Master Supplier
          </div>
          <div class="block-content text-muted">
            <a class="btn btn-success mr-2 mb-2 buttonInsert" title="Edit" style="color: #fff"><i class="fa fa-plus mr-5"></i>Supplier</a>
                <div class="table-responsive">
                <table id="tb_supplier" class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <th>No</th>
                        <th>Code</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kota</th>
                        <th>Telp</th>
                        <th>Keterangan</th>
                        <th>Saldo</th>
                        <th>Rekening</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <th>No</th>
                      <th>Code</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Kota</th>
                      <th>Telp</th>
                      <th>Keterangan</th>
                      <th>Saldo</th>
                      <th>Rekening</th>
                      <th>Aksi</th>
                    </tfoot>
                </table>
                </div>
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
                    <label for="m_supplier_nama">Nama Supplier</label>
                      <div>
                        <input class="form-control" type="text" name="m_supplier_nama" id="m_supplier_nama" style="width: 100%;" required>
                      </div>
                </div>
                <div class="form-group">
                  <label for="m_supplier_alamat">Alamat Supplier</label>
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
  $.ajaxSetup({
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });
    Codebase.helpersOnLoad(['jq-notify']);
    var table, save_method;
        $(function() {
            table = $('.table').DataTable({
        "destroy":true,
        "orderCellsTop": true,
        "processing": true,
        "autoWidth": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "ajax": {
            "url": "{{ route('supplier.data') }}",
            "type": "GET"
                }
            });
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