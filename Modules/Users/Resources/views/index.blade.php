@extends('layouts.app')
@section('content')
<!-- Page Content -->
<div class="content">
  <div class="row items-push">
    <div class="col-md-12 col-xl-12">
      <div class="block block-themed h-100 mb-0">
        <div class="block-header bg-pulse">
          <h3 class="block-title">
            Users
        </div>
        <div class="block-content text-muted">
          <!-- Pop Out Modal -->
          <div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout" role="document">
              <div class="modal-content">
                <div class="block block-themed block-rounded shadow-none mb-0">
                  <div class="block-header block-header-default bg-pulse">
                    <h3 class="block-title" id="myModalLabel"></h3>
                    <div class="block-options">
                      <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="block-content fs-sm">
                    <form id="formAction" method="post">
                      <div class="mb-4">
                        <input name="id" type="hidden" id="id">
                        <div class="form-group">
                          <label for="name">Nama User</label>
                            <div>
                              <input class="form-control" type="text" name="name" id="name" style="width: 100%;" required>
                            </div>
                        </div>
                      </div>
                      <div class="mb-4">
                        <div class="form-group">
                          <label for="email">Email User</label>
                            <div>
                              <input class="form-control" type="email" name="email" id="email" style="width: 100%;" required placeholder="Masukan Email" autocomplete="off">
                            </div>
                        </div>
                      </div>
                      <div class="mb-4">
                        <div class="form-group">
                          <label for="password">Password User</label>
                            <div>
                              <input class="form-control" type="password" name="password" id="password" style="width: 100%;" required>
                            </div>
                        </div>
                      </div>
                      <div class="mb-4">
                        <div class="form-group">
                          <label for="roles">Hak Akses</label>
                          <div>
                              <select class="js-select2" id="roles" name="roles" style="width: 100%;" data-container="#modal-popout" data-placeholder="Choose one..">
                                  <option></option>
                                  @foreach ($data->roles as $item)
                                      <option value="{{$item->id}}">{{ $item->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      </div>
                      <div class="mb-4">
                        <div class="form-group">
                          <label for="waroeng_id">Wilayah Kerja</label>
                          <div>
                              <select class="js-select2" id="waroeng_id" name="waroeng_id" style="width: 100%;" data-container="#modal-popout" data-placeholder="Choose one..">
                                  <option></option>
                                  @foreach ($data->waroeng as $item)
                                      <option value="{{$item->m_w_id}}">{{ $item->m_w_nama}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      </div>
                  </div>
                  <div class="block-content block-content-full block-content-sm text-end border-top">
                    <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">
                      Close
                    </button>
                    <button type="submit" class="btn btn-alt-success" data-bs-dismiss="modal">
                      Simpan
                    </button>
                  </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
          <!-- END Pop Out Modal -->
          <a class="btn btn-success mr-2 mb-2 buttonInsert" title="Edit" style="color: #fff"><i class="fa fa-plus mr-5"></i>  User</a>
          @csrf
          <table id="user" class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th>No.</th>
                <th>NAMA USER</th>
                <th>EMAIL</th>
                <th>HAK AKSES</th>
                <th>AKSI</th>
              </tr>
            </thead>
            <tbody id="tablecontents">
              @foreach ($data->users as $item)
              <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->username}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->rolename}}</td>
                <td><a class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                  <a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
<!-- END Page Content -->
@endsection
@section('js')
<script type="module">
  $(document).ready(function() {
    Codebase.helpersOnLoad(['jq-select2']);
    var t = $('#user').DataTable();
    $("#user").append(
      $('<tfoot/>').append($("#user thead tr").clone())
    );

    $(".buttonInsert").on('click', function() {
            var id = $(this).attr('value');
            $("#myModalLabel").html('Tambah User');
            $("#modal-popout").modal('show');
      });
      $(".buttonEdit").on('click', function() {
                var id = $(this).attr('value');
                $("#myModalLabel").html('Ubah User');
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
  });
</script>
@endsection