@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Jurnal Bank</h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="jurnal-insert">
                            <div class="col-md-12">

                                <div class="row mb-2 col-6">
                                    <label class="col-sm-4 col-form-label" id="namaWaroeng"
                                        for="example-hf-text">Waroeng</label>
                                    <div class="col-sm-8">
                                        <select id="filter-waroeng" style="width: 100%;"
                                            class="cari js-select2 form-control" name="r_j_b_m_w_id">
                                            @foreach ($data->waroeng as $wrg)
                                                <option
                                                    value="{{ $wrg->m_w_id . ',' . $wrg->m_w_nama . ',' . $wrg->m_area_id . ',' . $wrg->m_area_nama }}">
                                                    {{ $wrg->m_w_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-2 col-6">
                                    <label class="col-sm-4 col-form-label" id="categoryAccount" for="example-hf-text">Jenis
                                        Transaksi</label>
                                    <div class="col-md-8">
                                        <select id="filter-kas" class="cari js-select2 form-control kas-click"
                                            style="width: 100%;" name="r_j_b_status">
                                            <option value="km">Kas Masuk</option>
                                            <option value="kk">Kas Keluar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2 col-6">
                                    <label class="col-sm-4 col-form-label" id="categoryAccount"
                                        for="example-hf-text">Tanggal</label>
                                    <div class="col-md-8">
                                        <input type="text" value="<?= date('Y-m-d') ?>" id="filter-tanggal"
                                            class="cari form-control " style="width: 100%;" name="r_j_b_tanggal"
                                            placeholder="Pilih Tanggal.." readonly>
                                    </div>
                                </div>
                                <div class="row mb-2 col-6">
                                    <label class="col-sm-4 col-form-label" id="categoryAccount"
                                        for="example-hf-text">BANK</label>
                                    <div class="col-md-8">
                                        <select class="cari js-select2 form-control kas-click"
                                            style="width: 100%;" name="r_j_b_m_akun_bank_id">
                                            @foreach ($data->daftar_bank as $daftar_bank)
                                                <option value="{{ $daftar_bank->m_akun_bank_id }}">
                                                    {{ $daftar_bank->m_akun_bank_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>
                                <div class="table-responsive mt-4">
                                    <table id="form" class="table table-bordered table-striped table-vcenter mb-4">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Item Produk</th>
                                                <th class="text-center">No Akun</th>
                                                <th class="text-center">Nama Akun</th>
                                                <th class="text-center">Keterangan</th>
                                                <th class="kas text-center">Kredit</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select id="item_produk"
                                                        class="js-select2 set form-control form-control-sm"
                                                        style="width: 100%;" name="r_j_b_m_rekening_item[]"
                                                        data-placeholder="Pilih Item">
                                                        <option value=""></option>
                                                        @foreach ($data->rekening as $item)
                                                            @if ($item->m_rekening_item != null)
                                                                @php
                                                                    $rekeningItemString = $item->m_rekening_item;
                                                                    $rekeningItemArray = explode(',', $rekeningItemString);
                                                                @endphp

                                                                @if (is_array($rekeningItemArray))
                                                                    @foreach ($rekeningItemArray as $value)
                                                                        <option value="{{ $value }}">
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Input Nomor Akun"
                                                        id="r_j_b_m_rekening_code" name="r_j_b_m_rekening_code[]"
                                                        class="form-control set form-control-sm no-akun text-center" />
                                                </td>
                                                <td>
                                                    <select id="m_rekening_nama" name="r_j_b_m_rekening_nama[]"
                                                        data-placeholder="Pilih Nama Rekening"
                                                        class="js-select2 set_select showrek" style="width:200px;">
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Input Particul" id="r_j_b_particul"
                                                        name="r_j_b_particul[]"
                                                        class="form-control set form-control-sm text-center" />
                                                </td>
                                                <td>
                                                    <div class="saldo_debit">
                                                        <input type="text" placeholder="Input Saldo Debit"
                                                            id="r_j_b_debit" name="r_j_b_debit[]"
                                                            class="form-control set form-control-sm saldo text-end number" />
                                                    </div>
                                                    <div class="saldo_kredit">
                                                        <input type="text" placeholder="Input Saldo Kredit"
                                                            id="r_j_b_kredit" name="r_j_b_kredit[]"
                                                            class="form-control set form-control-sm saldo text-end number" />
                                                    </div>
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
                                                id="total"
                                                style="color:aliceblue; background-color: rgba(230, 42, 42, 0.6);"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="bg-transparent text-center mb-4">
                                        <button type="submit" class="btn btn-sm btn-success mt-2 simpan">
                                            Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                            Daftar Jurnal
                        </h3>
                    </div>
                    <div class="block block-rounded">
                        <div class="block-content text-mute">
                            <div class="table-responsive">
                                <table id="jurnal-tampil"
                                    class="table table-bordered table-striped table-vcenter mb-4 nowrap">
                                    <thead class="justify-content-center">
                                        <tr>
                                            <th class="text-center">No Akun</th>
                                            <th class="text-center">Nama Akun</th>
                                            {{-- <th class="text-center">Item Produk</th> --}}
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Debit</th>
                                            <th class="text-center">Kredit</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">No Bukti</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataReload">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- js -->

    <script type="module">
        $(document).ready(function() {
            Codebase.helpersOnLoad(['jq-select2']);
            var no = 0;
            $('.tambah').on('click', function() {
                no++;
                $('#form').append('<tr class="hapus" id="' + no + '">' +

                    '<td><select data-placeholder="Pilih Input" id="item_produkjq' + no +
                    '" style="width:200px;" class="js-select2 item_produkjq" name="r_j_b_m_rekening_item[]"></select></td>' +

                    '<td><input type="text" placeholder="Input Nomor Akun" id="r_j_b_m_rekening_codejq' +
                    no +
                    '" name="r_j_b_m_rekening_code[]" class="form-control form-control-sm no_akunjq text-center"/></td>' +
                    '<td><select data-placeholder="Pilih Nama Rekening" id="m_rekening_namajq' + no +
                    '" style="width:200px;" class="js-select2 showrekjq" name="r_j_b_m_rekening_nama[]"></select></td>' +
                    '<td><input type="text" class="form-control form-control-sm text-center" name="r_j_b_particul[]" id="r_j_b_particul" placeholder="Input Particul"></td>' +
                    '<td><div class="saldo_debit"><input type="text" class="form-control form-control-sm saldo text-end number" name="r_j_b_debit[]" id="r_j_b_debitjq' +
                    no + '" placeholder="Input Saldo Debit"></div>' +
                    '<div class="saldo_kredit"><input type="text" class="form-control form-control-sm saldo text-end number" name="r_j_b_kredit[]" id="r_j_b_kreditjq' +
                    no + '" placeholder="Input Saldo Kredit"></div></td>' +
                    '<td><button type="button" class="btn btn-danger btn_remove saldo"> - </button></td> </tr> '
                );
            });

            $('#item_produk').on('change', function() {
                var item_produk = $(this).val();
                $.ajax({
                    type: "get",
                    url: '{{ route('jurnal_bank.item') }}',
                    data: {
                        item_produk: item_produk,
                    },
                    success: function(data) {
                        console.log(data);
                        $('#r_j_b_m_rekening_code').val(data.m_rekening_code).trigger("change");
                        $('#m_rekening_nama').val(data.m_rekening_id).trigger("change");
                    }
                });
            });

            $(document).on('select2:select', '.item_produkjq', function() {
                var id = $(this).closest("tr").attr("id");
                var item_produk = $('#item_produkjq' + id).val();
                $.ajax({
                    type: "get",
                    url: '{{ route('jurnal_bank.item') }}',
                    data: {
                        item_produk: item_produk,
                    },
                    success: function(data) {
                        console.log(data);
                        $('#r_j_b_m_rekening_codejq' + id).val(data.m_rekening_code);
                        $('#m_rekening_namajq' + id).val(data.m_rekening_id).trigger("change");
                    }
                });
            });

            //hapus multiple
            $(document).on('click', '.btn_remove', function() {
                $(this).parents('tr').remove();
                $('.saldo').trigger("input");
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

            var m_w_id = $('#filter-waroeng').val();
            var filwaroeng = m_w_id.split(',')[0];
            var filkas = $('#filter-kas').val();
            var filtanggal = $('#filter-tanggal').val();
            console.log(filwaroeng);
            //tampil
            $('#jurnal-tampil').DataTable({
                "columnDefs": [{
                    "render": DataTable.render.number('.', ',', 2, 'Rp. '),
                    "targets": [4, 5],
                }],
                buttons: [],
                destroy: true,
                lengthMenu: [10, 25, 50, 75, 100],
                ajax: {
                    url: '{{ route('jurnal_bank.tampil') }}',
                    data: {
                        r_j_b_m_w_id: filwaroeng,
                        r_j_b_status: filkas,
                        r_j_b_tanggal: filtanggal,
                    },
                    type: "GET",
                },
                columns: [{
                        data: 'r_j_b_m_rekening_code'
                    },
                    {
                        data: 'r_j_b_m_rekening_nama'
                    },
                    // {
                    //   data: 'r_j_b_m_rekening_item'
                    //},
                    {
                        data: 'r_j_b_particul'
                    },
                    {
                        data: 'r_j_b_debit',
                        visible: (filkas === 'kk')
                    },
                    {
                        data: 'r_j_b_kredit',
                        visible: (filkas === 'km')
                    },
                    {
                        data: 'r_j_b_users_name'
                    },
                    {
                        data: 'r_j_b_transaction_code'
                    },
                ],
            });

            //insert
            $('#jurnal-insert').submit(function(e) {
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: "{{ route('jurnal_bank.simpan') }}",
                        type: "POST",
                        data: $('form').serialize(),
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                Codebase.helpers('jq-notify', {
                                    align: 'right', // 'right', 'left', 'center'
                                    from: 'top', // 'top', 'bottom'
                                    type: data
                                        .type, // 'info', 'success', 'warning', 'danger'
                                    icon: 'fa fa-info me-5', // Icon class
                                    message: data.messages
                                });
                                $('.hapus').remove();
                                $('.print-error-msg').remove();
                                $('.set').val('');
                                $('#m_rekening_nama').val('').trigger("change");


                                var m_w_id = $('#filter-waroeng').val();
                                var filwaroeng2 = m_w_id.split(',')[0];
                                var filkas2 = $('#filter-kas').val();
                                var filtanggal2 = $('#filter-tanggal').val();

                                $('#jurnal-tampil').DataTable({
                                    "columnDefs": [{
                                        "render": DataTable.render.number('.',
                                            ',', 2, 'Rp. '),
                                        "targets": [4, 5],
                                    }],
                                    buttons: [],
                                    destroy: true,
                                    lengthMenu: [10, 25, 50, 75, 100],
                                    ajax: {
                                        url: '{{ route('jurnal_bank.tampil') }}',
                                        data: {
                                            r_j_b_m_w_id: filwaroeng2,
                                            r_j_b_status: filkas2,
                                            r_j_b_tanggal: filtanggal2,
                                        },
                                        type: "GET",
                                    },
                                    columns: [{
                                            data: 'r_j_b_m_rekening_code'
                                        },
                                        {
                                            data: 'r_j_b_m_rekening_nama'
                                        },
                                        // {
                                        //     data: 'r_j_b_m_rekening_item'
                                        // },
                                        {
                                            data: 'r_j_b_particul'
                                        },
                                        {
                                            data: 'r_j_b_debit',
                                            visible: (filkas2 === 'kk')
                                        },
                                        {
                                            data: 'r_j_b_kredit',
                                            visible: (filkas2 === 'km')
                                        },
                                        {
                                            data: 'r_j_b_users_name'
                                        },
                                        {
                                            data: 'r_j_b_transaction_code'
                                        },
                                    ],
                                });

                            } else {
                                printErrorMsg(data.error);
                            }
                        },
                        error: function() {
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                    $('#item_produk').val('').trigger("change");
                    return false;
                }
            });

            function printErrorMsg(msg) {

                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'block');
                $.each(msg, function(key, value) {
                    $(".print-error-msg").find("ul").append(
                        '<li>Kolom masih kosong, atau tanggal bukan hari ini. Silahkan periksa kembali.</li>'
                    );
                });
            }

            //filter tampil
            $('.cari').on('change', function() {
                var m_w_id = $('#filter-waroeng').val();
                var filwaroeng = m_w_id.split(',')[0];
                var filkas = $('#filter-kas').val();
                var filtanggal = $('#filter-tanggal').val();
                console.log(filwaroeng);
                $('#jurnal-tampil').DataTable({
                    "columnDefs": [{
                        "render": DataTable.render.number('.', ',', 2, 'Rp. '),
                        "targets": [4, 5],
                    }],
                    buttons: [],
                    destroy: true,
                    lengthMenu: [10, 25, 50, 75, 100],
                    ajax: {
                        url: '{{ route('jurnal_bank.tampil') }}',
                        data: {
                            r_j_b_m_w_id: filwaroeng,
                            r_j_b_status: filkas,
                            r_j_b_tanggal: filtanggal,
                        },
                        type: "GET",
                    },
                    columns: [{
                            data: 'r_j_b_m_rekening_code'
                        },
                        {
                            data: 'r_j_b_m_rekening_nama'
                        },
                        // {
                        //     data: 'r_j_b_m_rekening_item'
                        // },
                        {
                            data: 'r_j_b_particul'
                        },
                        {
                            data: 'r_j_b_debit',
                            visible: (filkas === 'kk')
                        },
                        {
                            data: 'r_j_b_kredit',
                            visible: (filkas === 'km')
                        },
                        {
                            data: 'r_j_b_users_name'
                        },
                        {
                            data: 'r_j_b_transaction_code'
                        },
                    ],
                });
            });

            var kas = $('.kas-click').val();
            if (kas == 'kk') {
                $('.kas').html('Debit')
                $('.saldo_debit').show()
                $('.saldo_kredit').hide()
            } else {
                $('.kas').html('Kredit')
                $('.saldo_kredit').show()
                $('.saldo_debit').hide()
            }

            //auto change debit/kredit
            $('.kas-click').on('change', function() {
                var kas = $(this).val();
                if (kas == 'kk') {
                    $('.kas').html('Debit')
                    $('.saldo_debit').show()
                    $('.saldo_kredit').hide()
                } else {
                    $('.kas').html('Kredit')
                    $('.saldo_kredit').show()
                    $('.saldo_debit').hide()
                }
            });

            $.ajax({
                url: '{{ route('jurnal_bank.rekeninglink') }}',
                type: 'GET',
                dataType: 'Json',
                success: function(data) {
                    $('#m_rekening_nama').append('<option></option>');
                    $.each(data, function(key, value) {
                        $('#m_rekening_nama').append('<option value="' + key + '">' +
                            value +
                            '</option>');
                    });
                }
            })

            //default select nama rekening jquery
            $('.tambah').on('click', function() {
                var id = $(this).closest("tr").index() + no++;
                $('#m_rekening_namajq' + id).select2();
                // console.log(id);
                $.ajax({
                    url: '{{ route('jurnal_bank.rekeninglink') }}',
                    type: 'GET',
                    dataType: 'Json',
                    success: function(data) {
                        // console.log(data);
                        $('#m_rekening_namajq' + id).append('<option></option>');
                        $.each(data, function(key, value) {
                            $('#m_rekening_namajq' + id).append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    },
                });

                $('#item_produkjq' + id).select2();
                $.ajax({
                    url: '{{ route('jurnal_bank.list_item') }}',
                    type: 'GET',
                    dataType: 'Json',
                    success: function(data) {
                        if (data) {
                            $('#item_produkjq' + id).append('<option></option>');
                            for (var key in data) {
                                if (data.hasOwnProperty(key)) {
                                    var options = key.split(',');

                                    options.forEach(function(option) {
                                        $('#item_produkjq' + id).append(
                                            '<option value="' + option + '">' +
                                            option + '</option>');
                                    });
                                }
                            }
                        }
                    },
                });

                if (kas == 'kk') {
                    $('.kas').html('Debit')
                    $('.saldo_debit').show()
                    $('.saldo_kredit').hide()
                } else {
                    $('.kas').html('Kredit')
                    $('.saldo_kredit').show()
                    $('.saldo_debit').hide()
                }
            });

            //show nama rekening
            $('#r_j_b_m_rekening_code').on('keyup', function() {
                // $('#item_produk').val('').trigger("change");
                var filnomor = $('#r_j_b_m_rekening_code').val();
                // console.log(filnomor);
                $.ajax({
                    type: "get",
                    url: '{{ route('jurnal_bank.carijurnalnoakun') }}',
                    data: {
                        m_rekening_code: filnomor,
                    },
                    success: function(data) {
                        console.log(data);
                        $('#m_rekening_nama').val(data.m_rekening_id).trigger("change");
                    }
                });
            });

            //show nama rekening jquery
            $(document).on('keyup', '.no_akunjq', function() {
                var id = $(this).closest("tr").attr("id");
                var filnomor2 = $('#r_j_b_m_rekening_codejq' + id).val();
                $.ajax({
                    type: "get",
                    url: '{{ route('jurnal_bank.carijurnalnoakun') }}',
                    data: {
                        m_rekening_code: filnomor2,
                    },
                    success: function(data) {
                        // console.log(data);
                        $('#m_rekening_namajq' + id).val(data.m_rekening_id).trigger("change");
                    }
                });
            });

            //show no rekening
            $('#m_rekening_nama').on('select2:select', function() {
                var filnama = $('#m_rekening_nama').val();
                console.log(filnama);
                $.ajax({
                    type: "get",
                    url: '{{ route('jurnal_bank.carijurnalnamaakun') }}',
                    data: {
                        m_rekening_nama: filnama,
                    },
                    success: function(data) {
                        console.log(data);
                        $('#r_j_b_m_rekening_code').val(data.m_rekening_code);
                        // $('#item_produk').val('').trigger("change");
                    }
                });
            });

            //show no rekening jquery
            $(document).on('select2:select', '.showrekjq', function() {
                var id = $(this).closest("tr").attr("id");
                var filnama = $('#m_rekening_namajq' + id).val();
                $.ajax({
                    type: "get",
                    url: '{{ route('jurnal_bank.carijurnalnamaakun') }}',
                    data: {
                        m_rekening_nama: filnama,
                    },
                    success: function(data) {
                        console.log(data);
                        $('#r_j_b_m_rekening_codejq' + id).val(data.m_rekening_code);
                    }
                });
            });

            $('#filter-tanggal').flatpickr({
                dateFormat: 'Y-m-d',
            });

        });
    </script>
@endsection
