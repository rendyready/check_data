@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Form Input Link Akuntansi
                    </div>
                    <div class="block-content text-muted">
                        <form id="formLink">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id="linkAkuntansi"
                                        class="table table-sm table-bordered table-striped table-vcenter"
                                        style="width:100%">
                                        <thead>
                                            <th>Akuntansi</th>
                                            <th>Nama Akun</th>
                                            <th>No Rekening</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 0;
                                            @endphp
                                            @foreach ($list as $items)
                                                @php
                                                    $no++;
                                                @endphp
                                                <tr>
                                                    <td>{{ $items->m_link_akuntansi_nama }}</td>
                                                    <td id="{{ $no }}">
                                                        <select class="js-select2 form-select masterRekening text-center"
                                                            id="m_rekening_no_akun{{ $no }}"
                                                            name="m_link_akuntansi_m_rekening_id[]" style="width: 100%;">
                                                            <option
                                                                value="{{ $items->m_link_akuntansi_m_rekening_no_akun }}">
                                                                {{ $items->m_rekening_nama }}</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" id="fieldName{{ $no }}"
                                                            name="m_rekening_no_akun"
                                                            value="{{ $items->m_link_akuntansi_m_rekening_no_akun }}"
                                                            class="form-control text-center"
                                                            style="color:aliceblue; background-color: rgba(204,0,0, 0.6); "
                                                            readonly></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection

@section('js')
    <script type="module">
        $(document).ready(function() {
            Codebase.helpersOnLoad(['jq-select2']);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });

            $.ajax({
                url: '{{ route('link.list') }}',
                type: 'GET',
                dataType: 'Json',
                success: function(data) {
                    $('#linkAkuntansi').DataTable({
                        'paging': false,
                        'order': false,
                        buttons: [],
                    });
                    $('.masterRekening').append('<option></option>');
                    $.each(data, function(key, value) {
                        $('.masterRekening').append($('<option>', {
                            value: key
                        }).text(value[0]));
                    });
                }
            })

            $(document).on("change", ".masterRekening", function() {
                var id = $(this).closest('tr').index() + 1;
                var no_rekening = $('#m_rekening_no_akun' + id).val();
                $.ajax({
                    url: '{{ route('link.update') }}',
                    type: 'POST',
                    dataType: 'Json',
                    data: {
                        m_link_akuntansi_id: id,
                        m_link_akuntansi_m_rekening_id: no_rekening,
                    },
                    success: function(data) {
                        Codebase.helpers('jq-notify', {
                            align: 'right', // 'right', 'left', 'center'
                            from: 'top', // 'top', 'bottom'
                            type: data.type, // 'info', 'success', 'warning', 'danger'
                            icon: 'fa fa-info me-5', // Icon class
                            message: data.messages
                        });
                    }
                })
            })

            $('#linkAkuntansi').on('change', '.masterRekening', function(s) {
                s.preventDefault()
                let getData = $(this).val()
                var idNo = $(this).parent().attr('id')
                $.ajax({
                    url: '{{ route('link.rekening') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        data: getData
                    },
                    success: function(response) {
                        console.log(response);
                        $('#fieldName' + idNo).val(response.m_rekening_no_akun)

                    }
                });
            });

        });
    </script>
@endsection
