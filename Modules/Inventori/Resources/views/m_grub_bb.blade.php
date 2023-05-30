@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Master Grub Bahan Baku
                    </div>
                    <div class="block-content text-muted">
                        <a class="btn btn-success mr-2 mb-2 buttonInsert" title="Edit" style="color: #fff"><i
                                class="fa fa-plus mr-5"></i> Grub BB</a>
                        <table id="tb_bb_std"
                            class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <th>No</th>
                                <th>Nama BB Asal</th>
                                <th>Nama BB Relasi</th>
                                <th>Qty BB Relasi</th>
                                <th>Porsi Kotor BB Relasi</th>
                                <th>Satuan</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>No</th>
                                <th>Nama BB Asal</th>
                                <th>Nama BB Relasi</th>
                                <th>Qty BB Relasi</th>
                                <th>Porsi Kotor BB Relasi</th>
                                <th>Satuan</th>
                                <th>Aksi</th>
                            </tfoot>
                        </table>
                        <!-- Select2 in a modal -->
                        <div class="modal" id="form_std_bb" tabindex="-1" role="dialog" aria-labelledby="form_std_bb"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="block block-themed shadow-none mb-0">
                                        <div class="block-header block-header-default bg-pulse">
                                            <h3 class="block-title" id="myModalLabel"></h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i class="fa fa-fw fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <!-- Select2 is initialized at the bottom of the page -->
                                            <form id="formAction" name="form_action" method="post">
                                                <div class="mb-4">
                                                    <input name="action" type="hidden" id="action">
                                                    <input type="hidden" id="id" name="id">
                                                          <div class="form-group">
                                                        <label for="m_std_bb_resep_m_produk_code_asal">Produk Asal</label>
                                                        <div>
                                                            <select class="js-select2"
                                                                id="m_std_bb_resep_m_produk_code_asal"
                                                                name="m_std_bb_resep_m_produk_code_asal"
                                                                style="width: 100%;" data-container="#form_std_bb"
                                                                data-placeholder="Pilih Nama Produk">
                                                                <option></option>
                                                                @foreach ($produk as $item)
                                                                    <option value="{{ $item->m_produk_code }}">
                                                                        {{ ucwords($item->m_produk_nama) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_std_bb_resep_m_produk_code_relasi">Produk
                                                            Relasi</label>
                                                        <div>
                                                            <select class="js-select2"
                                                                id="m_std_bb_resep_m_produk_code_relasi"
                                                                name="m_std_bb_resep_m_produk_code_relasi"
                                                                style="width: 100%;" data-container="#form_std_bb"
                                                                data-placeholder="Pilih Nama Produk">
                                                                <option></option>
                                                                @foreach ($produk as $item)
                                                                    <option value="{{ $item->m_produk_code }}">
                                                                        {{ ucwords($item->m_produk_nama) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_std_bb_resep_qty">Qty/Berat BB</label>
                                                        <div>
                                                            <input class="form-control number" type="text"
                                                                name="m_std_bb_resep_qty" id="m_std_bb_resep_qty"
                                                                style="width: 100%;" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_std_bb_resep_porsi">Standar Per Porsi</label>
                                                        <div>
                                                            <input class="form-control number" type="text"
                                                                name="m_std_bb_resep_porsi" id="m_std_bb_resep_porsi"
                                                                style="width: 100%;" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="m_std_bb_resep_m_satuan_id">Satuan
                                                          </label>
                                                      <div>
                                                          <select class="js-select2"
                                                              id="m_std_bb_resep_m_satuan_id"
                                                              name="m_std_bb_resep_m_satuan_id"
                                                              style="width: 100%;" data-container="#form_std_bb"
                                                              data-placeholder="Pilih Satuan">
                                                              <option></option>
                                                              @foreach ($satuan as $item)
                                                                  <option value="{{ $item->m_satuan_id }}">
                                                                      {{ ucwords($item->m_satuan_kode) }}</option>
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  </div>
                                                </div>
                                        </div>
                                        <div class="block-content block-content-full text-end bg-body">
                                            <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                                data-bs-dismiss="modal">Close</button>
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
    var table, save_method;
        $(function() {
            table = $('#tb_bb_std').DataTable({
        "destroy":true,
        "orderCellsTop": true,
        "processing": true,
        "autoWidth": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "ajax": {
            "url": "{{ route('m_grub_bb.list') }}",
            "type": "GET"
                }
            });
        });
      $(".buttonInsert").on('click', function() {
            $('[name="action"]').val('add');
            var id = $(this).attr('value');
            $('#form_std_bb form')[0].reset();
            $("#myModalLabel").html('Tambah Grub BB');
            $("#form_std_bb").modal('show');
      });
      $("#tb_bb_std").on('click','.buttonEdit', function() {
                var id = $(this).attr('value');
                $('[name="action"]').val('edit');
                $('#form_std_bb form')[0].reset();
                $("#myModalLabel").html('Ubah Grub BB');
                $.ajax({
                    url: "/inventori/m_grub_bb/edit/"+id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                        $("#m_supplier_code").val(respond.m_supplier_code).trigger('change');
                        $("#m_supplier_nama").val(respond.m_supplier_nama).trigger('change');
                        $("#m_supplier_alamat").val(respond.m_supplier_alamat).trigger('change');
                        $("#m_supplier_kota").val(respond.m_supplier_kota).trigger('change');
                        $("#m_supplier_telp").val(respond.m_supplier_telp).trigger('change');
                        $("#m_supplier_ket").val(respond.m_supplier_ket).trigger('change');
                        $("#m_supplier_rek").val(respond.m_supplier_rek).trigger('change');
                        $("#m_supplier_rek_nama").val(respond.m_supplier_rek_nama).trigger('change');
                        $("#m_supplier_bank_nama").val(respond.m_supplier_bank_nama).trigger('change');
                        $("#m_supplier_saldo_awal").val(respond.m_supplier_saldo_awal).trigger('change');
                        $("#m_supplier_jth_tempo").val(respond.m_supplier_jth_tempo).trigger('change');
                    },
                    error: function() {
                    }
                });
                $("#form_std_bb").modal('show');
            }); 
            $('#formAction').submit( function(e){
                if(!e.isDefaultPrevented()){
                    $.ajax({
                        url : "{{ route('m_grub_bb.action') }}",
                        type : "POST",
                        data : $('#form_std_bb form').serialize(),
                        success : function(data){
                            $('#form_std_bb').modal('hide');
                            Codebase.helpers('jq-notify', {
                              align: 'right', // 'right', 'left', 'center'
                              from: 'top', // 'top', 'bottom'
                              type: data.type, // 'info', 'success', 'warning', 'danger'
                              icon: 'fa fa-info me-5', // Icon class
                              message: data.messages
                            });
                            console.log(data);
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
