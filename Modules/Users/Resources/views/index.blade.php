@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Users
                    </div>
                    <div class="block-content text-muted">
                        <!-- Pop Out Modal -->
                        <div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-popout" role="document">
                                <div class="modal-content">
                                    <div class="block block-themed block-rounded shadow-none mb-0">
                                        <div class="block-header block-header-default bg-pulse">
                                            <h3 class="block-title" id="myModalLabel"></h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content fs-sm">
                                            <form id="formAction" method="post">
                                                <div class="mb-4">
                                                    <input name="id" type="hidden" id="id">
                                                    <input name="action" type="hidden" id="action">
                                                    <div class="form-group">
                                                        <label for="name">Nama User</label>
                                                        <div>
                                                            <input class="form-control" type="text" name="name"
                                                                id="name" style="width: 100%;" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="form-group">
                                                        <label for="email">Email User</label>
                                                        <div>
                                                            <input class="form-control" type="email" name="email"
                                                                id="email" style="width: 100%;" required
                                                                placeholder="Masukan Email" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="form-group">
                                                        <label for="password">Password User</label>
                                                        <div>
                                                            <input class="form-control" type="password" name="password"
                                                                id="password" style="width: 100%;" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="form-group">
                                                        <label for="roles">Hak Akses</label>
                                                        <div>
                                                            <select class="js-select2" id="roles" name="roles[]"
                                                                style="width: 100%;" data-container="#modal-popout"
                                                                data-placeholder="Pilih Hak Akses" multiple required>
                                                                <option></option>
                                                                @foreach ($data->roles as $item)
                                                                    <option value="{{ $item->name }}">{{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="form-group">
                                                        <label for="waroeng_id">Wilayah Kerja</label>
                                                        <div>
                                                            <select class="js-select2" id="waroeng_id" name="waroeng_id"
                                                                style="width: 100%;" data-container="#modal-popout"
                                                                data-placeholder="Choose one.." required>
                                                                <option></option>
                                                                @foreach ($data->waroeng as $item)
                                                                    <option value="{{ $item->m_w_id }}">
                                                                        {{ $item->m_w_nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="form-group">
                                                        <label for="waroeng_id">Waroeng Akses</label>
                                                        <div>
                                                            <select class="js-select2" id="waroeng_akses"
                                                                name="waroeng_akses[]" style="width: 100%;"
                                                                data-container="#modal-popout"
                                                                data-placeholder="Pilih Waroeng" multiple="multiple"
                                                                required>
                                                                @foreach ($data->waroeng as $item)
                                                                    <option value="{{ $item->m_w_id }}">
                                                                        {{ $item->m_w_nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="block-content block-content-full text-end bg-body">
                                            <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-sm btn-danger reset">Reset
                                                Password</button>
                                            <input type="submit" class="btn btn-success" id="submit">
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Pop Out Modal -->
                        <a class="btn btn-success mr-2 mb-2 buttonInsert" title="Edit" style="color: #fff"><i
                                class="fa fa-plus mr-5"></i> User</a>
                        @csrf
                        <table id="user" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NAMA USER</th>
                                    <th>EMAIL</th>
                                    <th>WAROENG</th>
                                    <th>HAK AKSES</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data->users as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->m_w_nama }}</td>
                                        <td>{{ $item->rolename }}</td>
                                        <td><a id="buttonEdit" class="btn btn-sm btn-warning buttonEdit"
                                                value="{{ $item->users_id }}"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
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
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });
            Codebase.helpersOnLoad(['jq-select2']);
            var t = $('#user').DataTable({
                processing: false,
                serverSide: false,
                destroy: true,
                pageLength: 10,
                order: [0, 'asc']} );
            $("#user").append(
                $('<tfoot/>').append($("#user thead tr").clone())
            );
            var id;
            $(".buttonInsert").on('click', function() {
                $('#modal-popout form')[0].reset();
                $('#action').val('add');
                $("#myModalLabel").html('Tambah User');
                $("#modal-popout").modal('show');
                $("#password").attr('required', true);
            });
            $(".buttonEdit").on('click', function() {
                id = $(this).attr('value');
                $('#modal-popout form')[0].reset();
                $('#action').val('edit');
                $("#myModalLabel").html('Ubah User');
                $('#password').attr('placeholder', 'Masukan Password Untuk Merubah').attr('required',
                    false);
                $.ajax({
                    url: "/users/edit/" + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                        console.log(respond);
                        $("#id").val(respond.id).trigger('change');
                        $("#name").val(respond.name).trigger('change');
                        $("#email").val(respond.email).trigger('change');
                        $("#roles").val(respond.roles).trigger('change');
                        $("#waroeng_id").val(respond.waroeng_id).trigger('change');
                        var waroeng_akses = respond.waroeng_akses.slice(1, -1).split(", ")
                            .map(function(item) {
                                return parseInt(item);
                            });
                        console.log(waroeng_akses);
                        $("#waroeng_akses").val(waroeng_akses).trigger('change');
                    },
                    error: function() {}
                });
                $("#modal-popout").modal('show');
            });
            $('.reset').on('click', function() {
                $.ajax({
                    url: "/users/reset/" + id,
                    type: "post",
                    dataType: 'json',
                    success: function(respond) {
                        $("#modal-popout").modal('hide');
                        Codebase.helpers('jq-notify', {
                            align: 'right',
                            from: 'top',
                            type: 'success',
                            icon: 'fa fa-info me-5',
                            message: 'Berhasil Reset Password',
                        });
                    },
                    error: function() {}
                });
            });
            $('#formAction').submit(function(e) {
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: "{{ route('users.action') }}",
                        type: "POST",
                        data: $('#modal-popout form').serialize(),
                        success: function(data) {
                            if (data.error == true) {
                                alert(data.message.email);
                            } else {
                                if (data.action == 'edit') {
                                    var msg = "Berhasil Mengubah User";
                                } else {
                                    var msg = "Berhasil Menambahkan User";
                                }
                                $('#modal-popout').modal('hide');
                                Codebase.helpers('jq-notify', {
                                    align: 'right',
                                    from: 'top',
                                    type: 'success',
                                    icon: 'fa fa-info me-5',
                                    message: msg
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 2500);
                            }
                        },
                    });
                    return false;
                }
            });
        });
    </script>
@endsection
