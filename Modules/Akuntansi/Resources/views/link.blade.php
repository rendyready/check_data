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
                                <table id="linkAkuntansi" class="table table-sm table-bordered table-striped table-vcenter" style="width:100%">
                                    <thead>
                                        <th>Akuntansi</th>
                                        <th>Nama Akun</th>
                                        <th>No Rekening</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no =0;
                                        @endphp
                                        @foreach($data as $items)
                                            @php
                                                $no++;
                                            @endphp
                                        <tr>
                                            <td>{{$items->list_akt_nama}}</td>
                                            <td id="{{$no}}">
                                                <select class="js-select2 form-select masterRekening" id="m_rekening_no_akun{{$no}}" name="m_rekening_nama[]" style="width: 100%;">
                                                </select>
                                            </td>
                                            <td><input type="text" id="fieldName{{$no}}" name="m_rekening_no_akun" readonly></td>
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
        var idNo=$(this).parent().attr('id')
        $('#m_rekening_no_akun'+idNo).select2();
        Codebase.helpersOnLoad(['jq-select2']);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        });
        
       $.ajax({
            url: '{{route("link.list")}}',
            type: 'GET',
            dataType: 'Json',
            success: function(data) {
                $('#linkAkuntansi').DataTable({
                    'paging': false,
                    'order': false,
                });
                $.each(data, function(key, value) {
                    $('.masterRekening').append($('<option>', {value: key}).text(value[0]));
                });
            }
        })
        
        $('#linkAkuntansi').on('change', '.masterRekening', function(s) {
            s.preventDefault()
            let getData = $(this).val()
            var idNo=$(this).parent().attr('id')
            console.log(idNo);
            $.ajax({
                url: '{{route("link.rekening")}}',
                type: 'GET',
                dataType: 'json',
                data: {
                   data: getData
                },
                success: function(response) {

                   $('#fieldName'+idNo).val(response.m_rekening_no_akun)
                   
                }
            });
        });
    });
</script>
@endsection