@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Detail Harga {{ ucwords($m_t_t_name) }}
                    </div>
                    <div class="block-content text-muted">
                        {{-- <a class="btn btn-success mr-5 mb-5 buttonInsert" value="" title="Edit" style="color: #fff"><i
                                class="fa fa-plus mr-5"></i> Harga</a> --}}
                        @csrf
                        <div id="tabpane" class="block block-rounded overflow-hidden">
                            <ul class="nav nav-tabs nav-tabs-block nav-tabs-alt align-items-center" role="tablist">
                                @foreach ($jenis_produk as $i)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="#{{ $i->m_jenis_produk_nama }}" data-bs-toggle="tab"
                                            data-bs-target="#{{ $i->m_jenis_produk_nama }}" role="tab"
                                            aria-controls="{{ $i->m_jenis_produk_nama }}"
                                            aria-selected="false">{{ ucwords($i->m_jenis_produk_nama) }}</button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="block-content tab-content">
                                @foreach ($jenis_produk as $i)
                                    <div class="tab-pane p-20" id="{{ $i->m_jenis_produk_nama }}" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="table{{ $n++ }}"
                                                class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Produk</th>
                                                        <th>Harga</th>
                                                        <th>Status</th>
                                                        <th>Pajak</th>
                                                        <th>Service</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($data as $item)
                                                        @if ($i->m_jenis_produk_id == $item->m_produk_m_jenis_produk_id)
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $item->m_produk_nama }}</td>
                                                                <td>
                                                                    @if ($item->m_menu_harga_id == 2367 || $item->m_menu_harga_id == 8675 || $item->m_menu_harga_id == 59376)
                                                                        <input type="hidden" name="m_menu_harga_id_edit[]"
                                                                            value="{{ $item->m_menu_harga_id }}">
                                                                        <input value="{{ $item->m_menu_harga_nominal }}"
                                                                            type="text" class="form-control number"
                                                                            name="m_menu_harga_nominal_edit[]">
                                                                    @else
                                                                        <input type="hidden" name="m_menu_harga_id_edit[]"
                                                                            value="{{ $item->m_menu_harga_id }}">
                                                                        {{ rupiah($item->m_menu_harga_nominal) }}
                                                                    @endif
                                                                </td>
                                                                @php
                                                                    $statusHarga = 'Aktif';
                                                                    $statusPajak = 'Aktif';
                                                                    $statusService = 'Aktif';
                                                                    if ($item->m_menu_harga_status == 0) {
                                                                        $statusHarga = 'Non Aktif';
                                                                    }
                                                                    if ($item->m_menu_harga_tax_status == 0) {
                                                                        $statusPajak = 'Non Aktif';
                                                                    }
                                                                    if ($item->m_menu_harga_sc_status == 0) {
                                                                        $statusService = 'Non Aktif';
                                                                    }
                                                                @endphp
                                                                <td>{{ $statusHarga }}</td>
                                                                <td>{{ $statusPajak }}</td>
                                                                <td>{{ $statusService }}</td>
                                                                <td><a class="btn btn-info buttonEdit"
                                                                        value="{{ $item->m_menu_harga_id }}"
                                                                        title="Edit"><i class="fa fa-edit"></i></a></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <br>
                            <a class="btn btn-success mr-5 mb-5 updateharga" value="" title="Edit"
                                style="color: #fff"><i class="fa fa-save mr-5"></i> Hanya Update Harga</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Select2 in a modal -->
            <div class="modal" id="modal-block-select2" tabindex="-1" role="dialog" aria-labelledby="modal-block-select2"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="block block-themed shadow-none mb-0">
                            <div class="block-header block-header-default bg-pulse">
                                <h3 class="block-title" id="myModalLabel"></h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
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
                                        <input name="m_menu_harga_m_jenis_nota_id" type="hidden"
                                            id="m_menu_harga_m_jenis_nota_id" value="{{ $m_menu_harga_m_jenis_nota_id }}">
                                    </div>
                                    <div class="mb-4">
                                        <div class="form-group">
                                            <label for="m_menu_harga_m_produk_id">Produk</label>
                                            <div>
                                                <select class="js-select2" id="m_menu_harga_m_produk_id"
                                                    name="m_menu_harga_m_produk_id" style="width: 100%;"
                                                    data-container="#modal-block-select2" data-placeholder="Choose one..">
                                                    <option></option>
                                                    @foreach ($listProduk as $pr)
                                                        <option value="{{ $pr->m_produk_id }}">
                                                            {{ ucwords($pr->m_produk_nama) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="form-group">
                                            <label for="m_menu_harga_nominal">Harga</label>
                                            <div>
                                                <input type="number" id="m_menu_harga_nominal" name="m_menu_harga_nominal"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="form-group">
                                            <label for="m_menu_harga_status">Status Harga</label>
                                            <div>
                                                <select class="js-select2" id="m_menu_harga_status"
                                                    name="m_menu_harga_status" style="width: 100%;"
                                                    data-container="#modal-block-select2" data-placeholder="Choose one..">
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
                                                <select class="js-select2" id="m_menu_harga_tax_status"
                                                    name="m_menu_harga_tax_status" style="width: 100%;"
                                                    data-container="#modal-block-select2" data-placeholder="Choose one..">
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
                                                <select class="js-select2" id="m_menu_harga_sc_status"
                                                    name="m_menu_harga_sc_status" style="width: 100%;"
                                                    data-container="#modal-block-select2" data-placeholder="Choose one..">
                                                    <option></option>
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Non Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-content block-content-full text-end bg-transparent">
                                        <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                            data-bs-dismiss="modal">Close</button>
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
      $('.table').dataTable({
                    destroy: true,
                    paging: false,
                    buttons:false,
                });
      $('ul.nav-tabs').children().first().children().addClass('active');
      $('div.tab-pane').first().addClass('active');
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
      
      $(".updateharga").on('click',function () {
        $.ajax({
                type: "post",
                  url: "{{ route('m_jenis_nota.save_update_harga') }}",
                    data: $('input').serialize(),
                        success: function(data) {
                            window.location.reload();
                        }
                    });
      })
       
      $("#my_table").append(
          $('<tfoot/>').append( $("#my_table thead tr").clone() )
      );
  });
  </script>
    @endsection
