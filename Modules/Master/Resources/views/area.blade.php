@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Data Area
          </div>
          <div class="block-content text-muted">
            @csrf
            <table id="sample_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>No.</th>
                  <th>Nama Area</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr>
                      <td>{{$item->m_area_id}}</td>
                      <td>{{$item->m_area_nama}}</td>
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
      var t = $('#sample_data').DataTable();
    $('#sample_data').Tabledit({
    url:'{{ route("action.area") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'id'],
      editable:[[1, 'm_area_nama']]
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
  $("#sample_data").append(
       $('<tfoot/>').append( $("#sample_data thead tr").clone() )
      );
  });
  </script>
@endsection