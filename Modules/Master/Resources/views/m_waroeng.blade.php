@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Master Waroeng
                    </div>
                    <div class="block-content text-muted">
                        @csrf
                        <div class="table-responsive">
                            <table id="m_w"
                                class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAMA WAROENG</th>
                                        <th>PAJAK</th>
                                        <th>SC</th>
                                        <th>AREA</th>
                                        <th>JENIS WAROENG</th>
                                        <th>JENIS NOTA WAROENG</th>
                                        <th>MODAL TIPE</th>
                                    </tr>
                                </thead>
                                <tbody id="tablecontents">
                                    @foreach ($data as $item)
                                        <tr class="row1">
                                            <td>{{ $item->m_w_id }}</td>
                                            <td>{{ $item->m_w_nama }}</td>
                                            <td>{{ $item->m_pajak_value }}</td>
                                            <td>{{ $item->m_sc_value }}</td>
                                            <td>{{ $item->m_area_nama }}</td>
                                            <td>{{ $item->m_w_jenis_nama }}</td>
                                            <td>{{ $item->m_w_m_kode_nota }}</td>
                                            <td>{{ $item->m_modal_tipe_nama }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Select2 in a modal -->
                <div class="modal" id="form-waroeng" tabindex="-1" role="dialog" aria-labelledby="form-gudang"
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
                                    <form method="post" id="formAction">
                                        @csrf
                                        <div class="mb-4">
                                            <input type="hidden" name="action" id="action">
                                            <div class="form-group">
                                                <label for="m_w_nama">Nama Waroeg</label>
                                                <input type="text" name="m_w_nama" id="m_w_nama" required>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_m_area_id">Nama Area</label>
                                                <select class="js-select2" id="m_w_m_area_id" name="m_w_m_area_id"
                                                    style="width: 100%;" data-placeholder="Pilih Area" required>
                                                    <option></option>
                                                    @foreach ($area as $item)
                                                        <option value="{{ $item->m_area_id }}">{{ $item->m_area_nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_m_w_jenis_id">Jenis Waroeng</label>
                                                <select class="js-select2" id="m_w_m_w_jenis_id" name="m_w_m_w_jenis_id"
                                                    style="width: 100%;" data-placeholder="Pilih Jenis Waroeng" required>
                                                    <option></option>
                                                    @foreach ($waroeng_jenis as $item)
                                                        <option value="{{ $item->m_w_jenis_id }}">
                                                            {{ $item->m_w_jenis_nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_m_w_jenis_id">Jenis Waroeng</label>
                                                <select class="js-select2" id="m_w_m_w_jenis_id" name="m_w_m_w_jenis_id"
                                                    style="width: 100%;" data-placeholder="Pilih Jenis Waroeng" required>
                                                    <option></option>
                                                    @foreach ($waroeng_jenis as $item)
                                                        <option value="{{ $item->m_w_jenis_id }}">
                                                            {{ $item->m_w_jenis_nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_status">Status Waroeng</label>
                                                <select class="js-select2" id="m_w_status" name="m_w_status"
                                                    style="width: 100%;" data-placeholder="Pilih Status" required>
                                                    <option></option>
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Non Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_alamat">Alamat Waroeng</label>
                                                <textarea name="m_w_alamat" id="m_w_alamat" cols="30" rows="10" required></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_m_kode_nota">Kode Nota</label>
                                                <select class="js-select2" id="m_w_m_kode_nota" name="m_w_m_kode_nota"
                                                    style="width: 100%;" data-placeholder="Pilih Kode Nota" required>
                                                    <option></option>
                                                    <option value="nota a">Nota A</option>
                                                    <option value="nota b">Nota B</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_m_pajak_id">Pajak</label>
                                                <select class="js-select2" id="m_w_m_pajak_id" name="m_w_m_pajak_id"
                                                    style="width: 100%;" data-placeholder="Pilih Pajak" required>
                                                    <option></option>
                                                    @foreach ($pajak as $item)
                                                        <option value="{{ $item->m_pajak_id }}">
                                                            {{ $item->m_pajak_value }}</option>
                                                    @endforeach
                                                </select>
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
        </div>
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script type="module">
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': $("input[name=_token]").val()
      }
    });
    var t = $('#m_w').DataTable({
      processing: false,
      serverSide: false,
      destroy: true,
      order: [0, 'asc'],
    });
    var url = "{{route('m_waroeng.list')}}";
    var area = new Array();
    var jenisnota = new Array();
    var jenisn = new Array();
    var jenisw = new Array();
    var modaltipe = new Array();
    var pajak = new Array();
    var sc = new Array();
    $.get(url, function(response) {
      area = response['area'];
      modaltipe = response['modalt'];
      jenisw = response['jenisw'];
      jenisn = response['jenisn'];
      pajak = response['pajak'];
      sc = response['sc'];
      var data = [
        [1, 'm_w_nama'],
        [2, 'm_w_status', 'select', '{"1": "Active", "0": "Disable"}'],
        [3, 'm_w_alamat', 'textarea', '{"rows": "3", "cols": "5", "maxlength": "200", "wrap": "hard"}'],
        [4, 'm_w_m_pajak_id', 'select', JSON.stringify(pajak)],
        [5, 'm_w_m_sc_id', 'select', JSON.stringify(sc)],
        [6, 'm_w_m_area_id', 'select', JSON.stringify(area)],
        [7, 'm_w_m_w_jenis_id', 'select', JSON.stringify(jenisw)],
        [8, 'm_w_m_jenis_nota_id', 'select', JSON.stringify(jenisn)],
        [9, 'm_w_m_modal_tipe_id', 'select', JSON.stringify(modaltipe)]
      ]

      $('#m_w').Tabledit({
        url: '{{ route("action.m_waroeng") }}',
        dataType: "json",
        columns: {
          identifier: [0, 'm_w_id'],
          editable: data
        },
        restoreButton: false,
        onSuccess: function(data, textStatus, jqXHR, Messages) {
          Codebase.helpers('jq-notify', {
            align: 'right', // 'right', 'left', 'center'
            from: 'top', // 'top', 'bottom'
            type: 'danger', // 'info', 'success', 'warning', 'danger'
            icon: 'fa fa-info me-5', // Icon class
            message: data.Messages
          });
          if (data.action == 'add') {
            setTimeout(function() {
              window.location.reload();
            }, 3300);
          }
          if (data.action == 'delete') {
            $('#' + data.id).remove();
          }
        }
      });
      $("#m_w").append(
        $('<tfoot/>').append($("#m_w thead tr").clone())
      );
    });
  });
</script>
@endsection
