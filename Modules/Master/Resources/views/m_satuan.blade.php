@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Data Satuan
          </div>
          <div class="block-content text-muted">
            @csrf
            <table id="m_satuan" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>No.</th>
                  <th>KODE SATUAN</th>
                  <th>KETERANGAN</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr>
                      <td>{{$item->m_satuan_id}}</td>
                      <td>{{$item->m_satuan_kode}}</td>
                      <td>{{$item->m_satuan_keterangan}}</td>
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
      var t = $('#m_satuan').DataTable();
    $('#m_satuan').Tabledit({
    url:'{{ route("action.m_satuan") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'id'],
      editable:[[1, 'm_satuan_kode'],[2,'m_satuan_keterangan','textarea','{"rows": "3", "cols": "5", "maxlength": "200", "wrap": "hard"}']]
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
  $("#m_satuan").append(
       $('<tfoot/>').append( $("#m_satuan thead tr").clone() )
      );
  });
  </script>
@endsection