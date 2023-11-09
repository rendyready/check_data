@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Tipe Nota
                    </div>
                    <div class="block-content text-muted">
                        @csrf
                        <table id="m_jenis_nota" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Tipe Nota</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($data as $item)
                                    <tr class="row1">
                                        <td>{{ $item->m_tipe_nota_id }}</td>
                                        <td>{{ ucwords($item->m_tipe_nota_nama) }}</td>
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
            var t = $('#m_jenis_nota').DataTable({
                processing: false,
                serverSide: false,
                destroy: true,
                order: [0, 'asc'],
            });
            $('#m_jenis_nota').Tabledit({
                url: '{{ route('action.m_tipe_nota') }}',
                dataType: "json",
                columns: {
                    identifier: [0, 'm_tipe_nota_id'],
                    editable: [
                        [1, 'm_tipe_nota_nama']
                    ]
                },
                restoreButton: false,
                onSuccess: function(data, textStatus, jqXHR) {
                    Codebase.helpers('jq-notify', {
                        align: 'right',
                        from: 'top',
                        type: data.type,
                        icon: 'fa fa-info me-5',
                        message: data.Messages
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                    if (data.action == 'add') {
                        window.location.reload();
                    }
                    if (data.action == 'delete') {
                        $('#' + data.id).remove();
                    }
                }
            });
            $("#m_jenis_nota").append(
                $('<tfoot/>').append($("#m_jenis_nota thead tr").clone())
            );
        });
    </script>
@endsection
