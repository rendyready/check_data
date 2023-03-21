@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Detail Harga {{ucwords($m_t_t_name)}}
          </div>
          <div class="block-content text-muted">
            <a class="btn btn-success mr-5 mb-5 buttonInsert" value="" title="Edit" style="color: #fff"><i class="fa fa-plus mr-5"></i> Harga</a>
            @csrf
            <table id="my_table" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>Produk</th>
                  <th>Harga</th>
                  <th>Status</th>
                  <th>Pajak</th>
                  <th>Service</th>
                  <th>AKSI</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr>
                      <td>{{$item->m_menu_harga_id}}</td>
                      <td>{{$item->m_produk_nama}}</td>
                      <td>{{$item->m_menu_harga_nominal}}</td>
                      @php
                          $statusHarga = "Aktif";
                          $statusPajak = "Aktif";
                          $statusService = "Aktif";
                          if ($item->m_menu_harga_status == 0) {
                            $statusHarga = "Non Aktif";
                          }
                          if ($item->m_menu_harga_tax_status == 0) {
                            $statusPajak = "Non Aktif";
                          }
                          if ($item->m_menu_harga_sc_status == 0) {
                            $statusService = "Non Aktif";
                          }
                      @endphp
                      <td>{{$statusHarga}}</td>
                      <td>{{$statusPajak}}</td>
                      <td>{{$statusService}}</td>
                      <td> <a class="btn btn-info buttonEdit" value="{{$item->m_menu_harga_id}}" title="Edit"><i class="fa fa-edit"></i></a>
                        <a href="{{route('hapus.m_produk_relasi',$item->m_menu_harga_id)}}" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></a>
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
                <input name="m_menu_harga_id" type="hidden" id="m_menu_harga_id">
                <input name="m_menu_harga_m_jenis_nota_id" type="hidden" id="m_menu_harga_m_jenis_nota_id" value="{{$m_menu_harga_m_jenis_nota_id}}">
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_menu_harga_m_produk_id">Produk</label>
                  <div>
                      <select class="js-select2" id="m_menu_harga_m_produk_id" name="m_menu_harga_m_produk_id" style="width: 100%;" data-container="#modal-block-select2" data-placeholder="Choose one..">
                          <option></option>
                          @foreach ($listProduk as $pr)
                              <option value="{{$pr->m_produk_id}}">{{ ucwords($pr->m_produk_nama)}}</option>
                          @endforeach
                      </select>
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_menu_harga_nominal">Harga</label>
                  <div>
                    <input type="number" id="m_menu_harga_nominal" name="m_menu_harga_nominal" class="form-control">
                  </div>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_menu_harga_status">Status Harga</label>
                  <div>
                      <select class="js-select2" id="m_menu_harga_status" name="m_menu_harga_status" style="width: 100%;" data-container="#modal-block-select2" data-placeholder="Choose one..">
                          <option></option>
                          <option value="1">Aktif</option>
                          <option value="0">Non Aktif</option>
                      </select>
                  </div>
              </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_menu_harga_tax_status">Status Pajak</label>
                  <div>
                      <select class="js-select2" id="m_menu_harga_tax_status" name="m_menu_harga_tax_status" style="width: 100%;" data-container="#modal-block-select2" data-placeholder="Choose one..">
                          <option></option>
                          <option value="1">Aktif</option>
                          <option value="0">Non Aktif</option>
                      </select>
                  </div>
              </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <label for="m_menu_harga_sc_status">Status Service</label>
                  <div>
                      <select class="js-select2" id="m_menu_harga_sc_status" name="m_menu_harga_sc_status" style="width: 100%;" data-container="#modal-block-select2" data-placeholder="Choose one..">
                          <option></option>
                          <option value="1">Aktif</option>
                          <option value="0">Non Aktif</option>
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
            $("#myModalLabel").html('Tambah Harga');
            $("#m_menu_harga_id").val('').trigger('change');
            $("#m_menu_harga_m_produk_id").val('').trigger('change');
            $("#m_menu_harga_nominal").val('').trigger('change');
            $("#m_menu_harga_status").val('').trigger('change');
            $("#m_menu_harga_tax_status").val('').trigger('change');
            $("#m_menu_harga_sc_status").val('').trigger('change');
            $("#formAction").attr('action',"/master/m_jenis_nota/simpan_harga");
            $("#modal-block-select2").modal('show');
      });
      $(".buttonEdit").on('click', function() {
          var id = $(this).attr('value');
          $("#myModalLabel").html('Ubah Harga');
          $("#formAction").attr('action','/master/m_jenis_nota/simpan_harga');
          $.ajax({
              url: "/master/m_jenis_nota/show_harga/"+id,
              type: "GET",
              dataType: 'json',
              success: function(respond) {
                console.log(respond)
                  $("#m_menu_harga_id").val(respond.m_menu_harga_id).trigger('change');
                  $("#m_menu_harga_m_produk_id").val(respond.m_menu_harga_m_produk_id).trigger('change');
                  $("#m_menu_harga_nominal").val(respond.m_menu_harga_nominal).trigger('change');
                  $("#m_menu_harga_status").val(respond.m_menu_harga_status).trigger('change');
                  $("#m_menu_harga_tax_status").val(respond.m_menu_harga_tax_status).trigger('change');
                  $("#m_menu_harga_sc_status").val(respond.m_menu_harga_sc_status).trigger('change');
              },
              error: function() {
              }
          });
          $("#modal-block-select2").modal('show');
      }); 
      $("#my_table").append(
          $('<tfoot/>').append( $("#my_table thead tr").clone() )
      );
  });
  </script>
@endsection