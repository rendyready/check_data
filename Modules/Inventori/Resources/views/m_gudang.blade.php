@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Master Gudang
          </div>
          <div class="block-content text-muted">
            
            <a class="btn btn-success mr-2 mb-2 buttonInsert" title="Edit" style="color: #fff"><i class="fa fa-plus mr-5"></i> Gudang</a>
                <table id="tb_gudang" class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <th>No</th>
                        <th>Nama Gudang</th>
                        <th>Waroeng</th>
                     
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <th>No</th>
                        <th>Nama Gudang</th>
                        <th>Waroeng</th>
                  
                    </tfoot>
                </table>
             
  <!-- Select2 in a modal -->
  <div class="modal" id="form-gudang" tabindex="-1" role="dialog" aria-labelledby="form-gudang" aria-hidden="true">
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
            <form method="post" id="formAction">
              @csrf
              <div class="mb-4">
                <input type="hidden" name="action" id="action">
                <input name="m_gudang_id" type="hidden" id="m_gudang_id">
                <div class="form-group">
                  <label for="m_gudang_nama">Nama Gudang</label>
                  <div>
                      <select class="js-select2" id="m_gudang_nama" name="m_gudang_nama" style="width: 100%;" data-container="#form-gudang" data-placeholder="Pilih Nama Gudang">
                        <option></option>
                        @foreach ($nama_gudang as $item)
                            <option value="{{ucwords($item->m_gudang_nama)}}">{{ucwords($item->m_gudang_nama)}}</option>
                        @endforeach
                      </select>
                  </div>
              </div>     
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="waroeng">Waroeng</label>
                  <div>
                      <select class="js-select2" id="m_gudang_m_w_id" name="m_gudang_m_w_id" style="width: 100%;" data-container="#form-gudang" data-placeholder="Pilih Waroeng">
                          <option></option>
                          @foreach ($waroeng as $item)
                              <option value="{{$item->m_w_id}}">{{ $item->m_w_nama}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              </div>
              <div class="block-content block-content-full text-end bg-transparent">
                <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
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
      Codebase.helpersOnLoad(['jq-select2', 'jq-rangeslider']);
    var table, save_method;
        $(function() {
            table = $('#tb_gudang').DataTable({
        "destroy":true,
        "orderCellsTop": true,
        "processing": true,
        "autoWidth": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "ajax": {
            "url": "{{ route('m_gudang.list') }}",
            "type": "GET"
                }
            });
        });
      $(".buttonInsert").on('click', function() {
            $('[name="action"]').val('add');
            var id = $(this).attr('value');
            $('.js-select2').val(null).trigger('change');
            $("#myModalLabel").html('Tambah Gudang');
            $("#form-gudang").modal('show');
      });
      // $("#tb_gudang").on('click','.buttonEdit', function() {
      //           var id = $(this).attr('value');
      //           $('[name="action"]').val('edit');
      //           $('#form-gudang form')[0].reset();
      //           $("#myModalLabel").html('Ubah gudang');
      //           $.ajax({
      //               url: "/inventori/m_gudang/edit/"+id,
      //               type: "GET",
      //               dataType: 'json',
      //               success: function(respond) {
      //                   $("#m_gudang_id").val(respond.m_gudang_id).trigger('change');
      //                   $("#m_gudang_nama").val(respond.m_gudang_nama).trigger('change');
      //                   $("#m_gudang_m_w_id").val(respond.m_gudang_m_w_id).trigger('change');
      //               },
      //               error: function() {
      //               }
      //           });
      //           $("#form-gudang").modal('show');
      //       }); 
            $('#formAction').submit( function(e){
                if(!e.isDefaultPrevented()){
                    $.ajax({
                        url : "{{ route('m_gudang.action') }}",
                        type : "POST",
                        data : $('#form-gudang form').serialize(),
                        success : function(data){
                            $('#form-gudang').modal('hide');
                            Codebase.helpers('jq-notify', {
                              align: 'right', // 'right', 'left', 'center'
                              from: 'top', // 'top', 'bottom'
                              type: data.type, // 'info', 'success', 'warning', 'danger'
                              icon: 'fa fa-info me-5', // Icon class
                              message: data.messages
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