@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              NOTA
          </div>
          <div class="block-content text-muted">
            <button type="button" class="btn btn-sm btn-success addbtn" id="addnota"><i class="fa fa-plus"> Nota </i></button>
            <button type="button" class="btn btn-sm btn-danger updatemenu" data-bs-toggle="modal" data-bs-target="#modal-fadein"><i class="fa fa-plus"> Update Menu global </i></button>
            @csrf
            <table id="m_jenis_nota" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
                <th>ID</th>
                <th>NAMA WAROENG</th>
                <th>TIPE TRANSAKSI</th>
                {{-- <th>JUMLAH MENU</th> --}}
                <th>ACTION</th>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr>
                      <td>{{$item->m_jenis_nota_id}}</td>
                      <td>{{$item->m_w_nama}}</td>
                      <td>{{$item->m_t_t_name}}</td>
                      {{-- <td>{{$item->total}}</td> --}}
                      <td>
                        {{-- <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-fadein"><i class="fa fa-edit"></i></button>        
                        </button> --}}
                        <a class="btn btn-warning buttonEdit" value="{{$item->m_jenis_nota_id}}" title="Edit"><i class="fa fa-edit"></i></a>
                        <a href="{{route('m_jenis_nota.index',$item->m_jenis_nota_id)}}"
                           class="btn btn-info" title="Detail">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button id="deletem_jenis_nota{{$item->m_jenis_nota_id}}" class="btn btn-danger">
                            <i class="fa fa-eraser"></i>
                        </button>
                    </td>
                    </tr>
                @endforeach
              </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Fade In Modal -->
  <div class="modal fade" id="modal-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-themed shadow-none mb-0">
          <div class="block-header block-header-default bg-pulse">
            <h3 class="block-title">Nota</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content fs-sm">
            <form id="f_jenis_nota">
              <input type="hidden" name="m_jenis_nota_id">
              <div></div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_jenis_nota_m_w_id">Nama Waroeng</label>
                  <select class="js-select2" id="m_jenis_nota_m_w_id" name="m_jenis_nota_m_w_id" style="width: 100%;" data-container="#f_jenis_nota" data-placeholder="Choose one..">
                      @foreach ($listWaroeng as $wr)
                          <option value="{{$wr->m_w_id}}">{{ucwords($wr->m_w_nama)}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label  for="m_jenis_nota_m_t_t_id">Jenis Transaksi </label>
                  <select class="js-select2" id="m_jenis_nota_m_t_t_id" name="m_jenis_nota_m_t_t_id" style="width: 100%;" data-container="#f_jenis_nota" data-placeholder="Choose one..">
                    @foreach ($listTipeTransaksi as $tipe)
                          <option value="{{$tipe->m_t_t_id}}">{{ucwords($tipe->m_t_t_name)}}</option>
                    @endforeach  
                  </select>
                </div>
              </div>
            </form>
          </div>
          <div class="block-content block-content-full block-content-sm text-end border-top">
            <button type="button" class="btn btn-alt-warning" data-bs-dismiss="modal">
              Close
            </button>
            <button type="submit" class="btn btn-save btn-alt-success" id="saveBtn" value="create" data-bs-dismiss="modal">
              Simpan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Fade In Modal -->
  <!-- END Page Content -->
@endsection
@section('js')
<script type="module">
$(document).ready(function(){
  $('.js-select2').select2({dropdownParent: $('#f_jenis_nota')})

  var action;
  $.ajaxSetup({
    headers:{
    'X-CSRF-Token' : $("input[name=_token]").val()
      }
    });
    
    var t = $('#m_jenis_nota').DataTable({
      processing : false,
      serverSide : false,
      destroy: true,
      button :false,
      order : [0,'asc'],
    });
    $("#m_jenis_nota").append(
      $('<tfoot/>').append( $("#m_jenis_nota thead tr").clone() )
    );

    const modal = new bootstrap.Modal($('#modal-fadein'))
    $('#addnota').click(function () {
      $('#saveBtn').val("create-product");
      $('#m_jenis_nota_id').val('');
      $('#m_jenis_nota_m_w_id').val('').trigger('change');
      $('#m_jenis_nota_m_t_t_id').val('').trigger('change');
      $('#f_jenis_nota').trigger("reset");
      $('.block-title').html("Buat Nota");
      $('#modal-fadein').modal('show');
    });

    $('#saveBtn').click(function (e) {
      console.log('simpan')
      e.preventDefault();
      $(this).html('Simpan');
    
      $.ajax({
        data: $('#modal-fadein form').serialize(),
        url: "{{route('store.m_jenis_nota')}}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
          console.log(data)
            $('#f_jenis_nota').trigger("reset");
            $('#modal-fadein').modal('hide');
            // window.location.reload();
          
        },
        error: function (data) {
            console.log('Error:', data);
            $('#saveBtn').html('Save Changes');
        }
    });

    $(".buttonEdit").click(function (e) {
      console.log('edit')
      // $("#meja_text").show();
      // $("#meja_slider").hide()
      // var id = $(this).attr('value');
      // $("#myModalLabel").html('Ubah Meja');
      // $("#formAction").attr('action','/master/meja/edit');
      // $.ajax({
      //     url: "/master/meja/list/"+id,
      //     type: "GET",
      //     dataType: 'json',
      //     success: function(respond) {
      //       console.log(respond)
      //         $("#id_meja").val(respond.m_meja_id).trigger('change');
      //         $("#nama_meja").val(respond.m_meja_nama).trigger('change');
      //         $("#jenis_meja").val(respond.m_meja_m_meja_jenis_id).trigger('change');
      //         $("#waroeng").val(respond.m_meja_m_w_id).trigger('change');
      //     },
      //     error: function() {
      //     }
      // });
      // $("#modal-block-select2").modal('show');
    }); 
  });

    // $('.btn-save').on("submit",function(){
    //               var id = $('#id').val();
    //               console.log(action);
    //               $.ajax({
    //                   url : "{{route('store.m_jenis_nota')}}",
    //                   type : "POST",
    //                   data : $('#modal-fadein form').serialize(),
    //                   success : function(data){
    //                       modal.hide();
    //                       window.location.reload();
    //                   },
    //                   error : function(){
    //                       alert("Tidak dapat menyimpan data!");
    //                   }
    //               });
                
    //       });

    
});
</script>
@endsection