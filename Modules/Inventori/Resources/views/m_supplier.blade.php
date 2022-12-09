@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Master Supplier
          </div>
          <div class="block-content text-muted">
                <div class="table-responsive">
                <table id="tb_supplier" class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <th>No</th>
                        <th>Code</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kota</th>
                        <th>Telp</th>
                        <th>Keterangan</th>
                        <th>Saldo</th>
                        <th>Rekening</th>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    <tfoot>
                      <th>No</th>
                      <th>Code</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Kota</th>
                      <th>Telp</th>
                      <th>Keterangan</th>
                      <th>Saldo</th>
                      <th>Rekening</th>
                    </tfoot>
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
    Codebase.helpersOnLoad(['jq-select2']);
    var table, save_method;
        $(function() {
            table = $('.table').DataTable({
        "destroy":true,
        "orderCellsTop": true,
        "processing": true,
        "autoWidth": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 25,
        "ajax": {
            "url": "{{ route('supplier.data') }}",
            "type": "GET"
                }
            });
        });
});
</script>
@endsection