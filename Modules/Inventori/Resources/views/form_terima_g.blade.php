@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            LIST TERIMA GUDANG
                    </div>
                    <div class="block-content text-muted">
                        <form id="formAction">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm"
                                            for="rekap_beli_created_by">Operator</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_beli_created_by" name="rekap_beli_created_by"
                                                value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                        <label class="col-sm-4 col-form-label-sm" for="rekap_tf_gudang_tujuan_code">CHT
                                            Gudang</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 form-control-sm" style="width: 100%;"
                                                name="rekap_tf_gudang_tujuan_code" id="rekap_tf_gudang_tujuan_code"
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
                                </div>
                                <div class="col-md-5">
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="nama_waroeng">Nama Waroeng</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="nama_waroeng"
                                                name="nama_waroeng" value="{{ $data->nama_waroeng->m_w_nama }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="tb-cht" class="table table-sm table-bordered table-striped table-vcenter">
                                    <thead>
                                        <th hidden>id</th>
                                        <th hidden>code</th>
                                        <th>Tgl Keluar</th>
                                        <th>Operator</th>
                                        <th>Gudang Asal</th>
                                        <th>Nama Barang</th>
                                        <th>Qty Keluar</th>
                                        <th>Satuan</th>
                                        <th>Qty Terima</th>
                                        <th>Satuan</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="block-content block-content-full text-end bg-transparent">
                                <input type="submit" class="btn btn-sm btn-success btn-save">
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
 $(document).ready(function(){
  Codebase.helpersOnLoad(['jq-select2','js-flatpickr']);
  var table;
  $(".number").on("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
    });
    $('#rekap_tf_gudang_tujuan_code').on('change',function() {
    var id = $(this).val()
        $(function() {
            table = $('#tb-cht').DataTable({
                buttons:[],
                destroy:true,
                paging:false,
                serverside:true,
                columnDefs: [
            {
                target: 0,
                visible: false,
                searchable: false,
            },
            {
                target: 1,
                visible: false,
            }
          ],
                ajax: {
                url: "/inventori/gudang/listtf",
                data: {gudang_id:id}, 
                type: "GET",
                    }
                });
        });
    });
    $('#formAction').submit( function(e){
                if(!e.isDefaultPrevented()){
                   table.columns([0,1]).visible(true);
                  var dataf = $('#formAction').serialize();
                    $.ajax({
                        url : "{{ route('cht_keluar_gudang.simpan') }}",
                        type : "POST",
                        data : dataf,
                        success : function(data){
                            $.notify({
                              align: 'right',       
                              from: 'top',                
                              type: 'success',               
                              icon: 'fa fa-success me-5',    
                              message: 'Berhasil Simpan'
                            });
                           window.location.reload();
                        },
                        error : function(){
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                    return false;
                }
    });
    
});
</script>
@endsection
