@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Data Plot
            </h3>
          </div>
          <div class="block-content text-muted">
            <table id="tab" class="table table-bordered table-striped table-vcenter js-dataTable-full"">
              <thead>
              <tr>
                  <th>No.</th>
                  <th>Nama Meja</th>
                  <th>Jenis Meja</th>
                  <th>Waroeng</th>
                  <th>Action</th>
              </tr>
              </thead>
                  <tr>
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                    <td>B</td>
                    <td>B</td>
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