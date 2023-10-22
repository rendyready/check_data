@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Master Customer
                    </div>
                    <div class="block-content text-muted">

                        <a class="btn btn-success mr-2 mb-2 buttonInsert" title="Edit" style="color: #fff"><i
                                class="fa fa-plus mr-5"></i>Customer</a>
                        <a class="btn btn-warning mr-2 mb-2 buttonWaroeng" title="Edit" style="color: #fff"><i
                                class="fa fa-plus mr-5"></i>Waroeng</a>
                        <table id="tb_customer"
                            class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <th>No</th>
                                <th>Code</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                {{-- <th>Kota</th> --}}
                                <th>Telp</th>
                                <th>Keterangan</th>
                                <th>Saldo</th>
                                <th>Rekening</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>No</th>
                                <th>Code</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                {{-- <th>Kota</th> --}}
                                <th>Telp</th>
                                <th>Keterangan</th>
                                <th>Saldo</th>
                                <th>Rekening</th>
                                <th>Aksi</th>
                            </tfoot>
                        </table>

                        <!-- Select2 in a modal -->
                        <div class="modal" id="form-customer" tabindex="-1" role="dialog" aria-labelledby="form-customer"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="block block-themed shadow-none mb-0">
                                        <div class="block-header block-header-default bg-pulse">
                                            <h3 class="block-title" id="myModalLabel"></h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i class="fa fa-fw fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <!-- Select2 is initialized at the bottom of the page -->
                                            <form id="formAction" name="form_action" method="post">
                                                <div class="mb-4">
                                                    <input name="action" type="hidden" id="action">
                                                    <input name="m_customer_code" type="hidden" id="m_customer_code">
                                                    <div class="form-group">
                                                        <label for="m_customer_nama">Nama customer</label>
                                                        <div>
                                                            <input class="form-control" type="text"
                                                                name="m_customer_nama" id="m_customer_nama"
                                                                style="width: 100%;" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_customer_alamat">Alamat customer</label>
                                                        <div>
                                                            <textarea class="form-control" type="text" name="m_customer_alamat" id="m_customer_alamat" style="width: 100%;"
                                                                cols="3" rows="2" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_customer_kota">Kota customer</label>
                                                        <div>
                                                            <input class="form-control" type="text"
                                                                name="m_customer_kota" id="m_customer_kota"
                                                                style="width: 100%;" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_customer_telp">Telp customer</label>
                                                        <div>
                                                            <input class="form-control" type="number"
                                                                name="m_customer_telp" id="m_customer_telp"
                                                                style="width: 100%;" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_customer_ket">Keterangan Customer</label>
                                                        <div>
                                                            <textarea class="form-control" type="text" name="m_customer_ket" id="m_customer_ket" style="width: 100%;"
                                                                cols="3" rows="2" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_customer_jth_tempo">Durasi Jatuh Tempo
                                                            Pembayaran</label>
                                                        <div>
                                                            <input class="form-control" type="number" min="0"
                                                                name="m_customer_jth_tempo" id="m_customer_jth_tempo"
                                                                style="width: 100%;" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_customer_rek">No Rekening</label>
                                                        <div>
                                                            <input class="form-control" type="number" name="m_customer_rek"
                                                                id="m_customer_rek" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_customer_rek_nama">Nama Rekening</label>
                                                        <div>
                                                            <input class="form-control" type="text"
                                                                name="m_customer_rek_nama" id="m_customer_rek_nama"
                                                                style="width: 100%;">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_customer_bank_nama">Nama Bank</label>
                                                        <div>
                                                            <input class="form-control" type="text"
                                                                name="m_customer_bank_nama" id="m_customer_bank_nama"
                                                                style="width: 100%;">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="m_customer_saldo_awal">Saldo Awal</label>
                                                        <div>
                                                            <input class="form-control" type="number"
                                                                name="m_customer_saldo_awal" id="m_customer_saldo_awal"
                                                                style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="block-content block-content-full text-end bg-body">
                                            <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                                data-bs-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-success" id="submit">
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Select2 in a modal -->
                    <!-- Select2 in a modal -->
                    <div class="modal modal-xl" id="form-customer-wrg" tabindex="-1" role="dialog"
                        aria-labelledby="form-customer-wrg" aria-hidden="true">
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
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h3>Nama Waroeng : </h3>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="js-select2" id="m_w_id" name="m_w_id"
                                                        style="width: 100%;" data-container="#form-customer-wrg"
                                                        data-placeholder="Pilih Waroeng">
                                                        <option></option>
                                                        @foreach ($waroeng as $item)
                                                            <option value="{{ $item->m_w_id }}">
                                                                {{ $item->m_w_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-info cari-waroeng">Cari</button>
                                            </div>
                                        </div>
                                        <form id="formAction2" name="form_action2" method="post">
                                            <input name="action" type="hidden" id="action2">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="list-group push">
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control" id="searchInput"
                                                                placeholder="Cari customer">
                                                        </div>
                                                        <div class="master"
                                                            style="max-height: 300px;
                                                        overflow-y: auto;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9 formisi">
                                                    <table id="tb_waroeng"
                                                        class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                                                        <thead>
                                                            <th>No</th>
                                                            <th>Nama customer</th>
                                                            <th>Saldo</th>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <th>No</th>
                                                            <th>Nama customer</th>
                                                            <th>Saldo</th>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="block-content block-content-full text-end bg-body">
                                        <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                            data-bs-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-success" id="submit">
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Select2 in a modal -->
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });
            Codebase.helpersOnLoad(['jq-select2', 'jq-notify']);
            var table, save_method;
            $(function() {
                table = $('#tb_customer').DataTable({
                    "destroy": true,
                    "orderCellsTop": true,
                    "processing": true,
                    "autoWidth": true,
                    "lengthMenu": [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    "pageLength": 10,
                    "ajax": {
                        "url": "{{ route('customer.data') }}",
                        "type": "GET"
                    }
                });
            });
            $(".buttonInsert").on('click', function() {
                $('[name="action"]').val('add');
                var id = $(this).attr('value');
                $('#form-customer form')[0].reset();
                $("#myModalLabel").html('Tambah customer');
                $("#form-customer").modal('show');
            });
            $("#tb_customer").on('click', '.buttonEdit', function() {
                var id = $(this).attr('value');
                $('[name="action"]').val('edit');
                $('#form-customer form')[0].reset();
                $("#myModalLabel").html('Ubah customer');
                $.ajax({
                    url: "/inventori/customer/edit/" + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                        $("#m_customer_code").val(respond.m_customer_code).trigger('change');
                        $("#m_customer_nama").val(respond.m_customer_nama).trigger('change');
                        $("#m_customer_alamat").val(respond.m_customer_alamat).trigger(
                            'change');
                        $("#m_customer_kota").val(respond.m_customer_kota).trigger('change');
                        $("#m_customer_telp").val(respond.m_customer_telp).trigger('change');
                        $("#m_customer_ket").val(respond.m_customer_ket).trigger('change');
                        $("#m_customer_rek").val(respond.m_customer_rek).trigger('change');
                        $("#m_customer_rek_nama").val(respond.m_customer_rek_nama).trigger(
                            'change');
                        $("#m_customer_bank_nama").val(respond.m_customer_bank_nama).trigger(
                            'change');
                        $("#m_customer_saldo_awal").val(respond.m_customer_saldo_awal).trigger(
                            'change');
                        $("#m_customer_jth_tempo").val(respond.m_customer_jth_tempo).trigger(
                            'change');
                    },
                    error: function() {}
                });
                $("#form-customer").modal('show');
            });
            $('#formAction').submit(function(e) {
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: "{{ route('customer.action') }}",
                        type: "POST",
                        data: $('#form-customer form').serialize(),
                        success: function(data) {
                            $('#form-customer').modal('hide');
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: data
                                    .type, // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: data.messages
                            });
                            console.log(data);
                            table.ajax.reload();
                        },
                        error: function() {
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                    return false;
                }
            });
            // ... Your other code ...

            // Define the event listener outside the click event handler
            const searchInput = document.getElementById("searchInput");
            const listItems = document.querySelector(".master");

            function filterListItems() {
                const searchText = searchInput.value.toLowerCase();
                console.log(searchText);
                listItems.querySelectorAll(".list-group-item").forEach(item => {
                    const itemText = item.textContent.toLowerCase();
                    if (itemText.includes(searchText)) {
                        item.classList.add("d-flex");
                    } else {
                        item.classList.remove("d-flex");
                        item.style.display = "none";
                    }
                });
            }

            // Attach the input event listener to the searchInput element
            searchInput.addEventListener("input", filterListItems);
            $(".buttonWaroeng").on('click', function() {
                $('[name="action"]').val('copy');
                var id = $(this).attr('value');
                $("#myModalLabel2").html('Tambah customer Ke Waroeng');
                $("#form-customer-wrg").modal('show');
            });

            function loadWaroengData() {
                var wr_id = $('#m_w_id').val();

                $.get("/inventori/customer/cari_waroeng", {
                    w_id: wr_id
                }, function(data) {
                    $('.master').empty(); // Clear the existing content
                    $.each(data.master, function(key, value) {
                        var listItem = $('<a>', {
                            class: "list-group-item list-group-item-action d-flex justify-content-between align-items-center",
                            "data-id": value.value
                        });
                        var text = value.text;
                        var icon = $('<i>', {
                            class: "fa fa-arrow-right fa-fw"
                        }); // Right arrow icon
                        listItem.text(text);
                        listItem.append(icon);
                        $('.master').append(listItem);
                    });

                    // Destroy the existing DataTable and reinitialize it with new data
                    if ($.fn.DataTable.isDataTable('#tb_waroeng')) {
                        $('#tb_waroeng').DataTable().destroy();
                    }

                    $('#tb_waroeng').DataTable({
                        "orderCellsTop": true,
                        "processing": true,
                        "autoWidth": true,
                        "lengthMenu": [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ],
                        "pageLength": -1,
                        "data": data.list, // Use the converted data
                        "columns": [{
                                data: function(row, type, val, meta) {
                                    if (type === 'display') {
                                        return meta.row +
                                        1; // Calculate the sequence number
                                    }
                                    return meta
                                    .row; // Use the row index for sorting, filtering, etc.
                                },
                            },
                            {
                                data: 'm_customer_nama'
                            },
                            {
                                data: 'm_customer_saldo_awal'
                            },
                        ]
                    });
                });
            }



            $('.cari-waroeng').on('click', function() {
                loadWaroengData();
            });
            $(document).on('click', '.list-group-item-action', function() {
                var nama = $(this).text();
                var customer_id = $(this).data('id');
                var saldo =
                    "<input type='hidden' name='m_customer_id[]' value=" + customer_id + ">" +
                    "<input class='form-control number' type='text' name='m_customer_saldo_awal[]'>";
                var newRowData = {
                    'm_customer_nama': nama,
                    'm_customer_saldo_awal': saldo
                };

                $('#tb_waroeng').DataTable().row.add(newRowData).draw();
            });
            $('#formAction2').submit(function(e) {
                if (!e.isDefaultPrevented()) {
                    var m_w_id = $('#m_w_id').val();
                    $('#form-customer-wrg form').append('<input type="hidden" name="m_w_id" value="' +
                        m_w_id + '">');
                    $.ajax({
                        url: "{{ route('customer.action') }}",
                        type: "POST",
                        data: $('#form-customer-wrg form').serialize(),
                        success: function(data) {
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: data
                                    .type, // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-info me-5', // Icon class
                                message: data.messages
                            });
                            loadWaroengData();
                        },
                        error: function() {
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                    return false;
                }
            });


        });
    </script>
@endsection
