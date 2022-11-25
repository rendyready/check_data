@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              MEJA
          </div>
          <div class="block-content text-muted">
            <a class="btn btn-success mr-5 mb-5 buttonInsert" title="Edit" style="color: #fff"><i class="fa fa-plus mr-5"></i>  Meja</a>
            <table id="m_meja" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                <th>No.</th>
                <th>Nama Meja</th>
                <th>Jenis Meja</th>
                <th>Waroeng</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data->meja as $item)
                    <tr>
                      <td>{{$data->no++}}</td>
                      <td>{{$item->m_meja_nama}}</td>
                      <td>{{$item->m_meja_jenis_nama}}</td>
                      <td>{{$item->m_w_nama}}</td>
                      <td> <a class="btn btn-info buttonEdit" value="{{$item->m_meja_id}}" title="Edit"><i class="fa fa-edit"></i></a>
                           <a href="{{route('hapus.meja',$item->m_meja_id)}}" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                @endforeach
              </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  <!-- Select2 in a modal -->
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
              <div class="mb-4">
                <input name="id_meja" type="hidden" id="id_meja">
                        <div class="form-group" id="meja_text">
                            <label for="nama_meja">Nama Meja</label>
                            <div>
                                <input class="form-control" type="text" name="nama_meja" id="nama_meja" style="width: 100%;">
                            </div>
                        </div>
              </div>
              <div class="mb-4">
                <div class="form-group" id="meja_slider">
                  <label for="nama_meja">Nama Meja</label>
                  <div style="margin: 20px 0 50px 0;">
                      <input name="mulai_meja" type="hidden" class="mulai_meja">
                      <input name="selesai_meja" type="hidden" class="selesai_meja">
                      <input class="js-range-slider">
                  </div>
              </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="jenis_meja">Jenis Meja</label>
                  <div>
                      <select class="js-select2" id="jenis_meja" name="jenis_meja" style="width: 100%;" data-container="#modal-block-select2" data-placeholder="Choose one..">
                          <option></option>
                          @foreach ($data->jenis_meja as $item)
                              <option value="{{$item->m_meja_jenis_id}}">{{ $item->m_meja_jenis_nama}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="waroeng">Waroeng</label>
                  <div>
                      <select class="js-select2" id="waroeng" name="waroeng" style="width: 100%;" data-container="#modal-block-select2" data-placeholder="Choose one..">
                          <option></option>
                          @foreach ($data->waroeng as $item)
                              <option value="{{$item->m_w_id}}">{{ $item->m_w_nama}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              </div>
              <div class="block-content block-content-full text-end bg-body">
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
    $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 1,
        max: 60,
        from: 1,
        to: 30,
        grid: true,
        onChange: function(data) {
                    $(".mulai_meja").val(data.from);
                    $(".selesai_meja").val(data.to);
                }
            });
    
      var t = $('#m_meja').DataTable({
        processing : false,
        serverSide : false,
        destroy: true,
        buttons:[],
        pageLength: 10,
        order : [0,'asc'],
      });

      $(".buttonInsert").on('click', function() {
          $("#meja_slider").show();
          $("#meja_text").hide()
            var id = $(this).attr('value');
            $("#myModalLabel").html('Tambah Meja');
            $("#formAction").attr('action',"/master/meja/simpan");
            $("#modal-block-select2").modal('show');
      });
      $(".buttonEdit").on('click', function() {
                $("#meja_text").show();
                $("#meja_slider").hide()
                var id = $(this).attr('value');
                $("#myModalLabel").html('Ubah Meja');
                $("#formAction").attr('action','/master/meja/edit');
                $.ajax({
                    url: "/master/meja/list/"+id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                      console.log(respond)
                        $("#id_meja").val(respond.m_meja_id).trigger('change');
                        $("#nama_meja").val(respond.m_meja_nama).trigger('change');
                        $("#jenis_meja").val(respond.m_meja_m_meja_jenis_id).trigger('change');
                        $("#waroeng").val(respond.m_meja_m_w_id).trigger('change');
                    },
                    error: function() {
                    }
                });
                $("#modal-block-select2").modal('show');
            }); 
      $("#m_meja").append(
          $('<tfoot/>').append( $("#m_meja thead tr").clone() )
          );
  });
  </script>
@endsection