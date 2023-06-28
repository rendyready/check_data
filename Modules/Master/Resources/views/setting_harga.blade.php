@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Setting Harga Nota
                    </div>
                    <div class="block-content text-muted">

                        <a class="btn btn-info mr-5 mb-5 buttonCopy" value="" title="copy" style="color: #fff"><i
                                class="fa fa-copy mr-5"></i> Copy Nota</a>
                        <a class="btn btn-warning mr-5 mb-5 buttonUpdate" value="" title="update"
                            style="color: #fff"><i class="fa fa-refresh mr-5"></i> Update Harga/Status</a>
                        <a class="btn btn-success mr-5 mb-5 buttonMenu" value="" title="Edit" style="color: #fff"><i
                                class="fa fa-plus mr-5"></i> Status Menu</a>
                        @csrf
                        <table id="my_table" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Waroeng</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Tipe Nota</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->m_w_nama }}</td>
                                        <td>{{ $item->m_t_t_name }}</td>
                                        <td>{{ ucwords($item->m_w_m_kode_nota) }}</td>
                                        <td> 
                                            {{-- <a class="btn btn-info buttonEdit" value="{{ $item->m_jenis_nota_id }}"
                                                title="Edit"><i class="fa fa-edit"></i></a> --}}
                                            <a href="{{ route('m_jenis_nota.detail_harga', $item->m_jenis_nota_id) }}"
                                                class="btn btn-warning" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            {{-- <a href="{{route('m_jenis_nota.hapus',$item->m_jenis_nota_id)}}" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Select2 in a modal -->
        <div class="modal" id="modal-block-select2" tabindex="-1" role="dialog" aria-labelledby="modal-block-select2"
            aria-hidden="true">
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
                        <div class="block-content">
                            <!-- Select2 is initialized at the bottom of the page -->
                            <form id="formAction">
                                @csrf
                                <input type="hidden" id="action1" value="status_menu" name="action">
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_area_id2">Area</label>
                                        <div>
                                            <select class="js-select2 get_nota" id="m_area_id2" name="m_area_id"
                                                style="width: 100%;" data-placeholder="Choose one..">
                                                <option></option>
                                                <option value="0">All Area</option>
                                                @foreach ($area as $val)
                                                    <option value="{{ $val->m_area_id }}">
                                                        {{ ucwords($val->m_area_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="jenis_nota">Jenis Transaksi</label>
                                        <div>
                                            <select class="js-select2 get_nota" id="jenis_nota" name="update_m_jenis_nota_trans_id[]"
                                                style="width: 100%;" data-placeholder="Pilih Jenis Transaksi" multiple>
                                                <option></option>
                                                @foreach ($listTipeTransaksi as $tipe)
                                                    <option value="{{ $tipe->m_t_t_id }}">
                                                        {{ ucwords($tipe->m_t_t_name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_tipe_nota">Tipe Nota</label>
                                        <div>
                                            <select class="js-select2" id="m_tipe_nota_id" name="nota_kode[]"
                                                style="width: 100%;" data-placeholder="Pilih Tipe Nota" multiple>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_produk_id">Nama Menu</label>
                                        <div>
                                            <select class="js-select2" id="menu_id" name="m_produk_id"
                                                style="width: 100%;" data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($produk as $val)
                                                    <option value="{{ $val->m_produk_id }}">
                                                        {{ ucwords($val->m_produk_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_menu_harga_status">Status Harga</label>
                                        <div>
                                            <select class="js-select2" id="m_menu_harga_status" name="m_menu_harga_status"
                                                style="width: 100%;">
                                                <option value="1">Aktif</option>
                                                <option value="0">Non Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_menu_harga_tax_status">Status Pajak</label>
                                        <div>
                                            <select class="js-select2" id="m_menu_harga_tax_status"
                                                name="m_menu_harga_tax_status" style="width: 100%;">
                                                <option value="1">Aktif</option>
                                                <option value="0">Non Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_menu_harga_sc_status">Status Service Charge</label>
                                        <div>
                                            <select class="js-select2" id="m_menu_harga_sc_status"
                                                name="m_menu_harga_sc_status" style="width: 100%;">
                                                <option value="0">Non Aktif</option>
                                                <option value="1">Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content block-content-full text-end bg-transparent">
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
        <!-- END Select2 in a modal tambah nota-->
        <!-- Select2 in a modal copy nota -->
        <div class="modal" id="copy_nota" tabindex="-1" role="dialog" aria-labelledby="copy_nota"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed shadow-none mb-0">
                        <div class="block-header block-header-default bg-pulse">
                            <h3 class="block-title" id="myModalLabel2"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <!-- Select2 is initialized at the bottom of the page -->
                            <form method="post" action="" id="formAction2">
                                @csrf
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_jenis_nota_trans_id_asal">Sumber Jenis Transaksi</label>
                                        <div>
                                            <select class="js-select2-copy" id="m_jenis_nota_trans_id_asal"
                                                name="m_jenis_nota_trans_id_asal" style="width: 100%;"
                                                data-container="#copy_nota" data-placeholder="Choose one..">
                                                <option></option>

                                                @foreach ($listTipeTransaksi as $tipe)
                                                    <option value="{{ $tipe->m_t_t_id }}">
                                                        {{ ucwords($tipe->m_t_t_name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_jenis_nota_waroeng_sumber_id">Sumber Nota Waroeng</label>
                                        <div>
                                            <select class="js-select2-copy" id="m_jenis_nota_waroeng_sumber_id"
                                                name="m_jenis_nota_waroeng_sumber_id" style="width: 100%;"
                                                data-container="#copy_nota" data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($listWaroeng as $wr)
                                                    <option value="{{ $wr->m_w_id }}">{{ ucwords($wr->m_w_nama) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_jenis_nota_trans_id_tujuan">Tujuan Jenis Transaksi</label>
                                        <div>
                                            <select class="js-select2-copy" id="m_jenis_nota_trans_id_tujuan"
                                                name="m_jenis_nota_trans_id_tujuan" style="width: 100%;"
                                                data-container="#copy_nota" data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($listTipeTransaksi as $tipe)
                                                    <option value="{{ $tipe->m_t_t_id }}">
                                                        {{ ucwords($tipe->m_t_t_name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_jenis_nota_waroeng_tujuan_id">Tujuan Nota Waroeng</label>
                                        <div>
                                            <select class="js-select2-copy" id="m_jenis_nota_waroeng_tujuan_id"
                                                name="m_jenis_nota_waroeng_tujuan_id" style="width: 100%;"
                                                data-container="#copy_nota" data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($listWaroeng as $wr)
                                                    <option value="{{ $wr->m_w_id }}">{{ ucwords($wr->m_w_nama) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content block-content-full text-end bg-transparent">
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
        <!-- END Select2 in a modal copy nota-->
        <!-- Select2 in a modal update harga -->
        <div class="modal" id="update_harga" tabindex="-1" role="dialog" aria-labelledby="update_harga"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed shadow-none mb-0">
                        <div class="block-header block-header-default bg-pulse">
                            <h3 class="block-title" id="myModalLabel3"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <!-- Select2 is initialized at the bottom of the page -->
                            <form id="formAction3">
                                @csrf
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_area_id">Area</label>
                                        <div>
                                            <select class="js-select2 get_harga get_nota" id="m_area_id" name="m_area_id"
                                                style="width: 100%;" data-placeholder="Choose one..">
                                                <option></option>
                                                <option value="0">All Area</option>
                                                @foreach ($area as $val)
                                                    <option value="{{ $val->m_area_id }}">
                                                        {{ ucwords($val->m_area_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="update_m_jenis_nota_trans_id">Jenis Transaksi</label>
                                        <div>
                                            <select class="js-select2 get_harga get_nota"
                                                id="update_m_jenis_nota_trans_id" name="update_m_jenis_nota_trans_id[]"
                                                style="width: 100%;" data-placeholder="Pilih Jenis Transaksi" multiple>
                                                <option></option>
                                                @foreach ($listTipeTransaksi as $tipe)
                                                    <option value="{{ $tipe->m_t_t_id }}">
                                                        {{ ucwords($tipe->m_t_t_name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_tipe_nota">Tipe Nota</label>
                                        <div>
                                            <select class="js-select2" id="m_tipe_nota" name="m_tipe_nota[]"
                                                style="width: 100%;" data-placeholder="Pilih Tipe Nota" multiple>
                                                <option></option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_produk_id">Nama Menu</label>
                                        <div>
                                            <select class="js-select2 get_harga" id="m_produk_id" name="m_produk_id"
                                                style="width: 100%;" data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($produk as $val)
                                                    <option value="{{ $val->m_produk_id }}">
                                                        {{ ucwords($val->m_produk_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="harga_nota">

                                </div>
                                <div class="block-content block-content-full text-end bg-transparent">
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
        <!-- END Select2 in a modal update harga-->
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script>
        function get_harga() {
            var m_menu_id = $('#m_produk_id').val();
            var m_jenis_nota_trans_id = $('#update_m_jenis_nota_trans_id').val();
            var m_tipe_nota = $('#m_tipe_nota').val();
            if (m_menu_id && m_jenis_nota_trans_id) {
                var data = {
                    m_menu_id: m_menu_id,
                    m_tipe_nota: m_tipe_nota,
                    m_jenis_nota_trans_id: m_jenis_nota_trans_id,
                    get_tipe: 'get_harga'
                }
                $.ajax({
                    url: "/master/m_jenis_nota/get_harga",
                    type: "GET",
                    data: data,
                    success: function(respond) {
                        for (var nota in respond) {
                            var harga = respond[nota];
                            $('#' + nota).html('harga saat ini : ' + harga);
                        }
                    },
                    error: function() {}
                });
            }
        }

        function submit_update(form) {
            $.ajax({
                url: "/master/m_jenis_nota/update",
                type: "POST",
                data: $(form).serialize(),
                success: function(data) {
                    $(".modal").modal('hide');
                    Codebase.helpers('jq-notify', {
                        align: 'right', // 'right', 'left', 'center'
                        from: 'top', // 'top', 'bottom'
                        type: data
                            .type, // 'info', 'success', 'warning', 'danger'
                        icon: 'fa fa-info me-5', // Icon class
                        message: data.messages
                    });
                    window.location.reload();
                },
                error: function() {
                    alert("Tidak dapat menyimpan data!");
                }
            });
        }

        function capitalizeEachWord(text) {
            var words = text.split(" ");
            for (var i = 0; i < words.length; i++) {
                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
            }
            return words.join(" ");
        }
        $(document).ready(function() {
            Codebase.helpersOnLoad(['jq-rangeslider']);
            $('.js-select2').select2({
                dropdownParent: $('#formAction3')
            });
            $('.js-select2-copy').select2({
                dropdownParent: $('#formAction2')
            });
            $(".buttonMenu").on('click', function() {
                $("#myModalLabel").html('Update Status Menu');
                $("#modal-block-select2").modal('show');
                $('.js-select2').select2({
                    dropdownParent: $('#formAction')
                });
            });
            $(".buttonCopy").on('click', function() {
                $("#myModalLabel2").html('Copy Harga Nota');
                $("#formAction2").attr('action', "/master/m_jenis_nota/copy");
                $("#copy_nota").modal('show');
            });
            $(".buttonUpdate").on('click', function() {
                $("#myModalLabel3").html('Update Harga Nota');
                $("#update_harga").modal('show');
            });
            $(".buttonEdit").on('click', function() {
                var id = $(this).attr('value');
                $("#myModalLabel").html('Ubah Harga Nota');
                $("#formAction").attr('action', '/master/m_jenis_nota/store');
                $.ajax({
                    url: "/master/m_jenis_nota/show/" + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                        $("#m_jenis_nota_id").val(respond.m_jenis_nota_id).trigger('change');
                        $("#m_jenis_nota_m_w_id").val(respond.m_jenis_nota_m_w_id).trigger(
                            'change');
                        $("#m_jenis_nota_m_t_t_id").val(respond.m_jenis_nota_m_t_t_id).trigger(
                            'change');
                    },
                    error: function() {}
                });
                $("#modal-block-select2").modal('show');
            });
            $("#my_table").append(
                $('<tfoot/>').append($("#my_table thead tr").clone())
            );
            $('.get_harga').on('change', function() {
                get_harga();
            });
            $('#formAction3').submit(function(e) {
                if (!e.isDefaultPrevented()) {
                    submit_update('#formAction3');
                    return false;
                }
            });
            $('#formAction').submit(function(e) {
                if (!e.isDefaultPrevented()) {
                    submit_update('#formAction');
                    return false;
                }
            });
            $('#m_tipe_nota').on('change', function() {
                var selectedTipe = $(this).val();
                $('.harga_nota').empty();
                for (var i = 0; i < selectedTipe.length; i++) {
                    var formGroup = $('<div class="mb-4">' +
                        '<div class="form-group">' +
                        '<label for="nota_' + i + '">Harga ' + selectedTipe[i].toUpperCase() +
                        '</label>' +
                        '<input type="hidden" value="' + selectedTipe[i] +
                        '" name="nota_kode[]" id="nota_' + selectedTipe[i].substring(5) + '">' +
                        '<input type="text" class="form-control number" name="nom_harga[]" required>' +
                        '<span class="danger" id="nota_' + selectedTipe[i].substring(5) +
                        '_harga"></span>' +
                        '</div>' +
                        '</div>');
                    $('.harga_nota').append(formGroup);
                }
                get_harga();
            });
            $('#m_area_id').on('change',function () {
                $('.harga_nota').empty(); 
            });
            $('.get_nota').on('change', function() {
                var area_id = $('select[name="m_area_id"]').val();
                var tipe_trans_id = $('select[name="update_m_jenis_nota_trans_id[]"]').val();
                console.log(area_id);
                var data = {
                    area_id: area_id,
                    tipe_trans_id: tipe_trans_id,
                    get_tipe: 'get_nota',
                }
                $.ajax({
                    url: "/master/m_jenis_nota/get_harga",
                    type: "GET",
                    data: data,
                    success: function(respond) {
                        $('#m_tipe_nota,#m_tipe_nota_id').empty();
                        $('#m_tipe_nota,#m_tipe_nota_id').append('<option></option>');
                        respond.forEach(function(option) {
                            var capitalizedOption = capitalizeEachWord(option);
                            var $option = $('<option>', {
                                value: option,
                                text: capitalizedOption
                            });
                            $('#m_tipe_nota,#m_tipe_nota_id').append($option);
                        });
                    },
                    error: function() {}
                });
            });
        });
    </script>
@endsection
