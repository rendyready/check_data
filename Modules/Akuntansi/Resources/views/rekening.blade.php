@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Form Input Rekening
                    </div>
                    <div class="block block-rounded">
                        <div class="block-content text-muted">
                            <form id="rekening-insert">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row mb-2 col-6">
                                        <label class="col-sm-4 col-form-label" id="namaWaroeng"
                                            for="example-hf-text">Waroeng</label>
                                        <div class="col-sm-8">
                                            <select id="filter_waroeng" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control" name="m_rekening_m_waroeng_id">
                                                @foreach ($data->waroeng as $wrg)
                                                    <option value="{{ $wrg->m_w_id }}"> {{ $wrg->m_w_nama }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2 col-6">
                                        <label class="col-sm-4 col-form-label" id="categoryAccount"
                                            for="example-hf-text">Kategori Akun</label>
                                        <div class="col-md-8">
                                            <select id="filter_rekening" class="cari js-select2 form-control "
                                                style="width: 100%;" name="m_rekening_kategori">
                                                <option value="aktiva lancar">Aktiva Lancar</option>
                                                <option value="aktiva tetap">Aktiva Tetap</option>
                                                <option value="modal">Modal</option>
                                                <option value="kewajiban jangka pendek">Kewajiban Jangka Pendek</option>
                                                <option value="kewajiban jangka panjang">Kewajiban Jangka Panjang
                                                </option>
                                                <option value="pendapatan operasional">Pendapatan Operasional</option>
                                                <option value="pendapatan non operasional">Pendapatan Non Operasional
                                                </option>
                                                <option value="badan organisasi">Badan Organisasi</option>
                                                <option value="badan usaha">Badan Usaha</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="form" class="table table-bordered table-striped table-vcenter mb-4">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No Akun</th>
                                                    <th class="text-center">Nama Akun</th>
                                                    <th class="text-center">Saldo</th>
                                                    <th class="text-center">Item</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" placeholder="Input Nomor Akun"
                                                            id="m_rekening_no_akun" name="m_rekening_no_akun[]"
                                                            class="form-control set form-control-sm m_rekening_no_akun text-center no_rekening"
                                                            required />
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Input Nama Rekening"
                                                            id="m_rekening_nama" name="m_rekening_nama[]"
                                                            class="form-control set form-control-sm m_rekening_nama text-center"
                                                            required />
                                                    </td>
                                                    <td>
                                                        <input type="text" step="any"
                                                            placeholder="Input Saldo Rekening" id="m_rekening_saldo"
                                                            name="m_rekening_saldo[]"
                                                            class="form-control set saldo form-control-sm text-end number"
                                                            required />
                                                    </td>
                                                    <td>
                                                        <a placeholder="Input Nama Item" id="m_rekening_item"
                                                            name="m_rekening_item[]"
                                                            class="form-control set form-control-sm m_rekening_item text-center btn btn-primary"
                                                            title="Tambahkan Item"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn tambah btn-primary">+</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row" style="padding-left: 715px; margin-right: 10px;">
                                            <label class="col-sm-2 col-form-label" id="categoryAccount"
                                                for="example-hf-text">Total </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control set form-control-sm text-end mask"
                                                    style="color:aliceblue; background-color: rgba(230, 42, 42, 0.6);"
                                                    id="total" readonly>
                                            </div>
                                        </div>
                                        <div class="bg-transparent text-center">
                                            <button type="submit" class="btn btn-sm btn-success mt-2"> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Daftar Rekening
                        </h3>
                    </div>
                    <div class="block block-rounded">
                        <div class="block-content text-mute">
                            <div class="table-responsive">
                                <table id="rekening_tampil" class="table table-bordered table-striped table-vcenter mb-4">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">No Akun</th>
                                            <th class="text-center">Nama Akun</th>
                                            <th class="text-center">Saldo</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mb-2 col-md-8">
                                <label class="col-sm-4 col-form-label" for="example-hf-text">Copy Ke Waroeng
                                    Lain</label>
                                <div class="col-sm-6">
                                    <select style="width: 90%;" id="m_rekening_m_waroeng_id2"
                                        class="js-select2 form-control m_rekening_m_waroeng_id2"
                                        name="m_rekening_m_waroeng_id">
                                        <option class="text-center">-- Pilih Waroeng --</option>
                                        @foreach ($data->waroeng as $wrg)
                                            <option class="text-center" value="{{ $wrg->m_w_code }}"> {{ $wrg->m_w_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-4 col-form-label" for="example-hf-text">Dengan Saldo</label>
                                <div class="col-sm-6">
                                    <select style="width: 90%;" id="m_rekening_copy_saldo"
                                        class="js-select2 form-control m_rekening_copy_saldo"
                                        name="m_rekening_copy_saldo">
                                        <option class="text-center" value="tidak">Tidak</option>
                                        <option class="text-center" value="ya">Ya</option>
                                    </select>
                                </div>
                                <div class="col-sm-8">
                                    <button type="submit" id="copyrecord"
                                        class="btn btn-success btn-sm col-form-label mt-3">Copy Sekarang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Select2 in a modal -->
    <div class="modal" id="form-rekening" tabindex="-1" role="dialog" aria-labelledby="form-rekening"
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
                        <form id="formAction" name="form_action" method="post">

                            @csrf
                            <div class="mb-4">
                                <input name="m_rekening_id" type="hidden" class="m_rekening_no_akun1">
                                <div class="form-group">
                                    <label for="m_rekening_no_akun">Nomor Akun</label>
                                    <div>
                                        <input class="form-control m_rekening_no_akun1" type="text"
                                            name="m_rekening_no_akun" id="m_rekening_no_akun1" style="width: 100%;"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="m_rekening_nama">Nama Akun</label>
                                    <div>
                                        <input class="form-control m_rekening_nama" type="text" name="m_rekening_nama"
                                            id="m_rekening_nama1" style="width: 100%;" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="m_rekening_saldo">Saldo</label>
                                    <div>
                                        <input class="form-control number" type="text" name="m_rekening_saldo"
                                            id="m_rekening_saldo1" style="width: 100%;" required>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="submit">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END Select2 in a modal -->

    <!--MODAL HAPUS-->
    <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="form-rekening2"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed shadow-none mb-0">
                    <div class="block-header block-header-default bg-pulse">
                        <h3 class="block-title" id="myModalLabel2"></h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <!-- Select2 is initialized at the bottom of the page -->
                        <form id="formAction" name="form_action" method="POST">
                            @csrf
                            <div class="mb-4">
                                <input name="m_rekening_no_akun" type="hidden" id="m_rekening_no_akun2">
                                <div class="alert">
                                    <p>Apakah Anda yakin mau menghapus rekening ini?</p>
                                </div>
                            </div>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn_hapus" id="btn_hapus">Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Item -->
    <div class="modal" id="rekening_item" tabindex="-1" role="dialog" aria-labelledby="form-rekening"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed shadow-none mb-0">
                    <div class="block-header block-header-default bg-pulse">
                        <h3 class="block-title" id="item_akun_title"></h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <!-- Select2 is initialized at the bottom of the page -->
                        <form id="formAction" name="form_action" method="post">
                            @csrf
                            <div class="mb-4">
                                <input name="m_rekening_id" type="hidden" class="m_rekening_no_akun1">
                                <div class="form-group">
                                    <label for="m_rekening_no_akun" class="mb-2">Nama Akun : <span id="nama_akun">
                                        </span></label>
                                    <div class="mb-2">
                                        <input class="form-control item_akun" type="text" name="m_rekening_no_akun"
                                            id="item_akun" style="width: 100%;" required>
                                    </div>
                                    <div id="tagList"></div>
                                </div>
                            </div>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                            data-bs-dismiss="modal">Close</button>
                        {{-- <button type="submit" class="btn btn-success" id="submit">Update</button> --}}
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END Select2 in a modal -->
@endsection
@section('js')
    <script type="module">
        $(document).ready(function() {
            Codebase.helpersOnLoad(['jq-select2']);
            var no = 0;
            $('.tambah').on('click', function() {
                no++;
                $('#form').append('<tr class="hapus" id="row' + no + '">' +
                    '<td><input type="text" class="form-control form-control-sm m_rekening_no_akunjq text-center no_rekening" name="m_rekening_no_akun[]" id="m_rekening_no_akunjq' +
                    no + '" placeholder="Input Nomor Akun" required></td>' +
                    '<td><input type="text" class="form-control form-control-sm m_rekening_namajq text-center" name="m_rekening_nama[]" id="m_rekening_namajq' +
                    no + '" placeholder="Input Nama Rekening" required></td>' +
                    '<td><input type="text" class="form-control saldo form-control-sm text-end number" name="m_rekening_saldo[]" id="m_rekening_saldo" placeholder="Input Saldo Rekening" required></td>' +
                    '<td><button type="button" id="' + no +
                    '" class="btn btn-danger btn_remove"> - </button></td> </tr> ');
            });

            function formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            $(document).on('focusout', '.no_rekening', function() {
                var current_value = $(this).val().trim();
                var prev = $(this).data('previous-value');

                if (current_value === '') {
                    return;
                }

                var isDuplicate = false;

                $('.no_rekening').not(this).each(function() {
                    if ($(this).val() === current_value) {
                        isDuplicate = true;
                        return false;
                    }
                });

                if (isDuplicate) {
                    Swal.fire({
                        title: 'Warning',
                        text: 'Nomor Akun Sudah Digunakan',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-red-500',
                        },
                    });
                    $(this).val('');
                } else {
                    $(this).data('previous-value', current_value);
                }
                console.log(current_value);
            });

            var waroengid = $('#filter_waroeng').val();
            var rekeningkategori = $('#filter_rekening').val();
            var table, save_method;

            $(function() {
                table = $('#rekening_tampil').DataTable({
                    buttons: [],
                    destroy: true,
                    orderCellsTop: true,
                    processing: true,
                    autoWidth: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    ajax: {
                        url: '{{ route('rekening.tampil') }}',
                        data: {
                            m_rekening_m_waroeng_id: waroengid,
                            m_rekening_kategori: rekeningkategori,
                        },
                        type: "GET",
                    },
                });
            });

            $("#item_akun").on("keypress", function(event) {
                if (event.which === 13 || event.which === 44) {
                    event.preventDefault();
                    var tag = $(this).val().trim();
                    if (tag !== "") {
                        $("#tagList").append('<div class="tag">' + tag + '</div>');
                    }
                    $(this).val("");
                }
            });

            $("#tagList").on("click", ".tag", function() {
                $(this).remove();
            });

            $("#m_rekening_item").on('click', function() {
                var id = $(this).attr('value');
                var rekening_nama = $("#m_rekening_nama").val();
                // $('#item_akun_title form')[0].reset();
                $("#item_akun_title").html('Isi Item Akun');
                $("#nama_akun").html('<b>' + rekening_nama +
                    '</b>');
                $("#rekening_item").modal('show');
            });


            //get edit
            $("#rekening_tampil").on('click', '.buttonEdit', function() {
                var id = $(this).attr('value');
                $('#form-rekening form')[0].reset();
                $("#myModalLabel").html('Ubah Data Rekening');
                $.ajax({
                    url: "/akuntansi/rekening/edit/" + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                        // console.log(respond);
                        $(".m_rekening_no_akun1").val(respond.m_rekening_code).trigger(
                            'change');
                        $("#m_rekening_nama1").val(respond.m_rekening_nama).trigger('change');
                        $("#m_rekening_saldo1").val(formatNumber(Number(respond
                                .m_rekening_saldo)))
                            .trigger(
                                'change');
                    },
                    error: function() {}
                });
                $("#form-rekening").modal('show');
            });

            //edit
            $('#formAction').submit(function(e) {
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: "{{ route('rekening.simpan_edit') }}",
                        type: "POST",
                        data: $('#form-rekening form').serialize(),
                        success: function(data) {
                            console.log(data);
                            $('#form-rekening').modal('hide');
                            Codebase.helpers('jq-notify', {
                                align: 'right',
                                from: 'top',
                                type: data.type,
                                icon: 'fa fa-info me-5',
                                message: data.messages
                            });
                            table.ajax.reload();
                        },
                    });
                    return false;
                }
            });

            //GET HAPUS
            $('#rekening_tampil').on('click', '.buttonHapus', function() {
                var id = $(this).attr('value');
                $("#myModalLabel2").html('Konfirmasi Hapus Rekening');
                $('#ModalHapus').modal('show');
                $('[name="m_rekening_no_akun"]').val(id);

            });

            //Hapus
            $('#btn_hapus').on('click', function() {
                var id = $('#m_rekening_no_akun2').val();
                $.ajax({
                    type: "POST",
                    url: "/akuntansi/rekening/delete/" + id,
                    dataType: "JSON",
                    data: $('#ModalHapus form').serialize(),
                    success: function(data) {
                        console.log(data);
                        $('#ModalHapus').modal('hide');
                        Codebase.helpers('jq-notify', {
                            align: 'right', // 'right', 'left', 'center'
                            from: 'top', // 'top', 'bottom'
                            type: 'info', // 'info', 'success', 'warning', 'danger'
                            icon: 'fa fa-info me-5', // Icon class
                            message: 'Berhasil hapus rekening.',
                        });
                        table.ajax.reload();
                    },
                });
                return false;
            });

            $('#rekening-insert').submit(function(e) {
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: "{{ route('rekening.simpan') }}",
                        type: "POST",
                        data: $('#rekening-insert').serialize(),
                        success: function(data) {
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: data
                                    .type, // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: data.messages
                            });
                            $('.hapus').remove();
                            $('.set').val('');

                            var waroengid2 = $('#filter_waroeng').val();
                            var rekeningkategori2 = $('#filter_rekening').val();

                            $('#rekening_tampil').DataTable({
                                button: [],
                                destroy: true,
                                orderCellsTop: true,
                                processing: true,
                                autoWidth: true,
                                lengthMenu: [
                                    [10, 25, 50, 100, -1],
                                    [10, 25, 50, 100, "All"]
                                ],
                                ajax: {
                                    url: '{{ route('rekening.tampil') }}',
                                    data: {
                                        m_rekening_m_waroeng_id: waroengid,
                                        m_rekening_kategori: rekeningkategori,
                                    },
                                    type: "GET",
                                },
                            });
                        },
                        error: function() {
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                    return false;
                }
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                $('.saldo').trigger("input");
            });

            $('.cari').on('change', function() {
                var waroengid = $('#filter_waroeng').val();
                var rekeningkategori = $('#filter_rekening').val();
                $('#rekening_tampil').DataTable({
                    button: [],
                    destroy: true,
                    orderCellsTop: true,
                    processing: true,
                    autoWidth: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    ajax: {
                        url: '{{ route('rekening.tampil') }}',
                        data: {
                            m_rekening_m_waroeng_id: waroengid,
                            m_rekening_kategori: rekeningkategori,
                        },
                        type: "GET",
                    },
                });
            });

            $(document).on('input', '.number', function() {
                var angka = $(this).val();
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    angka_hasil = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    angka_hasil += separator + ribuan.join('.');
                }

                $(this).val(angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] :
                    angka_hasil);
            });

            $("input.mask").each((i, ele) => {
                let clone = $(ele).clone(false)
                clone.attr("type", "text")
                let ele1 = $(ele)
                clone.val(Number(ele1.val()).toLocaleString("id"))
                $(ele).after(clone)
                $(ele).hide()
                setInterval(() => {
                    let newv = Number(ele1.val()).toLocaleString("id")
                    if (clone.val() != newv) {
                        clone.val(newv)
                    }
                }, 10)
                $(ele).mouseleave(() => {
                    $(clone).show()
                    $(ele1).hide()
                })
            })

            //auto sum multiple insert
            $(document).on('input', '.saldo', function() {
                var sum = 0;
                $(".saldo").each(function() {
                    sum += +$(this).val().replace(/\./g, '').replace(/\,/g, '.');
                });
                $('#total').val(sum);
            });

            //validasi nama
            $(document).on("change", ".m_rekening_nama", function() {
                var nama = $('#m_rekening_nama').val().toLowerCase();
                var waroengid = $('#filter_waroeng').val();
                var rekeningkategori = $('#filter_rekening').val();
                $.ajax({
                    url: "{{ route('rekening.validasinama') }}",
                    data: {
                        m_rekening_nama: nama,
                        m_rekening_m_waroeng_id: waroengid,
                    },
                    type: "get",
                    success: function(data) {
                        if (data > 0) {
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: 'danger', // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: 'Nama rekening yang anda inputkan sama/ duplikat !'
                            });
                            $('.m_rekening_nama').val('');
                        }
                    },
                });
            });

            //validasi no akun
            $(document).on("change", ".m_rekening_no_akun", function() {
                var no = $('#m_rekening_no_akun').val();
                var waroengid = $('#filter_waroeng').val();
                var rekeningkategori = $('#filter_rekening').val();
                $.ajax({
                    url: "{{ route('rekening.validasino') }}",
                    data: {
                        m_rekening_no_akun: no,
                        m_rekening_m_waroeng_id: waroengid,
                    },
                    type: "get",
                    success: function(data) {

                        // console.log(data);
                        if (data > 0) {
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: 'danger', // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: 'No Akun yang anda inputkan sama/duplikat ! '
                            });
                            $('.m_rekening_no_akun').val('');
                        }
                    },
                });
            });

            //validasi nama jquery
            $(document).on("change", ".m_rekening_namajq", function() {
                var id = $(this).closest("tr").index();
                var nama = $('#m_rekening_namajq' + id).val().toLowerCase();
                var waroengid = $('#filter_waroeng').val();
                var rekeningkategori = $('#filter_rekening').val();
                $.ajax({
                    url: "{{ route('rekening.validasinama') }}",
                    data: {
                        m_rekening_nama: nama,
                        m_rekening_m_waroeng_id: waroengid,
                    },
                    type: "get",
                    success: function(data) {
                        if (data > 0) {
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: 'danger', // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: 'Nama rekening yang anda inputkan sama/ duplikat !'
                            });
                            $('#m_rekening_namajq' + id).val('');
                        }
                    },
                });
            });

            //validasi no akun jquery
            $(document).on("change", ".m_rekening_no_akunjq", function() {
                var id = $(this).closest("tr").index();
                var no = $('#m_rekening_no_akunjq' + id).val();
                var waroengid = $('#filter_waroeng').val();
                var rekeningkategori = $('#filter_rekening').val();
                $.ajax({
                    url: "{{ route('rekening.validasino') }}",
                    data: {
                        m_rekening_no_akun: no,
                        m_rekening_m_waroeng_id: waroengid,
                    },
                    type: "get",
                    success: function(data) {
                        if (data > 0) {
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: 'danger', // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: 'No Akun yang anda inputkan sama/duplikat ! '
                            });
                            $('#m_rekening_no_akunjq' + id).val('');
                        }
                    },
                });
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                $('.saldo').trigger("input");
            });

            //copyrecord
            $(document).on('click', '#copyrecord', function() {
                var waroengasal = $('#filter_waroeng').val();
                var waroengtj = $('#m_rekening_m_waroeng_id2').val();
                var waroengasal1 = $('#filter_waroeng').val();
                var waroengtj1 = $('#m_rekening_m_waroeng_id2').val();
                var saldo = $('#m_rekening_copy_saldo').val();
                if (waroengasal1 != waroengtj1) {
                    $.ajax({
                        url: "{{ route('rekening.copyrecord') }}",
                        data: {
                            waroeng_asal: waroengasal,
                            waroeng_tujuan: waroengtj,
                            m_rekening_copy_saldo: saldo,
                        },
                        type: "GET",
                        success: function(data) {
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: data
                                    .type, // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: data.messages
                            });
                        },
                    });
                } else {
                    Codebase.helpers('jq-notify', {
                        align: 'right', // 'right', 'left', 'center'
                        from: 'top', // 'top', 'bottom'
                        type: 'danger', // 'info', 'success', 'warning', 'danger'
                        icon: 'fa fa-info me-5', // Icon class
                        message: 'waroeng yang anda pilih sama dengan yang di halaman !'
                    });
                    $('#m_rekening_m_waroeng_id2').val('-- Pilih Waroeng --').trigger('change');
                }
            });

        });
    </script>
@endsection
