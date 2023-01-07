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
                                        <th>No</th>
                                        <th>Akuntansi</th>
                                        <th>No Rekening</th>
                                        <th>Nama Akun</th>
                                    </thead>
                                    <tbody>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        });
        $(function() {
            $('#linkAkuntansi').DataTable({
                'ajax': {
                    'url': '{{route("listIndex.index")}}',
                },
                'pageLength': 10,
            });
        });
        $('#linkAkuntansi').find('.masterRekening').append('<option value="1">test</option>');

    });
</script>
@endsection