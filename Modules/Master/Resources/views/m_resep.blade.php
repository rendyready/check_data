@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Data Resep
          </div>
          <div class="block-content text-muted">
            <a class="btn btn-success buttonInsert"><i class="fa fa-plus"></i> Tambah</a>
            @csrf
            <table id="m_resep" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>PRODUK NAMA</th>
                    <th>STATUS RESEP</th>
                    <th>KETERANGAN</th>
                    <th>TANGGAL RILIS</th>
                    <th>AKSI</th>
                </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data->resep as $item)
                    <tr>
                      <td>{{$item->m_resep_id}}</td>
                      <td>{{$item->m_produk_nama}}</td>
                      <td>@if ($item->m_resep_status == "0")
                        <span class="badge rounded-pill bg-danger">Non Aktif</span>
                      @else
                      <span class="badge rounded-pill bg-success">Aktif</span>
                      @endif</td>
                      <td>{{$item->m_resep_keterangan}}</td>
                      <td>{{$item->m_resep_created_at}}</td>
                      <td> <a class="btn btn-info btn-sm buttonEdit" value="{{$item->m_resep_id}}" title="Edit"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-warning btn-sm buttonDetail" value="{{$item->m_resep_id}}" title="Detail"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>
                @endforeach
              </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
      <!-- Modal Resep -->
  <div class="modal" id="modal-block-select2" tabindex="-1" role="dialog" aria-labelledby="modal-block-select2" aria-hidden="true">
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
            <form method="post" action="" id="formAction">
              @csrf
                <input name="id" type="hidden" id="id">
                <div class="mb-4">
                  <div class="form-group">
                    <label for="m_resep_m_produk_id">Produk Menu</label>
                    <div>
                        <select class="js-select2" id="m_resep_m_produk_id" name="m_resep_m_produk_id" style="width: 100%;" data-container="#modal-block-select2" data-placeholder="Choose one..">
                            <option></option>
                            @foreach ($data->produk as $item)
                                <option value="{{$item->m_produk_id}}">{{ $item->m_produk_nama}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                </div>
                <div class="mb-4">
                  <div class="form-group">
                    <label for="m_resep_status">Status Resep</label>
                    <div class="space-x-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_resep_status1" name="m_resep_status" value="1" checked="">
                      <label class="form-check-label" for="m_resep_status">Aktif</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_resep_status2" name="m_resep_status" value="0">
                      <label class="form-check-label" for="m_resep_status">Non Aktif</label>
                    </div>
                  </div>
                 </div>
                </div>
                <div class="mb-4">
                  <div class="form-group">
                    <label for="m_resep_keterangan">Keterangan</label>
                    <div>
                        <textarea name="m_resep_keterangan" id="m_resep_keterangan" cols="50" rows="5"></textarea>
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
  <!-- END Modal Resep -->
        <!-- Modal Detail Resep -->
        <div class="modal modal-lg" id="modal-block-select2-detail" tabindex="-1" role="dialog" aria-labelledby="modal-block-select2-detail" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
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
                  @csrf
                  <table id="m_resep_detail_tb" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                   <thead>
                      <th>No</th>
                      <th>NAMA BB</th>
                      <th>QTY</th>
                      <th>SATUAN</th>
                   </thead>
                   <tbody id="detail_resep">
                   </tbody>
                  </table>
                    <div class="block-content block-content-full text-end bg-transparent">
                      <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                    </div>
                
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END Modal Detail Resep -->
  </div>
  <!-- END Page Content -->
@endsection
@section('js')
<script type="module">
  $(document).ready(function(){
  var t = $('#m_resep').DataTable();

  $("#m_resep").append(
       $('<tfoot/>').append( $("#m_resep thead tr").clone() )
      );
  });
  Codebase.helpersOnLoad(['jq-select2']);
  $(".buttonInsert").on('click', function() {
            var id = $(this).attr('value');
            $("#myModalLabel").html('Tambah Resep');
            $("#formAction").attr('action',"/master/m_resep/simpan");
            $("#modal-block-select2").modal('show');
      });
  $(".buttonEdit").on('click', function() {
                var id = $(this).attr('value');
                $("#myModalLabel").html('Ubah Keterangan');
                $("#formAction").attr('action','/master/m_resep/edit');
                $.ajax({
                    url: "/master/m_resep/list/"+id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                      console.log(respond)
                        $("#id").val(respond.m_resep_id).trigger('change');
                        $("#m_resep_m_produk_id").val(respond.m_resep_m_produk_id).trigger('change');
                        $("#m_resep_keterangan").val(respond.m_resep_keterangan).trigger('change');
                        $("#m_resep_status").val(respond.m_resep_status).trigger('change');
                    },
                    error: function() {
                    }
                });
                $("#modal-block-select2").modal('show');
            });
      $(".buttonDetail").on('click', function() {
                var id = $(this).attr('value');
                $("#myModalLabel").html('Detail Resep');
                var table =  $.ajax({
                    url: "/master/m_resep/detail/"+id,
                    type: "GET",
                    cache: true,
                    success: function(response){
                      console.log(response)
                      $.each(response, function (key, value) {
                        $('#detail_resep').append("<tr>\
                              <td>"+value.m_resep_detail_id+"</td>\
                              <td>"+value.m_produk_nama+"</td>\
                              <td>"+value.m_resep_detail_qty+"</td>\
                              <td>"+value.m_satuan_kode+"</td>\
                              </tr>");
                      })
                    }
				        });
                var url = "{{route('list_detail.m_resep')}}";
      var satuan = new Array(); var bb = new Array();
      $.get(url, function(response){
        satuan = response['satuan']; bb = response['bb'];
        var data = [
        [1,'m_resep_detail_bb_id','select',JSON.stringify(bb)],
        [2,'m_resep_detail_qty'],
        [3,'m_w_m_sc_id','select',JSON.stringify(satuan)]]

      $('#m_resep_detail_tb').Tabledit({
          url:'{{ route("action.m_resep") }}',
          dataType:"json",
          columns:{
            identifier:[0, 'id'],
            editable: data
          },
          restoreButton:false,
          onSuccess:function(data, textStatus, jqXHR)
          {
            if (data.action == 'add') {
                window.location.reload();
            }
            if(data.action == 'delete')
            {
               $('#'+data.id).remove();
            }
          }
          });
          $("#m_w").append(
          $('<tfoot/>').append( $("#m_w thead tr").clone() )
          );
      });
                              
                $("#modal-block-select2-detail").modal('show');
            });  
</script>
@endsection