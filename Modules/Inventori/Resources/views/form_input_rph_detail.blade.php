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
                        <form id="form">
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
                                            <input type="text" class="form-control" id="rph_m_w_nama" name="rph_m_w_nama"
                                                value="{{ ucwords($data->waroeng_nama->m_w_nama) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label" for="rph_tgl">Tanggal Now</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" id="tgl_now" name="tgl_now"
                                                value="{{ date('Y-m-d') }}" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label" for="rph_tgl">Tanggal</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="js-flatpickr form-control js-flatpickr-enabled flatpickr-input active"
                                                id="example-flatpickr-default" name="example-flatpickr-default"
                                                placeholder="Y-m-d" readonly="readonly">
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
                                                            <th>Qty</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data->produk as $j)
                                                            @if ($i->m_jenis_produk_id == $j->m_produk_m_jenis_produk_id)
                                                                <tr>
                                                                    <td>{{ $data->num++ }}</td>
                                                                    <td><input
                                                                            style="background-color: transparent; border: none;"
                                                                            class="form-control" type="text"
                                                                            name="rph_detail_menu_m_produk_code[]"
                                                                            id="rph_detail_menu_m_produk_code{{ $j->m_produk_code }}"
                                                                            value="{{ $j->m_produk_code }}" readonly></td>
                                                                    <td>{{ ucwords($j->m_produk_nama) }}</td>
                                                                    <td><input type="text" class="number form-control"
                                                                            name="qty[]"></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button type="submit" class="btn btn-primary jbuton">Save</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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

            var table = [];
            $('ul.nav-tabs').children().first().children().addClass('active');
            $('div.tab-pane').first().addClass('active');
            @foreach ($data->jenis as $k)
                table['{{ $data->s }}'] = $('#table{{ $data->s++ }}').dataTable();
            @endforeach
            $('#form').on('submit', function(e) {
                var tData = [];
                var tRes = [];
                var n = 1;
                e.preventDefault();
                $.each($('.table'), function(i, v) {
                    tData.push(table[i + 1].$('input').serialize());
                }).promise().done(function() {
                    tRes = JSON.stringify(tRes);
                    console.log(tRes);
                    $.ajax({
                        type: "post",
                        url: "{{route('rph.simpan')}}",
                        data: {
                            tData,
                            _token: "{{ csrf_token() }}"
                        }
                    }).done(function(data) {
                        console.log(data);
                    }).fail(function(data) {
                        console.log(data);
                    });
                });
                return false;
            });
        })
        $(document).ready(function() {
            Codebase.helpersOnLoad(['jq-select2']);
            $('.js-flatpickr').flatpickr({
                minDate: "today", // set minimum date to today
                defaultDate: "nextDay", // set default date to next day
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });
        });
    </script>
@endsection
