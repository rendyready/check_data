@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Pengaturan Pajak
                    </div>
                    <div class="block-content text-muted">
                        @csrf
                        <table id="tampil_pajak" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Waroeng</th>
                                    <th class="text-center">Status</th>
                                    {{-- <th>No</th> --}}
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($data as $item)
                                    <tr class="row1">
                                        <td>{{ $item->m_w_id }}</td>
                                        <td>{{ $item->m_w_nama }}</td>
                                        <td>{{ ucwords($item->m_w_collect_status) }}</td>
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
            $('#tampil_pajak').Tabledit({
                url: '{{ route('action.pajak_collection') }}',
                dataType: "json",
                columns: {
                    identifier: [0, 'm_w_id'],
                    editable: [
                        [2, 'm_w_collect_status']
                    ]
                },
                restoreButton: false,
                deleteButton: false,
                addButton: false,
                onSuccess: function(data, textStatus, jqXHR) {
                    Codebase.helpers('jq-notify', {
                        align: 'right',
                        from: 'top',
                        type: data.type,
                        icon: 'fa fa-info me-5',
                        message: data.Messages
                    });
                    console.log(data.m_w_id);
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                }
            });
        });
    </script>
@endsection
