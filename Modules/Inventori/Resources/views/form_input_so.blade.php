@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            FORM INPUT STOK OPNAME
                    </div>
                    <div class="block-content text-muted">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label-sm" for="rekap_beli_created_by">Operator</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm"
                                            id="rekap_beli_created_by" name="rekap_beli_created_by"
                                            value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label-sm" for="example-hf-text">Waroeng</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="rph_code">
                                        <input type="text" class="form-control form-control-sm" id="rekap_beli_waroeng"
                                            name="rekap_beli_waroeng" value="{{ ucwords($data->waroeng_nama->m_w_nama) }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-1">
                                    <label class="col-sm-4 col-form-label-sm" for="example-hf-text">Stok SO Gudang</label>
                                    <div class="col-sm-8">
                                        <select class="js-select2 form-control-sm" style="width: 100%;"
                                            name="rekap_so_detail_m_gudang_code" id="rekap_so_detail_m_gudang_code"
                                            data-placeholder="Pilih Gudang" required>
                                            <option></option>
                                            @foreach ($data->gudang as $item)
                                                <option value="{{ $item->m_gudang_code }}">
                                                    {{ ucwords($item->m_gudang_nama) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-sm-4 col-form-label-sm" for="example-hf-text">Klasifikasi</label>
                                    <div class="col-sm-8">
                                        <select class="js-select2 form-control-sm" style="width: 100%;"
                                            name="m_stok_m_klasifikasi_produk_nama" id="m_stok_m_klasifikasi_produk_nama"
                                            data-placeholder="Pilih Klasifikasi" required>
                                            <option></option>
                                            @foreach ($data->klasifikasi as $item)
                                                <option value="{{ $item->m_klasifikasi_produk_id }}">
                                                    {{ ucwords($item->m_klasifikasi_produk_nama) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-success btn-tambah-so"><i class="fa fa-plus"></i>Tambah Stok Opname</a>
                        <table id="tb-so"
                            class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Stok Opname</th>
                                    <th>Klasifikasi</th>
                                    <th>Operator</th>
                                    <th>Jam Input</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

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
    <script type="module">
  $(document).ready(function() {
    $.ajaxSetup({
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });
      Codebase.helpersOnLoad(['jq-select2']);
      $('.btn-tambah-so').on('click',function () {
        var g_id = $('#rekap_so_detail_m_gudang_code').val()
        var kat_id = $('#m_stok_m_klasifikasi_produk_nama').val()
        window.open("/inventori/stok_so/create/"+g_id+"/"+kat_id, "_blank");
      });
      $('#rekap_so_detail_m_gudang_code,#m_stok_m_klasifikasi_produk_nama').on('change',function() {
        var g_id = $('#rekap_so_detail_m_gudang_code').val()
        var kat_id = $('#m_stok_m_klasifikasi_produk_nama').val()
        var table;
        if (g_id != '' && kat_id != '') {
            $(function() {
                table = $('#tb-so').DataTable({
                    "destroy":true,
                    "processing": true,
                    "autoWidth": true,
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "pageLength": 10,
                    "ajax": {
                        "url": "{{route('stok_so.list')}}",
                        "data": {g_id:g_id,
                                kat_id:kat_id},
                        "type": "GET"
                            }
                });
            });
        }
       
    }) 
    $(document).on('click','.detail',function () {
        var id = $(this).attr('value');
        console.log(id);
        window.open("/inventori/stok_so/detail/"+id, "_blank");
    })
  });
</script>
@endsection
