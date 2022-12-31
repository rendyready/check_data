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
                      <select class="js-select2 form-control-sm namaWaroeng" style="width: 100%;" name="m_rekening_m_w_id" id="m_rekening_m_w_id" data-placeholder="pilih area/waroeng">
                        @foreach($mw as $data)
                        <option value="{{($data -> m_w_id)}}"> {{($data ->m_w_nama)}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label id="categoryAccount" class="col-sm-4 col-form-label" for="example-hf-text">Kategori Akun</label>
                    <div class="col-sm-8">
                      <select class="js-select2 form-control-sm categoryAccount" style="width: 100%;" name="m_rekening_kategori" id="m_rekening_kategori" data-placeholder="pilih kategori akun">
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
                <div class="col-md-5">
                  <div class="col-sm-4">
                    <div class="position-relative">
                      <div class="position-absolute mb-4 top-50 start-50 translate-middle-x ">
                        <button id="prosesData" type="button" class="btn btn-success">Pencarian Data</button>
                      </div>
                    </div>
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
                      <td><input type="text" step="" class="form-control form-control-sm" name="m_rekening_no_akun[]" id="m_rekening_no_akun" required></td>
                      <td><input type="text" class="form-control form-control-sm" name="m_rekening_nama[]" id="m_rekening_nama" required></td>
                      <td><input type="number" class="form-control form-control-sm" name="m_rekening_saldo[]" id="m_rekening_saldo" required></td>
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
                <tbody>
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
      $('#form').append('<tr id="row' + no + '">' +
        '<td><input type="text" class="form-control form-control-sm" name="m_rekening_no_akun[]" id="m_rekening_no_akun" required></td>' +
        '<td><input type="text" class="form-control form-control-sm" name="m_rekening_nama[]" id="m_rekening_nama" required></td>' +
        '<td><input type="number" class="form-control form-control-sm" name="m_rekening_saldo[]" id="m_rekening_saldo" required></td>' +
        '<td><button type="button" id="' + no + '" class="btn btn-danger btn_remove">Hapus</button></td></tr>');
    });
    $('#rekeningInsert').submit(function(e) {
      if (!e.isDefaultPrevented()) {
        $.ajax({
          url: "{{ route('rekening.store') }}",
          type: "POST",
          data: $('form').serialize(),
          success: function(data) {
            $.notify({
              align: 'right',
              from: 'top',
              type: 'success',
              icon: 'fa fa-success me-5',
              message: 'Berhasil Menambahkan Data'
            });
            window.location.reload();

          },
          error: function() {
            alert("Tidak dapat menyimpan data!");
          }
        });
        return false;
      }
    });

    $('#prosesData').click('.button', function() {
      console.log('codot');
      var mwId = $('#m_rekening_m_w_id').val();
      var rekKat = $('#m_rekening_kategori').val();
      console.log(mwId, rekKat);
      if (mwId == m_rekening_m_w_id && rekKat == m_rekening_kategori) {
        console.log(this);
        $('#dataSourceProcess').find('tbody', function(data) {
          console.log(this);
          $.ajax({
              type: 'GET',
              dataType: 'JSON',
              url: '{{route("resource_rekening")}}',
            }),
            append('<tr>' +
              '<td>' + data.m_rekening_kategori + '</td>' +
              '<td>' + data.m_rekening_no_akun + '</td>' +
              '<td>' + data.m_rekening_nama + '</td>' +
              '<td>' + data.m_rekening_saldo + '</td>' +
              '<tr>');
        });
        $.ajax({
          type: 'GET',
          dataType: 'JSON',
          url: '{{route("resource_rekening")}}',
          success: function(data) {

            $.each(data, function(a, item) {
              $('#dataSourceProcess').find('tbody').append(
                '<tr>' +
                '<td>' + item.m_rekening_kategori + '</td>' +
                '<td>' + item.m_rekening_no_akun + '</td>' +
                '<td>' + item.m_rekening_nama + '</td>' +
                '<td>' + item.m_rekening_saldo + '</td>' +
                '<tr>');
            });
          }
        });
      }
    });



    $(document).on('click', '.btn_remove', function() {
      var button_id = $(this).attr("id");
      $('#row' + button_id + '').remove();
    });

  });
</script>
@endsection