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
                                        <label class="col-sm-4 col-form-label-sm" for="rekap_pcb_gudang_asal_code">Asal
                                            Gudang</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 form-control-sm" style="width: 100%;"
                                                name="rekap_pcb_gudang_asal_code" id="rekap_pcb_gudang_asal_code"
                                                data-placeholder="Pilih Gudang" required>
                                                <option></option>
                                                @foreach ($data->gudang as $item)
                                                    <option value="{{ $item->m_gudang_code }}">
                                                        {{ ucwords($item->m_gudang_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="rekap_pcb_aksi">Aksi
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 form-control-sm" style="width: 100%;"
                                                name="rekap_pcb_aksi" id="rekap_pcb_aksi" data-placeholder="Pilih" required>
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
                                        <label class="col-sm-4 col-form-label-sm" for="rekap_pcb_brg_asal_code1">Nama
                                            Barang</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 nama_barang form-control-sm" style="width: 100%;"
                                                id="rekap_pcb_brg_asal_code1" data-placeholder="Pilih Barang" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm"
                                            for="rekap_pcb_brg_asal_satuan1">Satuan</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_pcb_brg_asal_satuan1" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="rekap_pcb_brg_asal_isi1">Isi</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_pcb_brg_asal_isi1" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm"
                                            for="rekap_pcb_brg_asal_qty1">Diambil</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control number form-control-sm"
                                                id="rekap_pcb_brg_asal_qty1">
                                            <input type="hidden" class="form-control" id="rekap_pcb_brg_asal_hppisi1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="proses">BARANG HASIL PROSES</label>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="nama_waroeng">Nama
                                            Barang</label>
                                        <div class="col-sm-8">
                                            <select class="js-select2 nama_barang form-control-sm" style="width: 100%;"
                                                id="rekap_pcb_brg_hasil_code1" data-placeholder="Pilih Barang" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm"
                                            for="rekap_pcb_brg_hasil_satuan1">Satuan</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_pcb_brg_hasil_satuan1" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm"
                                            for="rekap_pcb_brg_hasil_isi1">Isi</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm"
                                                id="rekap_pcb_brg_hasil_isi1" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="hasil">Hasil Jadi</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control number form-control-sm"
                                                id="rekap_pcb_brg_hasil_qty1">
                                        </div>
                                        <div class="col-sm-4">
                                            <a class="btn btn-sm btn-success" id="tambah"><i
                                                    class="fa fa-plus"></i>Tambah</a>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-4 col-form-label-sm" for="sisa">Masih Sisa</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" id="sisa"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="tb_pcb" class="table table-sm table-bordered table-striped table-vcenter">
                                    <thead>
                                        <th>Barang Proses</th>
                                        <th>Satuan</th>
                                        <th>Isi</th>
                                        <th>Qty</th>
                                        <th>--</th>
                                        <th>Barang Hasil</th>
                                        <th>Satuan</th>
                                        <th>Isi</th>
                                        <th>Qty</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="block-content block-content-full text-end bg-transparent">
                                <a class="btn btn-sm btn-success btn-save" id="save"><i
                                    class="fa fa-save"></i> Simpan</a>
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
  $('#rekap_pcb_gudang_asal_code').on('change',function() {
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
  $('#rekap_pcb_brg_asal_code1').on('change',function() {
    var id = $(this).val();
    var g_id = $('#rekap_pcb_gudang_asal_code').val();
    console.log(id,g_id);
    $.get("/inventori/stok_harga/"+g_id+"/"+id, function(data){
           $('#rekap_pcb_brg_asal_satuan1').val(data.m_stok_satuan);
           $('#rekap_pcb_brg_asal_isi1').val(data.m_stok_isi);
           $('#rekap_pcb_brg_asal_hppisi1').val(data.m_stok_hpp);
    });
  });
  $('#rekap_pcb_brg_hasil_code1').on('change',function() {
    var id = $(this).val();
    var g_id = $('#rekap_pcb_gudang_asal_code').val();
    console.log(id,g_id);
    $.get("/inventori/stok_harga/"+g_id+"/"+id, function(data){
           $('#rekap_pcb_brg_hasil_satuan1').val(data.m_stok_satuan);
           $('#rekap_pcb_brg_hasil_isi1').val(data.m_stok_isi);
    });
  });
  $(document).on('input','#rekap_pcb_brg_asal_qty1',function() {
    var asal_isi = $('#rekap_pcb_brg_asal_isi1').val();
    var asal_diambil = $('#rekap_pcb_brg_asal_qty1').val().replace(/\./g, '')
    $('#sisa').val(asal_diambil*asal_isi)
  });
  $(document).on('click','#tambah',function () {
    var brg_asal_code = $('#rekap_pcb_brg_asal_code1').val();
    var brg_asal_nama = $('#rekap_pcb_brg_asal_code1 option:selected').text();
    var brg_asal_isi = $('#rekap_pcb_brg_asal_isi1').val();
    var brg_asal_satuan = $('#rekap_pcb_brg_asal_satuan1').val();
    var brg_asal_qty = $('#rekap_pcb_brg_asal_qty1').val().replace(/\./g, '');
    var brg_asal_hpp= $('#rekap_pcb_brg_asal_hppisi1').val();
    var brg_hasil_code = $('#rekap_pcb_brg_hasil_code1').val();
    var brg_hasil_nama =  $('#rekap_pcb_brg_hasil_code1 option:selected').text();
    var brg_hasil_isi =   $('#rekap_pcb_brg_hasil_isi1').val();
    var brg_hasil_satuan = $('#rekap_pcb_brg_hasil_satuan1').val();
    var brg_hasil_qty = $('#rekap_pcb_brg_hasil_qty1').val().replace(/\./g, '');
    console.log(brg_asal_nama);
    $('#tb_pcb').append(
                        '<tr>'+
                        '<td hidden><input type="hidden" class="form-control" name="rekap_pcb_brg_asal_code[]" value="'+brg_asal_code+'"></td>'+
                        '<td><input type="text" style="width: auto;" class="form-control form-control-sm" name="rekap_pcb_brg_asal_nama[]" value="'+brg_asal_nama+'" readonly></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="rekap_pcb_brg_asal_satuan[]" value="'+brg_asal_satuan+'" readonly></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="rekap_pcb_brg_asal_isi[]" value="'+brg_asal_isi+'" readonly></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="rekap_pcb_brg_asal_qty[]" value="'+brg_asal_qty+'" readonly></td>'+
                        '<td hidden><input type="hidden" class="form-control form-control-sm" name="rekap_pcb_brg_asal_hppisi[]" value="'+brg_asal_hpp+'"></td>'+
                        '<td> -- </td>'+
                        '<td hidden><input type="text" class="form-control" name="rekap_pcb_brg_hasil_code[]" value="'+brg_hasil_code+'"></td>'+
                        '<td><input type="text" style="width: auto;" class="form-control form-control-sm" name="rekap_pcb_brg_hasil_nama[]" value="'+brg_hasil_nama+'" readonly></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="rekap_pcb_brg_hasil_satuan[]" value="'+brg_hasil_satuan+'" readonly></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="rekap_pcb_brg_hasil_isi[]" value="'+brg_hasil_isi+'" readonly></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="rekap_pcb_brg_hasil_qty[]" value="'+brg_hasil_qty+'" readonly></td>'+
                        '</tr>'
    );
    var sisa = $('#sisa').val();
    $('#sisa').val(sisa-brg_hasil_qty);

  })
  $(document).on('click','.btn-save', function(e){
    if ($('#sisa').val() != 0) {
        Codebase.helpers('jq-notify', {
            align: 'right', // 'right', 'left', 'center'
            from: 'top', // 'top', 'bottom'
            type: 'danger', // 'info', 'success', 'warning', 'danger'
            icon: 'fa fa-warning', // Icon class
            message: "Tidak Bisa Simpan Masih Ada Sisa !"
        });
        $('#sisa').focus();
    } else {
        if(!e.isDefaultPrevented()){
                  var dataf = $('#formAction').serialize();
                    $.ajax({
                        url : "{{route('simpan.pcb')}}",
                        type : "POST",
                        data : dataf,
                        success : function(data){
                            Codebase.helpers('jq-notify', {
                                align: 'right', // 'right', 'left', 'center'
                                from: 'top', // 'top', 'bottom'
                                type: 'danger', // 'info', 'success', 'warning', 'danger'
                                icon: 'fa fa-warning', // Icon class
                                message: "Tidak Bisa Simpan Masih Ada Sisa !"
                            });
                           window.location.reload();
                        },
                        error : function(){
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                    return false;
                }
    }
    });
});
</script>
@endsection
