@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Relasi
          </div>
          <div class="block-content text-muted">
            <a class="btn btn-success mr-5 mb-5 buttonInsert" title="Edit" style="color: #fff"><i class="fa fa-plus mr-5"></i> Relasi Menu Kategori</a>
            @csrf
            <table id="m_pajak" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>KATEGORI RELASI MENU KATEGORI</th>
                  <th>MENU RELASI MENU KATEGORI</th>
                  <th>AKSI</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data->relasi as $item)
                    <tr>
                      <td>{{$item->config_sub_jenis_produk_id}}</td>
                      <td>{{$item->m_sub_jenis_produk_nama}}</td>
                      <td>{{$item->m_produk_nama}}</td>
                      <td> <a class="btn btn-info buttonEdit" value="{{$item->config_sub_jenis_produk_id}}" title="Edit"><i class="fa fa-edit"></i></a>
                        <a href="{{route('hapus.m_produk_relasi',$item->config_sub_jenis_produk_id)}}" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></a>
                   </td>
                    </tr>
                @endforeach
              </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
      <!-- Select2 in a modal -->
  <div class="modal" id="modal-block-select2" tabindex="-1" role="dialog" aria-labelledby="modal-block-select2" aria-hidden="true">
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
          <div class="block-content">
            <!-- Select2 is initialized at the bottom of the page -->
            <form method="post" action="" id="formAction">
              @csrf
              <div class="mb-4">
                <input name="id" type="hidden" id="id">
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="config_sub_jenis_produk_m_produk_id">Nama Menu</label>
                  <div>
                      <select class="js-select2" id="config_sub_jenis_produk_m_produk_id" name="config_sub_jenis_produk_m_produk_id" style="width: 100%;" data-container="#modal-block-select2" data-placeholder="Choose one..">
                          <option></option>
                          @foreach ($data->produk as $item)
                              <option value="{{$item->m_produk_id}}">{{ $item->m_produk_nama}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="config_sub_jenis_produk_m_kategori_id">Menu Kategori</label>
                  <div>
                      <select class="js-select2" id="config_sub_jenis_produk_m_kategori_id" name="config_sub_jenis_produk_m_kategori_id" style="width: 100%;" data-container="#modal-block-select2" data-placeholder="Choose one..">
                          <option></option>
                          @foreach ($data->kategori as $item)
                              <option value="{{$item->m_sub_jenis_produk_id}}">{{ $item->m_sub_jenis_produk_nama}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              </div>
              <div class="block-content block-content-full text-end bg-transparent">
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
  $(document).ready(function(){
  
      Codebase.helpersOnLoad(['jq-select2', 'jq-rangeslider']);
      $(".buttonInsert").on('click', function() {
            var id = $(this).attr('value');
            $("#myModalLabel").html('Tambah Kategori');
            $("#formAction").attr('action',"/master/m_produk_relasi/simpan");
            $("#modal-block-select2").modal('show');
      });
      $(".buttonEdit").on('click', function() {
                var id = $(this).attr('value');
                $("#myModalLabel").html('Ubah Kategori');
                $("#formAction").attr('action','/master/m_produk_relasi/edit');
                $.ajax({
                    url: "/master/m_produk_relasi/list/"+id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                      console.log(respond)
                        $("#id").val(respond.config_sub_jenis_produk_id).trigger('change');
                        $("#config_sub_jenis_produk_m_produk_id").val(respond.config_sub_jenis_produk_m_produk_id).trigger('change');
                        $("#config_sub_jenis_produk_m_kategori_id").val(respond.config_sub_jenis_produk_m_sub_jenis_produk_id).trigger('change');
                    },
                    error: function() {
                    }
                });
                $("#modal-block-select2").modal('show');
            }); 
      $("#m_pajak").append(
          $('<tfoot/>').append( $("#m_pajak thead tr").clone() )
      );
  });
  </script>
@endsection