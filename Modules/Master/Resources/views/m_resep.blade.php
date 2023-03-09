@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Data Resep
                    </div>
                    <div class="block-content text-muted">
                        <a class="btn btn-success buttonInsert" value="{m_resep_id}"><i class="fa fa-plus"></i> Tambah</a>
                        <table id="m_resep" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>PRODUK NAMA</th>
                                    <th>STATUS RESEP</th>
                                    <th>KETERANGAN</th>
                                    <th>TANGGAL RILIS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @foreach ($data->resep as $item)
                                    <tr>
                                        <td>{{ $item->m_resep_code }}</td>
                                        <td>{{ ucwords($item->m_resep_m_produk_nama) }}</td>
                                        <td>
                                            @if ($item->m_resep_status == '0')
                                                <span class="badge rounded-pill bg-danger">Non Aktif</span>
                                            @else
                                                <span class="badge rounded-pill bg-success">Aktif</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->m_resep_keterangan }}</td>
                                        <td>{{ $item->m_resep_created_at }}</td>
                                        <td> <a class="btn btn-info btn-sm buttonEdit" value="{{ $item->m_resep_code }}"
                                                title="Edit"><i class="fa fa-edit"></i></a>
                                            <a class="btn btn-warning btn-sm buttonDetail" value="{{ $item->m_resep_code }}"
                                                title="Detail"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Resep -->
        <div class="modal" id="modal-block-select2" tabindex="-1" role="dialog" aria-labelledby="modal-block-select2"
            aria-hidden="true">
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
                                <input name="m_resep_id" type="hidden" id="m_resep_id">
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_resep_m_produk_id">Produk Menu</label>
                                        <div>
                                            <select class="js-select2" id="m_resep_m_produk_code"
                                                name="m_resep_m_produk_code" style="width: 100%;"
                                                data-container="#modal-block-select2" data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($data->produk as $item)
                                                    <option value="{{ $item->m_produk_code }}">
                                                        {{ ucwords($item->m_produk_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_resep_status">Status Resep</label>
                                        <div class="space-x-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="m_resep_status1"
                                                    name="m_resep_status" value="1" checked="">
                                                <label class="form-check-label" for="m_resep_status">Aktif</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="m_resep_status2"
                                                    name="m_resep_status" value="0">
                                                <label class="form-check-label" for="m_resep_status">Non Aktif</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_resep_keterangan">Keterangan</label>
                                        <div>
                                            <textarea name="m_resep_keterangan" id="m_resep_keterangan" cols="50" rows="5"></textarea>
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
        <!-- END Modal Resep -->
        <!-- Modal Detail Resep -->
        <div class="modal modal-xl" id="modal-block-select2-detail" tabindex="-1" role="dialog"
            aria-labelledby="modal-block-select2-detail" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="block block-themed shadow-none mb-0">
                        <div class="block-header block-header-default bg-pulse">
                            <h3 class="block-title" id="myModalLabel2"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option close" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <form action="formResep" id="formResep">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_resep_detail_bb_code">Pilih Bahan Baku</label>
                                                <input type="hidden" name="action" id="action">
                                                <select class="js-select2" id="m_resep_detail_bb_code"
                                                    name="m_resep_detail_bb_code" style="width: 100%;"
                                                    data-placeholder="Pilih Bahan Baku" required>
                                                    <option></option>
                                                    @foreach ($data->bb as $item)
                                                        <option value="{{ $item->m_produk_code }}">
                                                            {{ ucwords($item->m_produk_nama) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_resep_detail_bb_qty">Qty</label>
                                                <input class="form-group number form-control" style="width: 100%;"
                                                    type="text" name="m_resep_detail_bb_qty"
                                                    id="m_resep_detail_bb_qty" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <input type="hidden" name="m_resep_detail_m_satuan_id"
                                                    id="m_resep_detail_m_satuan_id">
                                                <label for="m_resep_detail_satuan">Satuan</label>
                                                <input class="form-group form-control" style="width: 100%;"
                                                    type="text" name="m_resep_detail_satuan"
                                                    id="m_resep_detail_satuan" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_resep_detail_ket">Keterangan</label>
                                                <textarea name="m_resep_detail_ket" id="m_resep_detail_ket" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-success btn-tambah">Tambah</button>
                            </form>
                            <div class="table-responsive">
                                <table id="m_resep_detail_tb"
                                    class="table table-sm m_resep_detail_tb table-bordered table-striped table-vcenter js-dataTable-full">
                                    <thead>
                                        <th>ID</th>
                                        <th>No</th>
                                        <th>NAMA BAHAN BAKU</th>
                                        <th>JUMLAH</th>
                                        <th>SATUAN</th>
                                        <th>KETERANGAN</th>
                                    </thead>
                                    <tbody id="detail_resep">
                                    </tbody>
                                </table>
                            </div>
                            <div class="block-content block-content-full text-end bg-transparent">
                                <button type="button" class="btn btn-sm btn-alt-secondary me-1 close"
                                    data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal Detail Resep -->
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script type="module">
  var table;
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': $("input[name=_token]").val()
      }
    });
    var t = $('#m_resep').DataTable();

    $("#m_resep").append(
      $('<tfoot/>').append($("#m_resep thead tr").clone())
    );

    $('.js-select2').select2({dropdownParent:'#modal-block-select2-detail',dropdownAutoWidth: true})
    $(".buttonInsert").on('click', function() {
      var id = $(this.m_resep_id).attr('value');
      $("#myModalLabel").html('Tambah Resep');
      $("#formAction").attr('action', "/master/m_resep/simpan");
      $("#modal-block-select2").modal('show');
    });
    $(".buttonEdit").on('click', function() {
      var id = $(this).attr('value');
      $("#myModalLabel").html('Ubah Keterangan');
      $("#formAction").attr('action', '/master/m_resep/edit');
      $.ajax({
        url: "/master/m_resep/list/" + id,
        type: "GET",
        dataType: 'json',
        success: function(respond) {
          $("#id").val(respond.m_resep_code).trigger('change');
          $("#m_resep_m_produk_code").val(respond.m_resep_m_produk_code).trigger('change');
          $("#m_resep_keterangan").val(respond.m_resep_keterangan).trigger('change');
          $("input[name='m_resep_status']").val(respond.m_resep_status).prop("checked", true);
        },
        error: function() {}
      });
      $("#modal-block-select2").modal('show');
    });
    var table,detail_id;
    $(".buttonDetail").on('click', function() {
        detail_id = $(this).attr('value');
      $("#myModalLabel2").html('Detail Resep');
     $(function() {
            table = $('#m_resep_detail_tb').DataTable({
            "destroy":true,
            "orderCellsTop": true,
            "processing": true,
            "autoWidth": true,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "pageLength": 10,
            "ajax": {
                "url": "/master/m_resep/detail/" + detail_id,
                "type": "GET"
                    }
                });
        });
      $("#modal-block-select2-detail").modal('show');
      $(document).on('select2:open', '.js-select2', function(){
          console.log("Saving value " + $(this).val());
          var index = $(this).attr('detail_id'); 
          console.log(index);
          $(this).data('val', $(this).val());
          $(this).data('detail_id',index);
      }).on('change','.js-select2', function(e){
          var prev = $(this).data('val');
          var current = $(this).val();
          var id = $(this).data('detail_id');
          console.log(id);
      var values = $('[name="m_resep_detail_bb_code"]').map(function() {
        return this.value.trim();
      }).get();
      var unique =  [...new Set(values)];
      if (values.length != unique.length) {
        e.preventDefault();
        alert('Nama Barang Sudah Digunakan Pilih Yang Lain');
         $('#m_resep_detail_bb_code').val(prev).trigger('change');
      }
      });
    });
    $('#m_resep_detail_bb_code').on('change',function () {
        var id = $(this).val();
        $.get("/master/m_produk_satuan/"+id, function(data){
            $('#m_resep_detail_satuan').val(data.m_satuan_kode);
            $('#m_resep_detail_m_satuan_id').val(data.m_satuan_id);
        });
      });
      $(".btn-tambah").on('click', function() {
            $('[name="action"]').val('add');

      });
    $('#formResep').submit(function(e){
                if(!e.isDefaultPrevented()){
                    $.ajax({
                        url : '/master/m_resep/action/' + detail_id,
                        type : "POST",
                        data : $('#modal-block-select2-detail form').serialize(),
                        success : function(data){
                            Codebase.helpers('jq-notify', {
                              align: 'right', // 'right', 'left', 'center'
                              from: 'top', // 'top', 'bottom'
                              type: data.type, // 'info', 'success', 'warning', 'danger'
                              icon: 'fa fa-info me-5', // Icon class
                              message: data.messages,
                              onShow: function() {
                                var modal = $('#formResep');
                                var notify = $('.jq-notification');
                                notify.css('top', modal.offset().top - notify.outerHeight() - 10);
                            }
                            });
                            table.ajax.reload();
                            $('.js-select2').val(null).trigger('change');
                            $('#formResep')[0].reset();
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
