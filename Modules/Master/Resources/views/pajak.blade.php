@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Pajak
          </div>
          <div class="block-content text-muted">
            @csrf
            <table id="m_pajak" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>NILAI</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr>
                      <td>{{$item->m_pajak_id}}</td>
                      <td>{{$item->m_pajak_value}}</td>
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
      var t = $('#m_pajak').DataTable({
        processing : false,
        serverSide : false,
        destroy: true,
        order : [0,'asc'],
      });
    $('#m_pajak').Tabledit({
    url:'{{ route("action.m_pajak") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'id'],
      editable:[[1, 'm_pajak_value','number','{"min": "0.00", "step": "0.01","placeholder":"0.00"}']]
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
      if(data.request.action == 'delete')
      {
        $('#'+data.request.id).remove();
      }
    }
  });
  $("#m_pajak").append(
       $('<tfoot/>').append( $("#m_pajak thead tr").clone() )
      );
  });
  </script>
@endsection