@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            @if ($data->aksi == 'detail')
                                HISTORY INPUT SO
                            @else
                                FORM INPUT STOK OPNAME
                            @endif
                    </div>
                    <div class="block-content text-muted">
                        <form id="myform">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label" for="rekap_beli_created_by">Operator</label>
                                        @if ($data->aksi == 'detail')
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="rekap_beli_created_by"
                                                    name="rekap_beli_created_by" value="{{ ucwords($data->operator) }}"
                                                    readonly>
                                            </div>
                                        @else
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="rekap_beli_created_by"
                                                    name="rekap_beli_created_by" value="{{ Auth::user()->name }}" readonly>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label" for="example-hf-text">Waroeng</label>
                                        <div class="col-sm-9">
                                            @if ($data->aksi == 'detail')
                                                <input type="text" class="form-control nota" id="rekap_so_m_w_nama"
                                                    name="rekap_so_m_w_nama"
                                                    value="{{ ucwords($data->so->rekap_so_m_w_nama) }}" readonly>
                                            @else
                                                <input type="hidden" class="nota" name="rekap_so_code"
                                                    value="{{ $data->so_code }}">
                                                <input type="text" class="form-control nota" id="rekap_so_m_w_nama"
                                                    name="rekap_so_m_w_nama" value="{{ ucwords($data->waroeng->m_w_nama) }}"
                                                    readonly>
                                                <input type="hidden" name="rekap_so_m_w_code"
                                                    value="{{ $data->waroeng->m_w_code }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if ($data->aksi == 'detail')
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="rekap_so_tgl">Tanggal</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="rekap_so_tgl"
                                                    name="rekap_so_tgl" value="{{ $data->so->rekap_so_tgl }}"
                                                    readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="example-hf-text">Gudang</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control nota" id="gudang_nama"
                                                    name="gudang_nama" value="{{ ucwords($data->gudang_nama) }}" readonly>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="rekap_so_tgl">Tanggal</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="rekap_so_tgl"
                                                    name="rekap_so_tgl" value="{{ $data->tgl_now }}" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label" for="example-hf-text">Gudang</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control nota" id="gudang_nama"
                                                    name="gudang_nama" value="{{ ucwords($data->gudang_nama) }}" readonly>
                                                <input type="hidden" name="rekap_so_m_gudang_code"
                                                    value="{{ $data->gudang_code }}">
                                                <input type="hidden" name="rekap_so_m_klasifikasi_produk_id"
                                                    value="{{ $data->kat_id }}">
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="tb-so" class="table table-sm table-bordered table-striped table-vcenter">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Qty Stok</th>
                                        <th>SO Rill</th>
                                        <th>HPP</th>
                                        <th>Satuan</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @if ($data->aksi == 'detail')
                                            @foreach ($data->so_detail as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ ucwords($item->rekap_so_detail_m_produk_nama) }}</td>
                                                    <td>{{ num_format($item->rekap_so_detail_qty) }} </td>
                                                    <td>{{ num_format($item->rekap_so_detail_qty_riil) }}</td>
                                                    <td>{{num_format($item->rekap_so_detail_hpp)}}</td>
                                                    <td>{{ ucwords($item->rekap_so_detail_satuan) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach ($data->stok as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ ucwords($item->m_stok_produk_nama) }}<input type="hidden"
                                                            name="rekap_so_detail_m_produk_code[]"
                                                            value="{{ $item->m_stok_m_produk_code }}"></td>
                                                    <td>{{ num_format($item->m_stok_saldo) }} <input type="hidden"
                                                            name="rekap_so_detail_qty[]" class="qty number"
                                                            value="{{ $item->m_stok_saldo }}"></td>
                                                    <td>
                                                        <input type="text" class="form-control number rill"
                                                            name="rekap_so_detail_qty_riil[]">
                                                    </td>
                                                    <td>{{ ucwords($item->m_stok_satuan) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </form>
                        @if ($data->aksi != 'detail')
                            <a id="simpan" class="btn btn-sm simpan btn-success">Simpan</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script>
        $(function() {
            $(document).on('click', '#simpan', function(e) {
                e.preventDefault();

                var inputData = {
                    rekap_beli_created_by: $('#rekap_beli_created_by').val(),
                    rekap_so_code: $('.nota[name="rekap_so_code"]').val(),
                    rekap_so_m_w_nama: $('#rekap_so_m_w_nama').val(),
                    rekap_so_m_w_code: $('input[name="rekap_so_m_w_code"]').val(),
                    rekap_so_tgl: $('#rekap_so_tgl').val(),
                    gudang_nama: $('#gudang_nama').val(),
                    rekap_so_m_gudang_code: $('input[name="rekap_so_m_gudang_code"]').val(),
                    rekap_so_m_klasifikasi_produk_id: $(
                        'input[name="rekap_so_m_klasifikasi_produk_id"]').val(),
                    rekap_so_detail: []
                };

                $('#tb-so tbody tr').each(function(index, element) {
                    var rekap_so_detail_qty_riil = $(element).find('.rill').val();
                    if (rekap_so_detail_qty_riil !== null && rekap_so_detail_qty_riil.trim() !==
                        '') {
                        var row = {
                            rekap_so_detail_m_produk_code: $(element).find(
                                'input[name="rekap_so_detail_m_produk_code[]"]').val(),
                            rekap_so_detail_qty: $(element).find(
                                'input[name="rekap_so_detail_qty[]"]').val(),
                            rekap_so_detail_qty_riil: rekap_so_detail_qty_riil
                        };
                        inputData.rekap_so_detail.push(row);
                    }
                });

                if (inputData.rekap_so_detail.length === 0) {
                    alert('At least one qty_riil must be provided.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('stok_so.simpan') }}',
                    data: JSON.stringify(inputData),
                    contentType: 'application/json',
                    success: function(data) {
                        Codebase.helpers('jq-notify', {
                            align: 'right', // 'right', 'left', 'center'
                            from: 'top', // 'top', 'bottom'
                            type: 'success', // 'info', 'success', 'warning', 'danger'
                            icon: 'fa fa-info me-5', // Icon class
                            message: 'Input SO Berhasil Anda Akan Dialihkan Ke Halaman Utama'
                        });
                        setTimeout(function() {
                            window.location.href = "{{ route('stok_so.index') }}";
                        }, 500);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Tindakan saat terjadi kesalahan
                    }
                });
            });


        })
        $(document).ready(function() {
            Codebase.helpersOnLoad(['jq-select2']);
            var table = $('#tb-so').DataTable({
                destroy: true,
                paging: false,
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });
        });
    </script>
@endsection
