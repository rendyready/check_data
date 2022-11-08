@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Data Area
            </h3>
          </div>
          <div class="block-content text-muted">
            <table id="tab" class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
              <thead>
              <tr>
                  <th>No.</th>
                  <th>Nama Area</th>
                  <th>Action</th>
              </tr>
              </thead>
              <tbody>
                  <tr>
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                  </tr>
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
<script>
  
</script>
@endsection