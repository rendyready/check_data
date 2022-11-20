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
            @csrf
                          <thead>
              <tr>
                  <th>No.</th>
                  <th>Nama Plot</th>                  
              </tr>
              </thead>             
              @foreach ($plot as $plots)
              @php ($no=0)
                  <tr>
                    <td>{{$no++}}</td>
                    <td>{{$plots->m_plot_produksi_name}}</td>                    
                  </tr>
                  {{$no}}  
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