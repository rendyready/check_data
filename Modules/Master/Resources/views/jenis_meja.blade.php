@extends('layouts.app')
@section('content')
<!-- Page Content -->
<div class="content">
  <div class="row items-push">
    <div class="col-md-12 col-xl-12">
      <div class="block block-themed h-100 mb-0">
        <div class="block-header bg-pulse">
          <h3 class="block-title">
            Jenis Meja
        </div>
        <div class="block-content text-muted">
          @csrf
          <table id="m_meja_jenis" class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th>ID</th>
                <th>NAMA JENIS MEJA WAROENG</th>
                <th>SPACE JENIS MEJA WAROENG</th>
                <th>STATUS JENIS MEJA WAROENG</th>
              </tr>
            </thead>
            <tbody id="tablecontents">
              @foreach ($data as $item)
              <tr class="row1">
                <td>{{$item->m_meja_jenis_id}}</td>
                <td>{{ucwords($item->m_meja_jenis_nama)}}</td>
                <td>{{$item->m_meja_jenis_space}}</td>
                <td>
                  {{ $item->m_meja_jenis_status==1 ? 'Active' : 'Non-Active' }}
                </td>
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
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': $("input[name=_token]").val()
      }
    });
    var t = $('#m_meja_jenis').DataTable({
      processing: false,
      serverSide: false,
      destroy: true,
      order: [0, 'asc'],
    });
    $('#m_meja_jenis').Tabledit({
      url: '{{ route("action.m_jenis_meja") }}',
      dataType: "json",
      deleteButton: false,
      columns: {
        identifier: [0, 'm_meja_jenis_id'],
        editable: [
          [1, 'm_meja_jenis_nama'],
          [2, 'm_meja_jenis_space', 'number', '{"min":"1"}'],
          [3, 'm_meja_jenis_status', 'select', '{"1":"Active","0":"Non-Active"}']
        ]
      },
      restoreButton: false,
      onSuccess: function(data, textStatus, jqXHR) {
        Codebase.helpers('jq-notify', {
          align: 'right', // 'right', 'left', 'center'
          from: 'top', // 'top', 'bottom'
          type: 'danger', // 'info', 'success', 'warning', 'danger'
          icon: 'fa fa-info me-5', // Icon class
          message: data.m_meja_jenis_nama + '<br></br>' + data.m_meja_jenis_status + '<br></br>' + data.m_meja_jenis_space,
        });
        setTimeout(function() {
          window.location.reload();
        }, 3300);
      }
    });
    $("#m_meja_jenis").append(
      $('<tfoot/>').append($("#m_meja_jenis thead tr").clone())
    );
  });
</script>
@endsection