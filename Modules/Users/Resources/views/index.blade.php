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
                <div class="block block-rounded shadow-none mb-0">
                  <div class="block-header block-header-default">
                    <h3 class="block-title">Terms &amp; Conditions</h3>
                    <div class="block-options">
                      <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="block-content fs-sm">
                    <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                    <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                  </div>
                  <div class="block-content block-content-full block-content-sm text-end border-top">
                    <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">
                      Close
                    </button>
                    <button type="button" class="btn btn-alt-primary" data-bs-dismiss="modal">
                      Done
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END Pop Out Modal -->
          <!-- Pop In Modal -->
          <div class="block block-rounded">
            <div class="block-content">
              <a type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-popout">
                <i class="fa fa-plus">
                  Launch Modal
                </i>
              </a>
            </div>
          </div>
          <!-- END Pop In Modal -->
          <!-- <a href="#" class="btn btn-success"><i class="fa fa-plus"></i> User</a> -->
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
    var t = $('#user').DataTable();
    $("#user").append(
      $('<tfoot/>').append($("#user thead tr").clone())
    );
  });
</script>
@endsection