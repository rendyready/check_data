@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Data Satuan
            </h3>
          </div>
          <div class="block-content text-muted">
            @csrf
            <table id="sample_data" class="table table-bordered table-striped table-vcenter">
              <thead>
              <tr>
                  <th>Nama Satuan</th>
                  <th>Keterangan</th>
              </tr>
              <tr>
              <th> Kilogram </th>
              <th> 1 pack isinya 3 kg</th>
              </tr>
              <tr>
                <th>Liter </th>
                <th> 1 botol isinya 10 liter</th>
                </tr>
                <tr>
                  <th> Biji/Pcs </th>
                  <th> 1 pack isinya 2 pcs</th>
                  </tr>

              </thead>
              <tbody>
                {{-- @foreach ($data as $item)
                    <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->m_area_nama}}</td>
                    </tr>
                @endforeach --}}
              </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Page Content -->
@endsection