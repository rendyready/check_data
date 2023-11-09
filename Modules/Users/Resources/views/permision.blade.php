@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Permission Akses
                    </div>
                    <div class="block-content text-muted">
                        @csrf
                        <table id="permission" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
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
    $.ajaxSetup({
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });
      var t = $('#permission').DataTable({
                processing: false,
                serverSide: false,
                destroy: true,
                pageLength: 10,
                order: [0, 'asc']});
    $('#permission').Tabledit({
    url:'{{ route("action.permission") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'id'],
      editable:[[1, 'name']]
    },
    restoreButton:false,
    onSuccess:function(data, textStatus, jqXHR)
    {
      Codebase.helpers('jq-notify', {
          align: 'right', // 'right', 'left', 'center'
          from: 'top', // 'top', 'bottom'
          type: data.type, // 'info', 'success', 'warning', 'danger'
          icon: 'fa fa-info me-5', // Icon class
          message: data.messages
        });
      if (data.action == 'add') {
        window.location.reload();
      }
      if(data.action == 'delete')
      {
        $('#'+data.id).remove();
      }
    }
  });
  $("#permission").append(
       $('<tfoot/>').append( $("#permission thead tr").clone() )
      );
  });
  </script>
@endsection
