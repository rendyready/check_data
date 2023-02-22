@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Tipe Transaksi
          </div>
          <div class="block-content text-muted">
            @csrf
            <table id="m_transaksi_tipe" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>TIPE TRANSAKSI</th>
                  <th>PROFIT IN</th>
                  <th>PROFIT OUT</th>
                  <th>PROFIT PRICE</th>
                  <th>KELOMPOK TIPE TRANSAKSI</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr>
                      <td>{{$item->m_t_t_id}}</td>
                      <td>{{$item->m_t_t_name}}</td>
                      <td>{{$item->m_t_t_profit_in}}</td>
                      <td>{{$item->m_t_t_profit_out}}</td>
                      <td>{{$item->m_t_t_profit_price}}</td>
                      <td>{{$item->m_t_t_group}}</td>
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
      var t = $('#m_transaksi_tipe').DataTable({
        processing : false,
        serverSide : false,
        destroy: true,
        order : [0,'asc'],
      });
      var att_num = '{"min": "0.00", "step": "0.01","placeholder":"0.00"}';
    $('#m_transaksi_tipe').Tabledit({
    url:'{{ route("action.m_transaksi_tipe") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'm_t_t_id'],
      editable:[[1,'m_t_t_name'],[2, 'm_t_t_profit_in','number',att_num],
      [3,'m_t_t_profit_out','number',att_num],[4,'m_t_t_profit_price','number',att_num],
      [5,'m_t_t_group','select','{"ojol":"ojol","reguler":"reguler"}']]
    },
    restoreButton:false,
    onSuccess:function(data)
    {
      $.each(data.error, function(key, value) {
           Codebase.helpers('jq-notify', {
          align: 'right', // 'right', 'left', 'center'
          from: 'top', // 'top', 'bottom'
          type: data.type, // 'info', 'success', 'warning', 'danger'
          icon: 'fa fa-info me-5', // Icon class
          message: value,
        });
        });
        setTimeout(function() {
          window.location.reload();
        }, 3000);
    }
  });
  $("#m_transaksi_tipe").append(
       $('<tfoot/>').append( $("#m_transaksi_tipe thead tr").clone() )
      );
  });
  </script>
@endsection