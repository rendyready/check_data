@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Form Input CHT Terima
          </div>
          <div class="block-content text-muted">
                <form id="formAction" action="{{route('cht.simpan')}}" method="post">
                  @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label-sm" for="rekap_beli_created_by">Operator</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_beli_created_by" name="rekap_beli_created_by" value="{{Auth::user()->name}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mb-1">
                            <label class="col-sm-5 col-form-label" for="rekap_beli_tgl">Tanggal</label>
                            <div class="col-sm-7">
                              <input type="date" class="form-control form-control-sm" value="{{$data->tgl_now}}" readonly id="rekap_beli_tgl" name="rekap_beli_tgl" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="row mb-1">
                        <label class="col-sm-5 col-form-label-sm" for="nama_waroeng">Nama Waroeng</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control form-control-sm" id="nama_waroeng" name="nama_waroeng" value="{{$data->nama_waroeng->m_w_nama}}" readonly>
                        </div>
                    </div>
                  </div>
                </div>
                <br>
                <div class="table-responsive">
                <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                    <thead>
                        <th>No</th>
                        <th>Supplier</th>
                        <th>Nama Barang</th>
                        <th>Keterangan</th>
                        <th>Qty</th>
                        <th>Hasil CHT</th>
                        <th>Satuan CHT</th>
                    </thead>
                    <tbody>
                      @php
                          $no=1;
                      @endphp
                      @foreach ($data->cht as $item)  
                      <tr>
                        <td>{{$no++}}</td>
                        <td hidden><input type="text" class="form-control form-control-sm" name="rekap_beli_detail_id[]" id="rekap_beli_detail_id" value="{{$item->rekap_beli_detail_id}}" readonly></td>
                        <td hidden><input type="text" class="form-control form-control-sm" name="rekap_beli_detail_m_produk_id[]" id="rekap_beli_detail_m_produk_id" value="{{$item->rekap_beli_detail_m_produk_id}}" readonly></td>
                        <td>{{$item->rekap_beli_supplier_nama}}</td>
                        <td ><input type="text" class="form-control form-control-sm" name="rekap_beli_detail_m_produk_nama[]" id="rekap_beli_detail_m_produk_nama" value="{{$item->rekap_beli_detail_m_produk_nama}}" readonly></td>
                        <td>{{$item->rekap_beli_detail_catatan}}</td>
                        <td>{{$item->rekap_beli_detail_qty}}</td>
                        <td><input type="number" class="form-control number form-control-sm" name="rekap_beli_detail_terima[]" id="rekap_beli_detail_terima"></td>
                        <td><input type="text" class="form-control number form-control-sm" name="rekap_beli_detail_satuan_terima[]" id="rekap_beli_detail_satuan_terima" value="{{$item->m_satuan_kode}}" readonly></td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
                <div class="block-content block-content-full text-end bg-transparent">
                    <button type="submit" class="btn btn-sm btn-success btn-save">Simpan</button>
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
 $(document).ready(function(){
  $('.js-select2').select2();
  // Codebase.helpersOnLoad(['jq-select2']);
  $(".number").on("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
    });      
});
</script>
@endsection