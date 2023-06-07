@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            FORM INPUT RPH
                    </div>
                    <div class="block-content text-muted">
                        <div class="col-md-4">
                            <div class="row mb-1">
                                <label class="col-sm-3 col-form-label-sm" for="rekap_beli_created_by">Operator</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="rekap_beli_created_by"
                                        name="rekap_beli_created_by" value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-sm-3 col-form-label-sm" for="example-hf-text">Waroeng</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="rph_code">
                                    <input type="text" class="form-control form-control-sm" id="rekap_beli_waroeng"
                                        name="rekap_beli_waroeng" value="{{ ucwords($data->waroeng_nama->m_w_nama) }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                        <a class="btn btn-success" href="{{ route('rph.create') }}"><i class="fa fa-plus"></i>Tambah RPH</a>
                        <table class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal RPH</th>
                                    <th>Operator</th>
                                    <th>Tanggal Input</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php
                                  $no = 1;
                              @endphp
                              @foreach ($rph as $item)
                                  <tr>
                                      <td>{{ $no }}</td>
                                      <td>{{ tgl_indo($item->rph_tgl) }}</td>
                                      <td>{{ $item->name }}</td>
                                      <td>{{ tgl_indo($item->rph_created_at) }}</td>
                                      <td>
                                        @if ($item->rph_order_status == 'buka')
                                        <a href="{{ route('rph.edit', $item->rph_code) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                                        @else
                                        <a href="{{ route('rph.detail', $item->rph_code) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                        @endif
                                      </td>
                                  </tr>
                                  @php
                                      $no++;
                                  @endphp
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
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });
  });
</script>
@endsection
