@extends('layouts.app')
@section('content')
<div class="content">
  <div class="row items-push">
    <div class="col-md-12 col-xl-12">
      <div class="block block-themed h-100 mb-0">
        <div class="block-header bg-pulse">
          <h3 class="block-title">
            Form Input Rekening
        </div>
        <div class="block block-rounded">
          <div class="block-content text-muted">
            <form id="rekeningInsert">
              <div class="row">
                <div class="col-md-5">
                  <div class="row mb-2">
                    <label id="namaWaroeng" class="col-sm-4 col-form-label" for="example-hf-text">Area Waroeng</label>
                    <div class="col-sm-8">
                      <select class="cari js-select2 form-control-sm" style="width: 100%;" name="m_rekening_m_w_id" id="m_rekening_m_w_id" data-placeholder="pilih area/waroeng">
                        @foreach($mw as $data)
                        <option value="{{($data -> m_w_id)}}"> {{($data ->m_w_nama)}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label id="categoryAccount" class="col-sm-4 col-form-label" for="example-hf-text">Kategori Akun</label>
                    <div class="col-sm-8">
                      <select class="cari js-select2 form-control-sm " style="width: 100%;" name="m_rekening_kategori" id="m_rekening_kategori" data-placeholder="pilih kategori akun">
                        <option value="aktiva lancar">Aktiva Lancar</option>
                        <option value="aktiva tetap">Aktiva Tetap</option>
                        <option value="modal">Modal</option>
                        <option value="kewajiban jangka panjang">Kewajiban Jangka Panjang</option>
                        <option value="pendapatan operasional">Pendapatan Operasional </option>
                        <option value="pendapatan non operasional">Pendapatan Non Operasional </option>
                        <option value="biaya usaha">Biaya Usaha</option>
                        <option value="biaya non usaha">Biaya Non Usaha</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                    <thead>
                      <th>No Akun</th>
                      <th>Nama Akun</th>
                      <th>Saldo</th>
                      <th><button type="button" class="btn tambah btn-success">Add</button></th>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="text" step="" class="form-control set form-control-sm" name="m_rekening_no_akun[]" id="m_rekening_no_akun" required></td>
                        <td><input type="text" class="form-control set form-control-sm" name="m_rekening_nama[]" id="m_rekening_nama" required></td>
                        <td><input type="number" class="form-control set form-control-sm" name="m_rekening_saldo[]" id="m_rekening_saldo" required></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <th>No Akun</th>
                      <th>Nama Akun</th>
                      <th>Saldo</th>
                      <th><button type="button" class="btn tambah btn-success">Add</button></th>
                    </tfoot>
                  </table>
                  <div class="block-content block-content-full text-end bg-transparent">
                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="content">
  <div class="row items-push">
    <div class="col-md-12 col-xl-12">
      <div class="block block-themed h-100 mb-0">
        <div class="block-header bg-pulse">
          <h3 class="block-title">
            Source From Data Input
        </div>
        <div class="block block-rounded">
          <div class="block-content text-mute">
            <div class="table-responsive">
              <table id="dataSourceProcess" class="table table-sm table-bordered table-striped table-vcenter">
                <thead>
                  <th>Kategori</th>
                  <th>No Akun</th>
                  <th>Nama Akun</th>
                  <th>Saldo</th>
                </thead>
                <tbody id="dataReload">
                </tbody>
                <tfoot>
                  <th>Kaategori</th>
                  <th>No Akun</th>
                  <th>Nama Akun</th>
                  <th>Saldo</th>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script type="module">
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': $("input[name=_token]").val()
      },
    });

    Codebase.helpersOnLoad(['jq-select2']);
    var no = 1;
    $('.tambah').on('click', function() {
      no++;
      $('#form').append('<tr class="hapus" id="row' + no + '">' +
        '<td><input type="text" class="form-control form-control-sm" name="m_rekening_no_akun[]" id="m_rekening_no_akun" required></td>' +
        '<td><input type="text" class="form-control form-control-sm" name="m_rekening_nama[]" id="m_rekening_nama" required></td>' +
        '<td><input type="number" class="form-control form-control-sm" name="m_rekening_saldo[]" id="m_rekening_saldo" required></td>' +
        '<td><button type="button" id="' + no + '" class="btn btn-danger btn_remove">Hapus</button></td></tr>');
    });
    var mwId = $('#m_rekening_m_w_id').val();
    var rekKat = $('#m_rekening_kategori').val();
    $('#dataSourceProcess').DataTable({
              buttons:[],
              destroy:true,
              ajax: {
                url: '{{route("rekening.list")}}',
                data: {
                  m_rekening_m_w_id: mwId,
                  m_rekening_kategori: rekKat,
                    },
                type: "GET",
                },
                columns: [
            { data: 'm_rekening_kategori' },
            { data: 'm_rekening_nama' },
            { data: 'm_rekening_no_akun' },
            { data: 'm_rekening_saldo' },
              ],
            });
    $('#rekeningInsert').submit(function(e) {
      if (!e.isDefaultPrevented()) {
        $.ajax({
          url: "{{ route('rekening.store') }}",
          type: "POST",
          data: $('form').serialize(),
          success: function(data) {
            Codebase.helpers('jq-notify', {
                            align: 'right', // 'right', 'left', 'center'
                            from: 'top', // 'top', 'bottom'
                            type: data.type, // 'info', 'success', 'warning', 'danger'
                            icon: 'fa fa-info me-5', // Icon class
                            message: data.message
                            });
            $('.hapus').remove();
            $('.set').val('');
            var mwId2 = $('#m_rekening_m_w_id').val();
            var rekKat2 = $('#m_rekening_kategori').val();
            $('#dataSourceProcess').DataTable({
              buttons:[],
              destroy:true,
              ajax: {
                url: '{{route("rekening.list")}}',
                data: {
                  m_rekening_m_w_id: mwId2,
                  m_rekening_kategori: rekKat2,
                    },
                type: "GET",
                },
                columns: [
            { data: 'm_rekening_kategori' },
            { data: 'm_rekening_nama' },
            { data: 'm_rekening_no_akun' },
            { data: 'm_rekening_saldo' },
              ],
            });
          },
          error: function() {
            alert("Tidak dapat menyimpan data!");
          }
        });
        return false;
      }
    });
    $(document).on('click', '.btn_remove', function() {
      var button_id = $(this).attr("id");
      $('#row' + button_id + '').remove();
    });

    $('.cari').on('change', function() {
      var mwId = $('#m_rekening_m_w_id').val();
      var rekKat = $('#m_rekening_kategori').val();
      $('#dataSourceProcess').DataTable({
              buttons:[],
              destroy:true,
              ajax: {
                url: '{{route("rekening.list")}}',
                data: {
                  m_rekening_m_w_id: mwId,
                  m_rekening_kategori: rekKat,
                    },
                type: "GET",
                },
                columns: [
            { data: 'm_rekening_kategori' },
            { data: 'm_rekening_nama' },
            { data: 'm_rekening_no_akun' },
            { data: 'm_rekening_saldo' },
              ],
            });
    });
  });
</script>
@endsection