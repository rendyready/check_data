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
                  <th>PAJAK</th>
                  <th>SC</th>
                  <th>AREA</th>
                  <th>JENIS WAROENG</th>
                  <th>JENIS NOTA WAROENG</th>
                  <th>MODAL TIPE</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr class="row1">
                      <td>{{$item->m_w_id}}</td>
                      <td>{{$item->m_w_nama}}</td>
                      <td>@if ($item->m_w_status==1)
                          Active @else Disable
                      @endif
                      </td>
                      <td>{{$item->m_w_alamat}}</td>
                      <td>{{$item->m_pajak_value}}</td>
                      <td>{{$item->m_sc_value}}</td>
                      <td>{{$item->m_area_nama}}</td>
                      <td>{{$item->m_w_jenis_nama}}</td>
                      <td>{{$item->m_jenis_nota_nama}}</td>
                      <td>{{$item->m_modal_tipe_nama}}</td>
                    </tr>
                @endforeach
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
      var area = new Array(); var jenisnota = new Array(); var jenisn= new Array();
      var jenisw = new Array(); var modaltipe = new Array(); var pajak=new Array(); var sc=new Array();
      $.get(url, function(response){
        area = response['area']; modaltipe = response['modalt'];
        jenisw= response['jenisw']; jenisn=response['jenisn'];
        pajak=response['pajak']; sc=response['sc'];
        var data = [[1, 'm_w_nama'],
        [2,'m_w_status','select','{"1": "Active", "0": "Disable"}'],
        [3,'m_w_alamat','textarea','{"rows": "3", "cols": "5", "maxlength": "200", "wrap": "hard"}'],
        [4,'m_w_m_pajak_id','select',JSON.stringify(pajak)],
        [5,'m_w_m_sc_id','select',JSON.stringify(sc)],
        [6,'m_w_m_area_id','select',JSON.stringify(area)],
        [7,'m_w_m_w_jenis_id','select',JSON.stringify(jenisw)],
        [8,'m_w_m_jenis_nota_id','select',JSON.stringify(jenisn)],
        [9,'m_w_m_modal_tipe_id','select',JSON.stringify(modaltipe)]]

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
          $("#m_w").append(
          $('<tfoot/>').append( $("#m_w thead tr").clone() )
          );
      });
  });
  </script>
@endsection