@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            FORM INPUT STOK OPNAME
                    </div>
                    <div class="block-content text-muted">
                        <form id="myform">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label" for="rekap_beli_created_by">Operator</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="rekap_beli_created_by"
                                                name="rekap_beli_created_by" value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label" for="example-hf-text">Waroeng</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" class="nota" name="rekap_so_code"
                                                value="{{ $data->so_code }}">
                                            <input type="text" class="form-control nota" id="rph_m_w_nama"
                                                name="rph_m_w_nama" value="{{ ucwords($data->waroeng_nama->m_w_nama) }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label" for="tgl_now">Tanggal</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="tgl_now" name="tgl_now"
                                                value="{{ $data->tgl_now }}" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label" for="example-hf-text">Gudang</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control nota" id="gudang_nama"
                                                name="gudang_nama" value="{{ ucwords($data->gudang_nama) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="tb-so" class="table table-sm table-bordered table-striped table-vcenter">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Qty Stok</th>
                                        <th>Satuan</th>
                                        <th>SO Rill</th>
                                        <th>Selisih</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($data->stok as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ ucwords($item->m_stok_produk_nama) }}<input type="hidden"
                                                        name="rekap_so_detail_m_produk_code[]"
                                                        value="{{ $item->m_stok_m_produk_code }}"></td>
                                                <td>{{ num_format($item->m_stok_saldo) }} <input type="hidden"
                                                        name="rekap_so_detail_qty[]" class="qty number"
                                                        value="{{ $item->m_stok_saldo }}"></td>
                                                <td>{{ ucwords($item->m_stok_satuan) }} <input type="hidden"
                                                        name="rekap_so_detail_satuan[]" value="{{ $item->m_stok_satuan }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control number rill"
                                                        name="rekap_so_detail_qty_riil[]" id="rekap_so_detail_qty_riil">
                                                </td>
                                                <td><input id="selisih{{ $no }}"
                                                        style="background-color: transparent; border: none;" type="text"
                                                        class="form-control number" name="selisih[]" readonly></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <a id="simpan" class="btn btn-sm btn-success">Simpan</a>
                        </form>
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
            $('#simpan').click(function(e) {
                var tgl = $('#rph_tgl').val();
                if (tgl == '') {
                    Codebase.helpers('jq-notify', {
                        align: 'right', // 'right', 'left', 'center'
                        from: 'top', // 'top', 'bottom'
                        type: 'danger', // 'info', 'success', 'warning', 'danger'
                        icon: 'fa fa-info me-5', // Icon class
                        message: 'Tanggal RPH Belum Terisi'
                    });
                    e.preventDefault();
                } else {
                    // Mendapatkan semua data dalam sebuah DataTable
                    var table = $('#tb-so').DataTable();
                    var data = table.rows().data();
                    // Membuat objek FormData dari seluruh data dalam DataTable dan form
                    var formData = new FormData($('#myform')[0]);
                    console.log(formData);
                    data.each(function(rowData) {
                        $.each(rowData, function(key, value) {
                            formData.append(key, value);
                        });
                    });
                    // Mengirim data ke server melalui AJAX
                    // $.ajax({
                    //     type: "post",
                    //     url: "{{ route('stok_so.simpan') }}",
                    //     data: formData,
                    //     processData: false,
                    //     contentType: false,
                    //     success: function(data) {
                    //         Codebase.helpers('jq-notify', {
                    //             align: 'right', // 'right', 'left', 'center'
                    //             from: 'top', // 'top', 'bottom'
                    //             type: data
                    //             .type, // 'info', 'success', 'warning', 'danger'
                    //             icon: 'fa fa-info me-5', // Icon class
                    //             message: data.messages
                    //         });
                    //         setTimeout(function() {
                    //             window.location.href = "{{ route('rph.index') }}";
                    //         }, 2000);
                    //     }
                    // });

                }
            });
        })
        $(document).ready(function() {
            Codebase.helpersOnLoad(['jq-select2']);
            var table = $('#tb-so').DataTable({
                destroy: true,
                pageLength: 10,
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });
            $('#tb-so').on('input', '.qty, .rill', function() {
                table.rows().every(function() {
                    var row = this.node();
                    var qty = parseFloat(table.cell(row, 2).nodes().to$().find('input').val());
                    var rill = parseFloat(table.cell(row, 4).nodes().to$().find('input').val()
                        .replace(/\./g, '').replace(/\,/g, '.'));
                    var selisih = qty - rill;
                    if (!isNaN(selisih)) {
                        table.cell(row, 5).nodes().to$().find('input').val(selisih.toLocaleString(
                            "id"));
                    }
                });
            });
        });
    </script>
@endsection
