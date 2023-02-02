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
                                        @foreach($list as $items)
                                            @php
                                                $no++;
                                            @endphp
                                        <tr>
                                            <td>{{$items->list_akt_nama}}</td>
                                            <td id="{{$no}}">
                                                <select class="js-select2 form-select masterRekening text-center" id="m_rekening_no_akun{{$no}}" name="m_rekening_nama[]" style="width: 100%;">
                                                    <option>{{ $items->m_rekening_nama}}</option>
                                                    {{-- <option value="{{$items->list_akt_m_rekening_id}}">{{$items->m_rekening_nama}}</option> --}}
                                                </select>
                                            </td>
                                            <td><input type="text" id="fieldName{{$no}}" name="m_rekening_no_akun" value="{{ $items->list_akt_m_rekening_id}}" class="text-center" readonly></td>
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
        var idNo=$(this).parent().attr('id')
        $('#m_rekening_no_akun'+idNo).select2();
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        });

        // $.ajax({
        //         url: '{{route("link.tampil_isi")}}',
        //         type: 'GET',
        //         dataType: 'Json',
        //         success: function(data) {
                    // $('#linkAkuntansi').DataTable({
                    //     'paging': false,
                    //     'order': false,
                    // });
                        // $('.masterRekening').append('<option>' + data.m_rekening_no_akun + '</option>'); 
                    // $('.masterRekening').val('data.list_akt_m_rekening_id').attr('selected', true).trigger("change");   
            //     }                            

            // })
            
            $.ajax({
                url: '{{route("link.list")}}',
                type: 'GET',
                dataType: 'Json',
                success: function(data) {
                    $('#linkAkuntansi').DataTable({
                        'paging': false,
                        'order': false,
                    });
                    $('.masterRekening').append('<option></option>'); 
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
        
        $('#m_rekening_no_akun').change(function(e) {
        e.preventDefault();
        let no_rekening   = $('#fieldName').val();
            $.ajax({
                url: '{{route("link.update")}}',
                type: "PUT",
                cache: false,
                data: {
                    "list_akt_m_rekening_id": no_rekening,
                },
                success:function(response){
                    alert('berhasil update');
                },
            });
        });

    });
</script>
@endsection