@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Data Sub Jenis Menu
          </div>
          <div class="block-content text-muted">
            @csrf
            <table id="sub_jenis_menu" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>NAMA SUB JENIS MENU</th>
                  <th>NAMA JENIS MENU</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data->sub as $item)
                    <tr class="row1">
                      <td>{{$item->id}}</td>
                      <td>{{$item->m_sub_menu_jenis_nama}}</td>
                      <td>{{$item->m_menu_jenis_nama}}</td>
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
      var t = $('#sub_jenis_menu').DataTable({
        processing : false,
        serverSide : false,
        destroy: true,
        order : [0,'asc'],
      });
    $('#sub_jenis_menu').Tabledit({
    url:'{{ route("action.sub_jenis_menu") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'id'],
      editable:[[1, 'm_sub_menu_jenis_nama'],[2,'m_sub_menu_jenis_m_menu_jenis_id','select','{"4": "Lauk", "1": "Minuman","12":"Mutasi-WBD","9":"Non-Menu","7":"Paket","3":"Sambal","5":"Sayur","11":"WBD-Corner"}']]
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
  $("#sub_jenis_menu").append(
       $('<tfoot/>').append( $("#sub_jenis_menu thead tr").clone() )
      );
  });
  </script>
@endsection