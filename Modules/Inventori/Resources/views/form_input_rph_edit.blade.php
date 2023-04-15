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
                        <div id="form">
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
                                            <input type="hidden" class="nota" name="rph_code"
                                                value="{{ $data->rph_code }}">
                                            <input type="text" class="form-control nota" id="rph_m_w_nama"
                                                name="rph_m_w_nama" value="{{ ucwords($data->waroeng_nama->m_w_nama) }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label" for="rph_tgl">Tanggal</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="form-control nota js-flatpickr-enabled flatpickr-input active"
                                                id="rph_tgl" name="rph_tgl" value="{{ $data->rph_tgl }}"
                                                readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tabpane" class="block block-rounded overflow-hidden">
                                <ul class="nav nav-tabs nav-tabs-block nav-tabs-alt align-items-center" role="tablist">
                                    @foreach ($data->jenis as $i)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="#{{ $i->m_jenis_produk_nama }}"
                                                data-bs-toggle="tab" data-bs-target="#{{ $i->m_jenis_produk_nama }}"
                                                role="tab" aria-controls="{{ $i->m_jenis_produk_nama }}"
                                                aria-selected="false">{{ ucwords($i->m_jenis_produk_nama) }}</button>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="block-content tab-content">
                                    @foreach ($data->jenis as $i)
                                        <div class="tab-pane p-20" id="{{ $i->m_jenis_produk_nama }}" role="tabpanel">
                                            <div class="table-responsive">
                                                <table id="table{{ $data->n++ }}"
                                                    class="table table-bordered table-striped table-vcenter js-dataTable-full jarak">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Kode</th>
                                                            <th>Nama Menu</th>
                                                            <th>Qty RPH</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($data->aksi == 'detail')
                                                            @foreach ($data->produk as $j)
                                                                @if ($i->m_jenis_produk_id == $j->m_produk_m_jenis_produk_id)
                                                                    <tr>
                                                                        <td>{{ $data->num++ }}</td>
                                                                        <td>
                                                                            <input
                                                                                style="background-color: transparent; border: none;"
                                                                                class="form-control" type="text"
                                                                                name="rph_detail_menu_m_produk_code[]"
                                                                                id="rph_detail_menu_m_produk_code{{ $j->m_produk_code }}"
                                                                                value="{{ $j->m_produk_code }}" readonly>
                                                                        </td>
                                                                        <td>{{ $j->m_produk_nama }}</td>
                                                                        <td>
                                                                            @php $found = false; @endphp
                                                                            @foreach ($data->rph_edit as $item)
                                                                                @if ($j->m_produk_code == $item->rph_detail_menu_m_produk_code)
                                                                                    {{ $item->rph_detail_menu_qty }}
                                                                                    @php $found = true; @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            @if (!$found)
                                                                               
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @foreach ($data->produk as $j)
                                                                @if ($i->m_jenis_produk_id == $j->m_produk_m_jenis_produk_id)
                                                                    <tr>
                                                                        <td>{{ $data->num++ }}</td>
                                                                        <td>
                                                                            @php $found = false; @endphp
                                                                            @foreach ($data->rph_edit as $item)
                                                                                @if ($j->m_produk_code == $item->rph_detail_menu_m_produk_code)
                                                                                <input type="hidden" name="rph_detail_menu_id[]" value="{{$item->rph_detail_menu_id}}">
                                                                                    @php $found = true; @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            @if (!$found)
                                                                            <input type="hidden" name="rph_detail_menu_id[]">
                                                                            @endif
                                                                            <input
                                                                                style="background-color: transparent; border: none;"
                                                                                class="form-control" type="text"
                                                                                name="rph_detail_menu_m_produk_code[]"
                                                                                id="rph_detail_menu_m_produk_code{{ $j->m_produk_code }}"
                                                                                value="{{ $j->m_produk_code }}" readonly>
                                                                        </td>
                                                                        <td>{{ $j->m_produk_nama }}</td>
                                                                        <td>
                                                                            @php $found = false; @endphp
                                                                            @foreach ($data->rph_edit as $item)
                                                                                @if ($j->m_produk_code == $item->rph_detail_menu_m_produk_code)
                                                                                    <input type="text"
                                                                                        class="number form-control"
                                                                                        name="rph_detail_menu_qty[]"
                                                                                        value="{{ $item->rph_detail_menu_qty }}">
                                                                                    @php $found = true; @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            @if (!$found)
                                                                                <input type="text"
                                                                                    class="number form-control"
                                                                                    name="rph_detail_menu_qty[]"
                                                                                    value="">
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if ($data->aksi == 'detail')
                        <a id="back" href="{{route('rph.index')}}" class="btn btn-sm btn-success">Kembali Ke RPH</a>
                        @else
                        <button id="simpan" type="submit" class="btn btn-sm btn-success">Simpan</button> 
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
            var table = [];
            $('ul.nav-tabs').children().first().children().addClass('active');
            $('div.tab-pane').first().addClass('active');
            @foreach ($data->jenis as $k)
                table['{{ $data->s }}'] = $('#table{{ $data->s++ }}').dataTable({
                    destroy: true,
                    paging: false
                });
            @endforeach
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
                    $.ajax({
                        type: "put",
                        url: "{{ route('rph.update') }}",
                        data: $('input').serialize(),
                        success: function(data) {
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: 'success', // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: 'Berhasil Update RPH'
                            });
                            setTimeout(function() {
                                window.location.href = "{{route('rph.index')}}";
                            }, 2000);
                        }
                    });
                }
            });
        })
        $(document).ready(function() {
            $('.js-flatpickr').flatpickr({
                minDate: new Date().fp_incr(1) // This sets the minimum date to tomorrow
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });
        });
    </script>
@endsection
