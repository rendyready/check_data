@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              FORM CHT BARANG DARI GUDANG
          </div>
          <div class="block-content text-muted">
                <form id="form_cht_keluar" method="post" action="{{route('gudang.terima_simpan')}}">
                  @csrf
                <div class="row">
                    <div class="col-md-5">
                        <div class="row mb-1">
                            <label class="col-sm-4 col-form-label-sm" for="rekap_beli_created_by">Operator</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="rekap_beli_created_by" name="rekap_beli_created_by" value="{{Auth::user()->name}}" readonly>
                            </div>
                            <label class="col-sm-4 col-form-label-sm" for="rekap_beli_gudang_id">No Bukti :</label>
                            <div class="col-sm-8">
                              {{$data->no_trans}}
                            </div>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row mb-1">
                            <label class="col-sm-5 col-form-label" for="rekap_beli_tgl">Tanggal</label>
                            <div class="col-sm-7">
                              <input type="date" class="form-control form-control-sm" value="{{$tgl_now}}" readonly id="rekap_beli_tgl" name="rekap_beli_tgl" required>
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
                <table id="tb-cht" class="table table-sm table-bordered table-striped table-vcenter">
                    <thead>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Qty Kirim</th>
                        <th>Satuan</th>
                        <th>Qty Terima</th>
                        <th>Satuan</th>
                    </thead>
                    <tbody>
                      @php
                          $no = 1;
                      @endphp
                     @foreach ($detail as $item)
                         <tr>
                          <td hidden><input type="hidden" name="id[]" value="{{$item->rekap_tf_g_detail_id}}"></td>
                          <td hidden><input type="hidden" name="rekap_tf_g_detail_code" value="{{$item->rekap_tf_g_detail_code}}"></td>
                          <td>{{$no++}}</td>
                          <td>{{ucwords($item->rekap_tf_g_detail_m_produk_nama)}}</td>
                          <td>{{$item->rekap_tf_g_detail_qty_kirim}}</td>
                          <td>{{ucwords($item->rekap_tf_g_detail_satuan_kirim)}}</td>
                          <td><input type="number" class="terima" name="rekap_tf_g_detail_qty_terima[]" id="rekap_tf_g_detail_qty_terima" required></td>
                          <td>{{ucwords($item->rekap_tf_g_detail_satuan_terima)}}</td>
                         </tr>
                     @endforeach
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

</script>
@endsection