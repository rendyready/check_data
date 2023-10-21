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
                                            <th class="text-center">Akuntansi</th>
                                            <th class="text-center">Nama Akun</th>
                                            <th class="text-center">No Akun</th>
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
                                                            id="m_rekening_id{{ $no }}"
                                                            name="m_link_akuntansi_m_rekening_id[]" style="width: 100%;">
                                                            <option value="{{ $items->m_rekening_id }}">
                                                                {{ $items->m_rekening_nama }}</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="fieldName{{ $no }}"
                                                            name="m_rekening_code" value="{{ $items->m_rekening_code }}"
                                                            class="form-control text-center"
                                                            style="color:aliceblue; background-color: rgba(204,0,0, 0.6); "
                                                            readonly>
                                                        <input type="text" id="fieldName1{{ $no }}"
                                                            name="m_rekening_id" value="{{ $items->m_rekening_id }}"
                                                            class="form-control text-center"
                                                            style="color:aliceblue; background-color: rgba(204,0,0, 0.6); "
                                                            hidden>
                                                    </td>

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

            //tampil list akun
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

            //edit akun
            $(document).on("change", ".masterRekening", function() {
                var id = $(this).closest('tr').index() + 1;
                var no_rekening = $('#m_rekening_id' + id).val();
                console.log(id);
                console.log(no_rekening);
                $.ajax({
                    url: '{{ route('link.update') }}',
                    type: 'POST',
                    dataType: 'Json',
                    data: {
                        id: id,
                        no_rekening: no_rekening,
                    },
                    success: function(data) {
                        Codebase.helpers('jq-notify', {
                            align: 'right', // 'right', 'left', 'center'
                            from: 'top', // 'top', 'bottom'
                            type: data.type, // 'info', 'success', 'warning', 'danger'
                            icon: 'fa fa-info me-5', // Icon class
                            message: data.messages
                        });
                        $('.code_rek').css('display', 'block');
                    }
                })
            })

            //auto ganti no akun
            $('#linkAkuntansi').on('change', '.masterRekening', function(s) {
                s.preventDefault()
                let getData = $(this).val();
                var idNo = $(this).parent().attr('id')
                // console.log(getData);
                // console.log(idNo);
                $.ajax({
                    url: '{{ route('link.rekening') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        data: getData
                    },
                    success: function(response) {
                        console.log(response);
                        $('#fieldName' + idNo).val(response.m_rekening_code)

                    }
                });
            });

        });
    </script>
@endsection
