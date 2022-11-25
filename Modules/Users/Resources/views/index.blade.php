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
            <a href="#" class="btn btn-success"><i class="fa fa-plus"></i> User</a>
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
  $(document).ready(function(){
        var t = $('#user').DataTable();
        $("#user").append(
        $('<tfoot/>').append( $("#user thead tr").clone() )
        );
  });
  </script>
@endsection