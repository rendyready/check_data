@extends('layouts.app')

@section('content')
<div class="content">
    <div class="row items-push">
        <div class="col-md-12 col-xl-12">
            <div class="block block-themed h-100 mb-0">
                <div class="block-header bg-pulse">
                    <h3 class="block-title">
                        Data Plot Produksi
                </div>
                <div class="block-content text-muted">
                    <!-- @csrf -->
                    {{csrf_field()}}
                    <table id="tables" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Area</th>
                            </tr>
                        </thead>
                        <tbody id="tableContents">
                            @foreach ($data as $items)
                            <tr>
                                <td>{{$items->m_plot_produksi_id}}</td>
                                <td>{{$items->m_plot_produksi_nama}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

{{-- <script type="module" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
<script type="module">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        });
        var t = $('#tables').DataTable();

        $('#tables').Tabledit({
            method: 'POST',
            contentType: 'application/json; charset=utf-8',
            url: '{{ route("plot-produksi.action") }}',
            dataType: "json",
            columns: {
                identifier: [0, 'm_plot_produksi_id'],
                editable: [
                    [1, 'm_plot_produksi_nama']
                ]
            },
            restoreButton: false,
            onSuccess: function(data, textStatus, jqXHR) {
                if (data.action == 'add') {
                    window.location.reload();
                }
                if (data.action == 'delete') {
                    $('{{route("plot-produksi.action")}}' + data.id).remove();
                }
            }
        });
        $("#tables").append(
            $('<tfoot/>').append($("#tables thead tr").clone())
        );
    });
</script>
@endsection