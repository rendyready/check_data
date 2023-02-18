@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            FORM PECAH GABUNG BARANG
                    </div>
                    <div class="block-content text-muted">
                        <form id="formAction">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm"
                                            for="rekap_pcb_created_by_name">Operator</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_pcb_created_by_name" name="rekap_pcb_created_by_name"
                                                value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="rekap_pcb_gudang_asal_id">Asal
                                            Gudang</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 form-control-sm" style="width: 100%;"
                                                name="rekap_pcb_gudang_asal_id" id="rekap_pcb_gudang_asal_id"
                                                data-placeholder="Pilih Gudang" required>
                                                <option></option>
                                                @foreach ($data->gudang as $item)
                                                    <option value="{{ $item->m_gudang_id }}">
                                                        {{ ucwords($item->m_gudang_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="rekap_pcb_aksi">Aksi
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 form-control-sm" style="width: 100%;" name="rekap_pcb_aksi"
                                                id="rekap_pcb_aksi" data-placeholder="Pilih" required>
                                                <option></option>
                                                <option value="pecah">Pecah Barang</option>
                                                <option value="gabung">Gabung Barang</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label" for="rekap_beli_tgl">Tanggal</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control form-control-sm"
                                                value="{{ $data->tgl_now }}" readonly id="rekap_beli_tgl"
                                                name="rekap_beli_tgl" required>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label-sm" for="rekap_pcb_code">No Nota</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm" id="rekap_pcb_code"
                                                name="rekap_pcb_code" value="{{ $data->code }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-1">
                                        <label class="col-sm-5 col-form-label-sm" for="nama_waroeng">Nama Waroeng</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm" id="nama_waroeng"
                                                name="nama_waroeng" value="{{ $data->nama_waroeng->m_w_nama }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="proses">BARANG YANG AKAN DIPROSES</label>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="rekap_pcb_brg_asal_id">Nama Barang</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 nama_barang form-control-sm" style="width: 100%;"
                                                name="rekap_pcb_brg_asal_id" id="rekap_pcb_brg_asal_id"
                                                data-placeholder="Pilih Barang" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="rekap_pcb_brg_asal_satuan_id">Satuan</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" id="rekap_pcb_brg_asal_satuan_id"
                                                name="rekap_pcb_brg_asal_satuan_id" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="rekap_pcb_brg_asal_isi">Isi</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" id="rekap_pcb_brg_asal_isi"
                                                name="rekap_pcb_brg_asal_isi" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="diambil">Diambil</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" id="diambil"
                                                name="diambil">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="proses">BARANG HASIL PROSES</label>
                                    <div class="row mb-1">
                                            <label class="col-sm-4 col-form-label-sm" for="nama_waroeng">Nama
                                                Barang</label>
                                            <div class="col-sm-8">
                                                <select class="js-select2 nama_barang form-control-sm"
                                                    style="width: 100%;" name="rekap_pcb_produk_proses_id"
                                                    id="rekap_pcb_produk_proses_id" data-placeholder="Pilih Barang"
                                                    required>
                                                    <option></option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="nama_waroeng">Satuan</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" id="nama_waroeng"
                                                name="nama_waroeng" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="nama_waroeng">Isi</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" id="nama_waroeng"
                                                name="nama_waroeng" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="diambil">Sisa</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" id="diambil"
                                                name="diambil" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <a class="btn btn-sm btn-success"><i class="fa fa-plus"></i>Tambah</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="tb-cht" class="table table-sm table-bordered table-striped table-vcenter">
                                    <thead>
                                        <th>Barang Proses</th>
                                        <th>Satuan</th>
                                        <th>Isi</th>
                                        <th>Qty Diambil</th>
                                        <th>-----</th>
                                        <th>Barang Hasil</th>
                                        <th>Satuan</th>
                                        <th>Isi</th>
                                        <th>Qty Hasil</th>
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
  Codebase.helpersOnLoad(['jq-select2']);
  var table,dt;
  $(".number").on("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
    });
  $('#rekap_pcb_gudang_asal_id').on('change',function() {
    var g_id = $(this).val();
    $.get("/inventori/stok/"+g_id, function(data){
            dt = data;
            $.each(data, function(key, value) {
              $('.nama_barang')
              .append($('<option>', { value : key })
              .text(value));
            });
    });
  });
  $('#rekap_pcb_brg_asal_id').on('change',function() {
    var id = $(this).val();
    var g_id = $('#rekap_pcb_brg_asal_id').val()
    $.get("/inventori/stok_harga/"+g_id+"/"+id, function(data){
           $('#rekap_pcb_brg_asal_satuan_id').val(data.m_stok_satuan)
        //    $('#').val()
    });
  });  
  $('#formAction').submit( function(e){
                if(!e.isDefaultPrevented()){
                  table.columns([1,2,3,4]).visible(true);
                  var dataf = $('#formAction').serialize();
                    $.ajax({
                        url : "{{ route('cht.simpan') }}",
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
