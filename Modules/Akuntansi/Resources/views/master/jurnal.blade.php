@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
        <div class="col-md-12 col-xl-12">
            <div class="block block-themed h-100 mb-0">
                <div class="block-header bg-pulse">
                    <h3 class="block-title">
                        Draft List Jurnal
                </div>
                <div class="block-content text-muted">
                    <form id="formLink">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table id="jurnalAkuntansi" class="table table-sm table-bordered table-striped table-vcenter" style="width:100%">
                                    <thead>
                                        <th>No</th>
                                        <th>Akuntansi</th>
                                        <th>No Rekening</th>
                                        <th>Nama Akun</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Sekedar Nama</td>
                                            <td>
                                                <select class="js-select2 js-states form-select " id="#" name="#" style="width: 100%;">
                                                    <option value=""></option>
                                                    <option value="">Value</option>
                                                    <option value="">Value</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="js-select2 js-states form-select " id="#" name="#" style="width: 100%;">
                                                    <option value=""></option>
                                                    <option value="">Value</option>
                                                    <option value="">Value</option>
                                                </select>
                                            </td>
                                        </tr>
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
@endsection
@section('js')
<!-- js -->
<script type="module">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        });
        $('#jurnalAkuntansi').DataTable({
            'paging': 10,
            'cache': false
        })
    })
</script>




@endsection