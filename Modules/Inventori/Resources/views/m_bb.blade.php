@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Master Bahan Baku
                    </div>
                    <div class="block-content text-muted">
                        <a class="btn btn-success buttonInsert"><i class="fa fa-plus"></i>Bahan Baku</a>
                        @csrf
                        <table id="m_w_jenis"
                            class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Bahan Baku</th>
                                    <th>Nama BB</th>
                                    <th>Satuan Utama</th>
                                    <th>Satuan Produksi</th>
                                    <th>Klasifikasi</th>
                                    <th>Status BB</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data->produk as $item)
                                    <tr class="row1">
                                        <td>{{ $no++ }}</td>
                                        <td>{{ strtoupper($item->m_produk_code) }}</td>
                                        <td>{{ $item->m_produk_nama }}</td>
                                        <td>{{ $item->satuan_utama }}</td>
                                        <td>{{ $item->satuan_produksi }}</td>
                                        <td>{{ strtoupper($item->m_klasifikasi_produk_nama) }}</td>
                                        <td>
                                            @if ($item->m_produk_status == 1)
                                                <span class="badge rounded-pill bg-success">Aktif</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Non Aktif</span>
                                            @endif
                                        </td>
                                        <td><a class="btn btn-sm btn-warning buttonEdit" value="{{ $item->m_produk_id }}"
                                                title="Edit"><i class="fa fa-pencil"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Select2 in a modal -->
        <div class="modal" id="form_produk" tabindex="-1" role="dialog" aria-labelledby="form_produk" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed shadow-none mb-0">
                        <div class="block-header block-header-default bg-pulse">
                            <h3 class="block-title" id="myModalLabel"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm">
                            <!-- Select2 is initialized at the bottom of the page -->
                            <form id="formAction" method="post">
                                <div class="mb-4">
                                    <input type="hidden" id="action" name="action">
                                    <input type="hidden" id="m_produk_id" name="m_produk_id">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="m_produk_nama">BB Nama</label>
                                    <input type="text" class="form-control" id="m_produk_nama" name="m_produk_nama"
                                        placeholder="Masukan Nama">
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_produk_utama_m_satuan_id">BB Satuan Utama</label>
                                        <div>
                                            <select class="js-select2" id="m_produk_utama_m_satuan_id"
                                                name="m_produk_utama_m_satuan_id" style="width: 100%;"
                                                data-container="#form_produk" data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($data->satuan as $item)
                                                    <option value="{{ $item->m_satuan_id }}">{{ $item->m_satuan_kode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_produk_isi_m_satuan_id">BB Satuan Produksi</label>
                                        <div>
                                            <select class="js-select2" id="m_produk_isi_m_satuan_id"
                                                name="m_produk_isi_m_satuan_id" style="width: 100%;"
                                                data-container="#form_produk" data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($data->satuan as $item)
                                                    <option value="{{ $item->m_satuan_id }}">{{ $item->m_satuan_kode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_produk_m_klasifikasi_produk_id">Klasifikasi Produk</label>
                                        <div>
                                            <select class="js-select2" id="m_produk_m_klasifikasi_produk_id"
                                                name="m_produk_m_klasifikasi_produk_id" style="width: 100%;">
                                                @foreach ($data->klasifikasi as $item)
                                                    <option value="{{ $item->m_klasifikasi_produk_id }}">
                                                        {{ strtoupper($item->m_klasifikasi_produk_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_produk_hpp">Jenis HPP Produk</label>
                                        <div>
                                            <select class="js-select2" id="m_produk_hpp" name="m_produk_hpp"
                                                style="width: 100%;" data-container="#form_produk"
                                                data-placeholder="Choose one..">
                                                <option></option>
                                                <option value="scp">SCP</option>
                                                <option value="sales">SALES</option>
                                                <option value="overhead">OVERHEAD</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_produk_status">Produk SCP</label>
                                        <div>
                                            <select class="js-select2" id="m_produk_scp" name="m_produk_scp"
                                                style="width: 100%;">
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_produk_status">Produk Status</label>
                                        <div>
                                            <select class="js-select2" id="m_produk_status" name="m_produk_status"
                                                style="width: 100%;">
                                                <option value="1">Aktif</option>
                                                <option value="0">Non Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_produk_jual">Dijual Di CR</label>
                                        <div>
                                            <select class="js-select2" id="m_produk_jual" name="m_produk_jual"
                                                style="width: 100%;">
                                                <option value="tidak">Tidak</option>
                                                <option value="ya">Ya</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content block-content-full text-end bg-body">
                                    <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Select2 in a modal -->
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script type="module">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });
            var t = $('#m_w_jenis').DataTable({
                processing: false,
                serverSide: false,
                destroy: true,
                pageLength: 25,
                order: [0, 'asc'],
            });
            $('.js-select2').select2({
                dropdownParent: $('#formAction')
            })
            $(".buttonInsert").on('click', function() {
                var id = $(this).attr('value');
                $('[name="action"]').val('add');
                $('#form_produk form')[0].reset();
                $("#myModalLabel").html('Tambah Bahan Baku');
                $("#form_produk").modal('show');
            });
            $(document).on('click', '.buttonEdit', function() {
                var id = $(this).attr('value');
                $("#myModalLabel").html('Ubah Produk');
                $('[name="action"]').val('edit');
                $.ajax({
                    url: "/master/produk/list/" + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                        console.log(respond);
                        $("#m_produk_id").val(respond.data_produk.m_produk_id).trigger(
                            'change');
                        $("#m_produk_cr").val(respond.data_produk.m_produk_cr).trigger(
                            'change');
                        $("#m_produk_code").val(respond.data_produk.m_produk_code).trigger(
                            'change');
                        $("#m_produk_hpp").val(respond.data_produk.m_produk_hpp).trigger(
                            'change');
                        $("#m_produk_jual").val(respond.data_produk.m_produk_jual).trigger(
                            'change');
                        $("#m_produk_qr").val(respond.data_produk.m_produk_qr).trigger(
                            'change');
                        $("#m_produk_m_jenis_produk_id").val(respond.data_produk
                            .m_produk_m_jenis_produk_id).trigger('change');
                        $("#m_produk_m_klasifikasi_produk_id").val(respond.data_produk
                            .m_produk_m_klasifikasi_produk_id).trigger('change');
                        $("#m_produk_m_plot_produksi_id").val(respond.data_produk
                            .m_produk_m_plot_produksi_id).trigger('change');
                        $("#m_produk_utama_m_satuan_id").val(respond.data_produk
                            .m_produk_utama_m_satuan_id).trigger('change');
                        $("#m_produk_isi_m_satuan_id").val(respond.data_produk
                            .m_produk_isi_m_satuan_id).trigger('change');
                        $("#m_produk_nama").val(respond.data_produk.m_produk_nama).trigger(
                            'change');
                        $("#m_produk_sc").val(respond.data_produk.m_produk_sc).trigger(
                            'change');
                        $("#m_produk_scp").val(respond.data_produk.m_produk_scp).trigger(
                            'change');
                        $("#m_produk_status").val(respond.data_produk.m_produk_status).trigger(
                            'change');
                        $("#m_produk_tax").val(respond.data_produk.m_produk_tax).trigger(
                            'change');
                        $("#m_produk_urut").val(respond.data_produk.m_produk_urut).trigger(
                            'change');
                        $("#config_sub_jenis_produk_m_sub_jenis_produk_id").val(respond
                            .data_sub_jenis_produk).trigger('change');
                    },
                });
                $("#form_produk").modal('show');
            });
            $('#formAction').submit(function(e) {
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: "{{ route('simpan.m_bb') }}",
                        type: "POST",
                        data: $('#form_produk form').serialize(),
                        success: function(data) {
                            $('#form_produk').modal('hide');
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: data
                                .type, // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: data.messages
                            });
                            setTimeout(function() {
                                window.location.reload();
                            }, 800);
                        },
                        error: function() {
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                    return false;
                }
            });
            $("#m_w_jenis").append(
                $('<tfoot/>').append($("#m_w_jenis thead tr").clone())
            );
        });
    </script>
@endsection
