@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Data Modal
          </div>
          <div class="block-content text-muted">
            @csrf
            <table id="modal_tipe" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>NAMA MODAL TIPE</th>
                  <th>PARENT MODAL TIPE</th>
                  <th>NOMINAL</th>
                  <th>URUTAN TIPE</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data->m_modal_tipe as $item)
                    <tr class="row1">
                      <td>{{$item->m_modal_tipe_id}}</td>
                      <td>{{$item->m_modal_tipe_nama}}</td>
                      <td>
                        @if(!empty($item->m_modal_tipe_parent_id) && !empty($item->m_modal_tipe))
                        {{$item->m_modal_tipe->m_modal_tipe_nama}}
                        @endif
                      </td>
                      <td>{{$item->m_modal_tipe_nominal}}</td>
                      <td>{{$item->m_modal_tipe_urut}}</td>
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
      var t = $('#modal_tipe').DataTable({
        processing : false,
        serverSide : false,
        destroy: true,
        order : [0,'asc'],
      });
      
    $('#modal_tipe').Tabledit({
    url:'{{ route("action.modal_tipe") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'm_modal_tipe_id'],
      editable:[[1, 'm_modal_tipe_nama'],[2,'m_menu_jenis_odcr55','select','{"makan": "makan", "minum": "minum"}']]
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
  $("#modal_tipe").append(
       $('<tfoot/>').append( $("#modal_tipe thead tr").clone() )
      );
  });
  </script>
@endsection