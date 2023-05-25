@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Hak Akses
                    </div>
                    <div class="block-content text-muted">
                        @csrf
                        <a class="btn btn-success mr-2 mb-2 buttonInsert" title="Edit" style="color: #fff"><i
                                class="fa fa-plus mr-5"></i> Tambah</a>
                        <table id="akses" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td><a id="buttonEdit" class="btn btn-sm btn-warning buttonEdit"
                                                value="{{ $item->id }}"><i class="fa fa-pencil"></i></a>
                                            <a id="buttonDetail" value="{{ $item->id }}"
                                                class="btn btn-sm btn-info buttonDetail"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                                                    <label for="name">Permission Name</label>
                                                    <div>
                                                        <input class="form-control" type="text" name="name"
                                                            id="name" style="width: 100%;" required>
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
                    <!-- END Pop Out Modal -->
                    <!-- Pop Out Modal 2 -->
                    <div class="modal fade modal-xl" id="modal-popout2" tabindex="-1" role="dialog"
                        aria-labelledby="modal-popout2" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-popout" role="document">
                            <div class="modal-content">
                                <div class="block block-themed block-rounded shadow-none mb-0">
                                    <div class="block-header block-header-default bg-pulse">
                                        <h3 class="block-title" id="myModalLabel2"></h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="block-content fs-sm">
                                        <form id="formpermission" method="post">
                                            <div class="mb-4">
                                                <input name="id2" type="hidden" id="id2">
                                                <input name="action2" type="hidden" id="action2">
                                                <div class="form-group">
                                                    <label for="name">Permission Name</label>
                                                    <div>
                                                        <input class="form-control" type="text" name="role_name"
                                                            id="role_name" style="width: 100%;" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkbox-all">
                                                    <label class="form-check-label" for="checkbox-all">All Akses</label>
                                                    <br>
                                                </div>
                                                <div class="row">
                                                    @php
                                                        $counter = 0;
                                                    @endphp
                                                    @foreach ($permision as $item)
                                                        @if ($counter % 12 === 0)
                                                </div>
                                                <div class="row">
                                                    @endif
                                                    <div class="col-6 col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-item" type="checkbox"
                                                                name="permission_id[]" value="{{ $item->id }}"
                                                                {{ $item->checked ? 'checked' : '' }}>
                                                            <label class="form-check-label">{{ $item->name }}</label>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $counter++;
                                                    @endphp
                                                    @endforeach
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
                    <!-- END Pop Out Modal 2-->
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#checkbox-all').on('change', function() {
                $('.checkbox-item').prop('checked', $(this).is(':checked'));
            });

            $('.checkbox-item').on('change', function() {
                var allChecked = $('.checkbox-item:checked').length === $('.checkbox-item').length;
                $('#checkbox-all').prop('checked', allChecked);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });

            var t = $('#akses').DataTable({
                processing: false,
                serverSide: false,
                destroy: true,
                pageLength: 10,
                order: [0, 'asc']
            });

            $(".buttonInsert").on('click', function() {
                $('#modal-popout form')[0].reset();
                $('#action').val('add');
                $("#myModalLabel").html('Tambah Hak Akses');
                $("#modal-popout").modal('show');
            });

            $(document).on('click','.buttonEdit', function() {
                var id = $(this).attr('value');
                $('#modal-popout form')[0].reset();
                $('#action').val('edit');
                $("#myModalLabel").html('Ubah Role');
                $.ajax({
                    url: "/users/akses/edit/" + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                        $("#id").val(respond.id).trigger('change');
                        $("#name").val(respond.name).trigger('change');
                    },
                    error: function() {
                        console.log("Error occurred while fetching data.");
                    }
                });
                $("#modal-popout").modal('show');
            });

            $(document).on('click', '.buttonDetail',function() {
                var detail = $(this).attr('value');
                $('#modal-popout2 form')[0].reset();
                $('#action2').val('permission_edit');
                $("#myModalLabel2").html('Ubah Permission Role');
                $.ajax({
                    url: '/users/akses/permission-edit/' + detail,
                    type: 'GET',
                    success: function(response) {
                        $('#role_name').val(response.role.name);
                        $('#id2').val(response.role.id);
                        var checkboxValues = response.permissions ||
                    []; // Initialize as empty array if undefined
                        console.log(checkboxValues);
                        var permissionIds = Array.isArray(checkboxValues) ? checkboxValues.map(
                            String) : [];

                        $('input[name="permission_id[]"]').each(function() {
                            var checkbox = $(this);
                            var permissionId = checkbox.val();

                            if (permissionIds.includes(permissionId)) {
                                checkbox.prop('checked', true);
                            } else {
                                checkbox.prop('checked', false);
                            }
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });

                $("#modal-popout2").modal('show');
            });


            $('#formAction').submit(function(e) {
                e.preventDefault(); // Prevent default form submission
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('action.akses') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        $('#modal-popout').modal('hide');
                        Codebase.helpers('jq-notify', {
                            align: 'right',
                            from: 'top',
                            type: data.type,
                            icon: 'fa fa-info me-5',
                            message: data.messages
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2500);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $('#formpermission').submit(function(e) {
                e.preventDefault(); // Prevent default form submission
                var id = $('#role_name').val();
                var action = $('#action2').val();
                var permission_val = $('input[name="permission_id[]"]:checked').map(function() {
                    return $(this).val();
                }).get();

                $.ajax({
                    url: "{{ route('action.akses') }}",
                    type: "POST",
                    data: {
                        name: id,
                        permission_id: permission_val,
                        action: action
                    },
                    success: function(data) {
                        $('#modal-popout2').modal('hide');
                        Codebase.helpers('jq-notify', {
                            align: 'right',
                            from: 'top',
                            type: data.type,
                            icon: 'fa fa-info me-5',
                            message: data.messages
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $("#akses").append($('<tfoot/>').append($("#akses thead tr").clone()));
        });
    </script>
@endsection
