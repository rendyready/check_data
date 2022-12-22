@extends('layouts.app')
@section('content')
<!-- Page Content -->
<div class="content">
  <div class="row items-push">
    <div class="col-md-12 col-xl-12">
      <div class="block block-themed h-100 mb-0">
        <div class="block-header bg-pulse">
          <h3 class="block-title">
            KLASIFIKASI PRODUK
        </div>
        <div class="block-content text-muted">
          @csrf
          <table id="m_klasifikasi" class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th>No.</th>
                <th>NAMA KLASIFIKASI</th>
              </tr>
            </thead>
            <tbody id="tablecontents">
              @foreach ($data as $item)
              <tr>
                <td>{{$item->m_klasifikasi_produk_id}}</td>
                <td>{{$item->m_klasifikasi_produk_nama}}</td>
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
    var t = $('#m_klasifikasi').DataTable();
    $('#m_klasifikasi').Tabledit({
      url: '{{ route("action.m_klasifikasi") }}',
      dataType: "json",
      columns: {
        identifier: [0, 'id'],
        editable: [
          [1, 'm_klasifikasi_produk_nama']
        ]
      },
      restoreButton: false,
      onSuccess: function(data, textStatus, jqXHR) {
        Codebase.helpers('jq-notify', {
          align: 'right',
          from: 'top',
          type: 'danger',
          icon: 'fa fa-info me-5',
          message: data.Messages
        });
        setTimeout(function() {
          window.location.reload();
        }, 3000);
        if (data.action == 'add') {
          window.location.reload();
        }
        if (data.action == 'delete') {
          $('#' + data.id).remove();
        }
      }
    });
    $("#m_klasifikasi").append(
      $('<tfoot/>').append($("#m_klasifikasi thead tr").clone())
    );
  });
</script>
@endsection