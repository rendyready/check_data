@extends('layouts.app')
@section('content')
<!-- Page Content -->
<div class="content">
  <div class="row items-push">
    <div class="col-md-12 col-xl-12">
      <div class="block block-themed h-100 mb-0">
        <div class="block-header bg-pulse">
          <h3 class="block-title">
            Master Produk
        </div>
        <div class="block-content text-muted">
          <a class="btn btn-success buttonInsert"><i class="fa fa-plus"></i>Produk</a>
          @csrf
          <table id="m_w_jenis" class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
              <tr>
                <th>No.</th>
                <th>Kode Menu</th>
                <th>Nama Menu</th>
                <th>Urut Menu</th>
                <th>Status Menu</th>
                <th>Jenis Produk</th>
                <th>Klasifikasi</th>
                <th>Satuan Menu</th>
                <th>Dijual</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="tablecontents">
              @foreach ($data->produk as $item)
              <tr class="row1">
                <td>{{$item->m_produk_id}}</td>
                <td>{{$item->m_produk_code}}</td>
                <td>{{$item->m_produk_nama}}</td>
                <td>{{$item->m_produk_urut}}</td>
                <td>@if ($item->m_produk_status ==1)
                  <span class="badge rounded-pill bg-success">Aktif</span>
                  @else
                  <span class="badge rounded-pill bg-danger">Non Aktif</span>
                  @endif
                </td>
                <td>{{$item->m_jenis_produk_nama}}</td>
                <td>{{$item->m_klasifikasi_produk_nama}}</td>
                <td>{{$item->m_satuan_kode}}</td>
                <td>{{$item->m_produk_jual}}</td>
                <td><a class="btn btn-sm btn-warning buttonEdit" value="{{$item->m_produk_id}}" title="Edit"><i class="fa fa-pencil"></i></a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Select2 in a modal -->
  <div class="modal" id="form_produk" tabindex="-1" role="dialog" aria-labelledby="form_produk" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-themed shadow-none mb-0">
          <div class="block-header block-header-default bg-pulse">
            <h3 class="block-title" id="myModalLabel"></h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content fs-sm">
            <!-- Select2 is initialized at the bottom of the page -->
            <form method="post" action="" id="formAction">
              @csrf
              <div class="mb-4">
                <input type="hidden" id="m_produk_id" name="m_produk_id">
                <label class="form-label" for="m_produk_code">Produk Code</label>
                <input type="text" class="form-control" id="m_produk_code" name="m_produk_code" placeholder="Masukan code">
              </div>
              <div class="mb-4">
                <label class="form-label" for="m_produk_nama">Produk Nama</label>
                <input type="text" class="form-control" id="m_produk_nama" name="m_produk_nama" placeholder="Masukan Nama">
              </div>
              <div class="mb-4">
                <label class="form-label" for="m_produk_cr">Produk CR</label>
                <input type="text" class="form-control" id="m_produk_cr" name="m_produk_cr" placeholder="Masukan Nama CR">
              </div>
              <div class="mb-4">
                <label class="form-label" for="m_produk_urut">Produk Urut</label>
                <input type="text" class="form-control" id="m_produk_urut" name="m_produk_urut" placeholder="Masukan Urutan Produk">
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_produk_m_satuan_id">Produk Satuan</label>
                  <div>
                    <select class="js-select2" id="m_produk_m_satuan_id" name="m_produk_m_satuan_id" style="width: 100%;" data-container="#form_produk" data-placeholder="Choose one..">
                      <option></option>
                      @foreach ($data->satuan as $item)
                      <option value="{{$item->m_satuan_id}}">{{$item->m_satuan_kode}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_produk_m_jenis_produk_id">Produk Jenis</label>
                  <div>
                    <select class="js-select2" id="m_produk_m_jenis_produk_id" name="m_produk_m_jenis_produk_id" style="width: 100%;" data-container="#form_produk" data-placeholder="Choose one..">
                      <option></option>
                      @foreach ($data->jenisproduk as $item)
                      <option value="{{$item->m_jenis_produk_id}}">{{$item->m_jenis_produk_nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_produk_m_plot_produksi_id">Plot Produksi</label>
                  <div>
                    <select class="js-select2" id="m_produk_m_plot_produksi_id" name="m_produk_m_plot_produksi_id" style="width: 100%;" data-container="#form_produk" data-placeholder="Choose one..">
                      <option></option>
                      @foreach ($data->plot_produksi as $item)
                      <option value="{{$item->m_plot_produksi_id}}">{{$item->m_plot_produksi_nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_produk_m_klasifikasi_produk_id">Klasifikasi Produk</label>
                  <div>
                    <select class="js-select2" id="m_produk_m_klasifikasi_produk_id" name="m_produk_m_klasifikasi_produk_id" style="width: 100%;" data-container="#form_produk" data-placeholder="Choose one..">
                      <option></option>
                      @foreach ($data->klasifikasi as $item)
                      <option value="{{$item->m_klasifikasi_produk_id}}">{{$item->m_klasifikasi_produk_nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_produk_hpp">Jenis HPP Produk</label>
                  <div>
                    <select class="js-select2" id="m_produk_hpp" name="m_produk_hpp" style="width: 100%;" data-container="#form_produk" data-placeholder="Choose one..">
                      <option></option>
                      @foreach($data ->produk as $hpp)
                      <option value="{{$hpp->m_produk_hpp}}">{{$hpp->m_produk_hpp}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_produk_status">Produk SCP</label>
                  <div class="space-x-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_produk_scp1" name="m_produk_scp" value="Ya">
                      <label class="form-check-label" for="m_produk_scp1">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_produk_scp0" name="m_produk_scp" value="Tidak">
                      <label class="form-check-label" for="m_produk_scp0">Tidak</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_produk_status">Produk Status</label>
                  <div class="space-x-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_produk_status1" name="m_produk_status" value="1">
                      <label class="form-check-label" for="m_produk_status">Aktif</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_produk_status0" name="m_produk_status" value="0">
                      <label class="form-check-label" for="m_produk_status">Non Aktif</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_produk_status">Status Pajak</label>
                  <div class="space-x-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_produk_tax1" name="m_produk_tax" value="1">
                      <label class="form-check-label" for="m_produk_tax">Aktif</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_produk_tax0" name="m_produk_tax" value="0">
                      <label class="form-check-label" for="m_produk_tax">Non Aktif</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_produk_status">Status Service Charge</label>
                  <div class="space-x-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_produk_sc1" name="m_produk_sc" value="1">
                      <label class="form-check-label" for="m_produk_sc">Aktif</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_produk_sc0" name="m_produk_sc" value="0">
                      <label class="form-check-label" for="m_produk_sc">Non Aktif</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_produk_status">Dijual Di CR</label>
                  <div class="space-x-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_produk_jual1" name="m_produk_jual" value="Ya">
                      <label class="form-check-label" for="m_produk_jual">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="m_produk_jual0" name="m_produk_jual" value="Tidak">
                      <label class="form-check-label" for="m_produk_jual">Tidak</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="block-content block-content-full text-end bg-body">
                <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Select2 in a modal -->
</div>
<!-- END Page Content -->
@endsection
@section('js')

<script type="module">
  $(document).ready(function() {
    var t = $('#m_w_jenis').DataTable({
      processing: false,
      serverSide: false,
      destroy: true,
      order: [0, 'asc'],
    });
    Codebase.helpersOnLoad(['jq-select2']);
    $(".buttonInsert").on('click', function() {
      var id = $(this).attr('value');
      $("#myModalLabel").html('Tambah Produk');
      $("#formAction").attr('action', "/master/produk/simpan");
      $("#form_produk").modal('show');
    });
    $(".buttonEdit").on('click', function() {
      var id = $(this).attr('value');
      $("#myModalLabel").html('Ubah Produk');
      $("#formAction").attr('action', '/master/produk/edit');
      $.ajax({
        url: "/master/produk/list/" + id,
        type: "GET",
        dataType: 'json',
        success: function(respond) {
          console.log(respond)
          $("#m_produk_id").val(respond.m_produk_id).trigger('change');
          $("#m_produk_cr").val(respond.m_produk_cr).trigger('change');
          $("#m_produk_code").val(respond.m_produk_code).trigger('change');
          $("#m_produk_hpp").val(respond.m_produk_hpp).trigger('change');
          $("#m_produk_jual").val(respond.m_produk_jual).trigger('change');
          $("#m_produk_m_jenis_produk_id").val(respond.m_produk_m_jenis_produk_id).trigger('change');
          $("#m_produk_m_klasifikasi_produk_id").val(respond.m_produk_m_klasifikasi_produk_id).trigger('change');
          $("#m_produk_m_plot_produksi_id").val(respond.m_produk_m_plot_produksi_id).trigger('change');
          $("#m_produk_m_satuan_id").val(respond.m_produk_m_satuan_id).trigger('change');
          $("#m_produk_nama").val(respond.m_produk_nama).trigger('change');
          $("#m_produk_sc").val(respond.m_produk_sc).trigger('change');
          $("#m_produk_scp").val(respond.m_produk_scp).trigger('change');
          $("#m_produk_status").val(respond.m_produk_status).trigger('change');
          $("#m_produk_tax").val(respond.m_produk_tax).trigger('change');
          $("#m_produk_urut").val(respond.m_produk_urut).trigger('change');
        },
        error: function() {}
      });
      $("#form_produk").modal('show');
    });
    $("#m_w_jenis").append(
      $('<tfoot/>').append($("#m_w_jenis thead tr").clone())
    );
  });
</script>
@endsection