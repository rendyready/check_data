@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Master Waroeng
          </div>
          <div class="block-content text-muted">
            @csrf
            <div class="table-responsive">
            <table id="m_w" class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>NAMA WAROENG</th>
                  <th>STATUS WAROENG</th>
                  <th>ALAMAT WAROENG</th>
                  <th>GRAB</th>
                  <th>GOJEK</th>
                  <th>AREA</th>
                  <th>JENIS WAROENG</th>
                  <th>JENIS NOTA WAROENG</th>
                  <th>MODAL TIPE WAROENG</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                {{-- @foreach ($data as $item)
                    <tr class="row1">
                      <td>{{$item->m_w_id}}</td>
                      <td>{{$item->m_w_nama}}</td>
                    </tr>
                @endforeach --}}
              </tbody>
          </table>
            </div>
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
      var t = $('#m_w').DataTable({
        processing : false,
        serverSide : false,
        destroy: true,
        order : [0,'asc'],
      });
      var url = "{{route('m_waroeng.list')}}";
      var area = new Array(); var jenisnota = new Array();
      var jenisw = new Array(); var modaltipe = new Array();
      $.get(url, function(response){
        area = response['area']; modaltipe = response['modalt'];
        jenisw= response['jenisw'];
        var data = [[1, 'm_w_nama'],
        [2,'m_w_status','select','{"1": "Active", "0": "Disable"}'],
        [3,'m_w_a_alamat'],
        [6,'m_w_m_area_id','select',JSON.stringify(area)],
        [7,'m_w_m_w_jenis_id','select',JSON.stringify(jenisw)],
        [8,'m_w_m_jenis_nota_id','select',JSON.stringify()],
        [9,'m_w_m_modal_tipe_id','select',JSON.stringify(modaltipe)]  
        ] 
      $('#m_w').Tabledit({
          url:'{{ route("action.m_waroeng") }}',
          dataType:"json",
          columns:{
            identifier:[0, 'm_w_id'],
            editable: data
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
  });
  </script>
@endsection