@extends('layouts.app')
@section('content')
<!-- Page Content -->
<div class="content">
  <div class="row items-push">
    <div class="col-md-12 col-xl-12">
      <div class="block block-themed h-100 mb-0">
        <div class="block-header bg-pulse">
          <h3 class="block-title">
            Jenis Waroeng
        </div>
        <div class="block-content text-muted">
          @csrf
          <table id="m_w_jenis" class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th>ID</th>
                <th>NAMA JENIS WAROENG</th>
              </tr>
            </thead>
            <tbody id="tablecontents">
              @foreach ($data as $item)
              <tr class="row1">
                <td>{{$item->m_w_jenis_id}}</td>
                <td>{{$item->m_w_jenis_nama}}</td>
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
    var t = $('#m_w_jenis').DataTable({
      processing: false,
      serverSide: false,
      destroy: true,
      order: [0, 'asc'],
    });
    $('#m_w_jenis').Tabledit({
      url: '{{ route("action.m_w_jenis") }}',
      dataType: "json",
      columns: {
        identifier: [0, 'm_w_jenis_id'],
        editable: [
          [1, 'm_w_jenis_nama']
        ]
      },
      restoreButton: false,
      onSuccess: function(data, textStatus, jqXHR) {
        if (data.action == 'add') {
          window.location.reload();
        }
        if (data.action == 'delete') {
          $('#' + data.id).remove();
        }
      }
    });
    $("#m_w_jenis").append(
      $('<tfoot/>').append($("#m_w_jenis thead tr").clone())
    );
  });
</script>
@endsection