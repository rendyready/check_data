@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Footer Nota
          </div>
          <div class="block-content text-muted">
            @csrf
            <table id="footer" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>TEXT FOOTER NOTA</th>
                  <th>PRIORITAS URUT</th>
                  <th>NAMA WAROENG</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr class="row1">
                      <td>{{$item->m_footer_id}}</td>
                      <td>{{$item->m_footer_value}}</td>
                      <td>{{$item->m_footer_priority}}</td>
                      <td>{{$item->m_w_nama}}</td>
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
      var t = $('#m_w_jenis').DataTable({
        processing : false,
        serverSide : false,
        destroy: true,
        order : [0,'asc'],
      });
      var url = "{{route('conf_footer.list')}}";
      var mw = new Array();
      $.get(url, function(response){
          var mw = response['mw'];
          console.log(mw);
          $('#footer').Tabledit({
          url:'{{ route("action.conf_footer") }}',
          dataType:"json",
          columns:{
            identifier:[0, 'm_footer_id'],
            editable:[[1, 'm_footer_value'],[2,'m_footer_priority','number','{"step": "1","placeholder":"0"}'],[3,'m_footer_m_w_id','select',JSON.stringify(mw)]]
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
          $("#footer").append(
              $('<tfoot/>').append( $("#footer thead tr").clone() )
              );
      });
  });
  </script>
@endsection