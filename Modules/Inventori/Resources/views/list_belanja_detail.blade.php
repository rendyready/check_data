@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            KEBUTUHAN BELANJA DETAIL {{ tgl_indo($rph->rph_tgl) }}
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
                            @if ($rph->rph_order_status == 'buka')
                                <a class="btn btn-success mr-2 mb-2 order" title="order" style="color: #fff"><i
                                        class="fa fa-plus mr-5"></i> Kirim Order Ke Gudang</a>
                            @endif
                        </div>
                        <table id="detail_belanja"
                            class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bahan Baku</th>
                                    <th>Qty Kebutuhan</th>
                                    <th>Stok Sisa</th>
                                    <th>Satuan Produksi</th>
                                    <th>Order Gudang</th>
                                    <th>Satuan Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data2 as $item)
                                    <tr>
                                        <td>{{ $item['no'] }}</td>
                                        <td>{{ $item['nama'] }}</td>
                                        <td>{{ $item['qty_rph'] }}</td>
                                        <td>{{ $item['qty_produksi'] }}</td>
                                        <td>{{ $item['sat_produksi'] }}</td>
                                        <td>{{ $item['kebutuhan'] }}</td>
                                        <td>{{ $item['sat_belanja'] }}</td>
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
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });
      $('#detail_belanja').DataTable({
        destroy:'true',
        buttons: [
            {
                extend: 'excel',
                filename: 'kebutahan belanja {{$rph->rph_tgl}}',
                title: 'Kebutahan Belanja {{$rph->rph_tgl}}'
            },
            {
                extend: 'pdf',
                filename: 'kebutahan belanja {{$rph->rph_tgl}}',
                title: 'Kebutahan Belanja {{$rph->rph_tgl}}'
            },
            {
                extend: 'print',
            }
        ]
    });
  });
</script>
@endsection
