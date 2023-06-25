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
                        <a class="btn btn-success mr-2 mb-2 buttonInsert" title="Edit" style="color: #fff"><i
                                class="fa fa-plus mr-5"></i> Waroeng</a>
                        @csrf
                        <div class="table-responsive">
                            <table id="m_w"
                                class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>KODE</th>
                                        <th>NAMA WAROENG</th>
                                        <th>PAJAK</th>
                                        <th>SC</th>
                                        <th>AREA</th>
                                        <th>JENIS WAROENG</th>
                                        <th>JENIS NOTA</th>
                                        <th>MODAL TIPE</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tablecontents">
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data as $item)
                                        <tr class="row1">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->m_w_code }}</td>
                                            <td>{{ ucwords($item->m_w_nama) }}</td>
                                            <td>{{ $item->m_pajak_value }}</td>
                                            <td>{{ $item->m_sc_value }}</td>
                                            <td>{{ ucwords($item->m_area_nama) }}</td>
                                            <td>{{ ucwords($item->m_w_jenis_nama) }}</td>
                                            <td>{{ ucwords($item->m_w_m_kode_nota) }}</td>
                                            <td>{{ $item->m_modal_tipe_nama }}</td>
                                            <td><a id="buttonEdit" class="btn btn-sm buttonEdit btn-success"
                                                    value="{{ $item->m_w_id }}" title="Edit"><i
                                                        class="fa fa-pencil"></i></a></td>
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
                                    <form id="formAction">
                                        @csrf
                                        <div class="mb-4">
                                            <input type="hidden" name="action" id="action">
                                            <input type="hidden" name="m_w_id" id="m_w_id">
                                            <div class="form-group">
                                                <label for="m_w_nama">Nama Waroeg</label>
                                                <input class="form-group" style="width: 100%;" type="text"
                                                    name="m_w_nama" id="m_w_nama" required>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_m_area_id">Nama Area</label>
                                                <select class="js-select2" id="m_w_m_area_id" name="m_w_m_area_id"
                                                    style="width: 100%;" data-placeholder="Pilih Area" required>
                                                    <option></option>
                                                    @foreach ($area as $item)
                                                        <option value="{{ $item->m_area_id }}">
                                                            {{ ucwords($item->m_area_nama) }}
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
                                                <textarea name="m_w_alamat" id="m_w_alamat" cols="52" rows="5" required></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_m_kode_nota">Kode Nota</label>
                                                <select class="js-select2" id="m_w_m_kode_nota" name="m_w_m_kode_nota"
                                                    style="width: 100%;" data-placeholder="Pilih Kode Nota" required>
                                                    <option></option>
                                                    @foreach ($m_tipe_nota as $item)
                                                        <option value="{{$item->m_tipe_nota_nama}}">{{$item->m_tipe_nota_nama}}</option>
                                                    @endforeach
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
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_m_sc_id">Service Charge</label>
                                                <select class="js-select2" id="m_w_m_sc_id" name="m_w_m_sc_id"
                                                    style="width: 100%;" data-placeholder="Pilih Service Charge" required>
                                                    <option></option>
                                                    @foreach ($sc as $item)
                                                        <option value="{{ $item->m_sc_id }}">
                                                            {{ $item->m_sc_value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_m_modal_tipe_id">Modal Tipe</label>
                                                <select class="js-select2" id="m_w_m_modal_tipe_id"
                                                    name="m_w_m_modal_tipe_id" style="width: 100%;"
                                                    data-placeholder="Pilih Tipe Modal" required>
                                                    <option></option>
                                                    @foreach ($modaltipe as $item)
                                                        <option value="{{ $item->m_modal_tipe_id }}">
                                                            {{ $item->m_modal_tipe_nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_currency">Currency</label>
                                                <select class="js-select2" id="m_w_currency" name="m_w_currency"
                                                    style="width: 100%;" data-placeholder="Pilih Currency" required>
                                                    <option></option>
                                                    <option value="Rp">Rp</option>
                                                    <option value="RM">RM</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_decimal">Decimal</label>
                                                <select class="js-select2" id="m_w_decimal" name="m_w_decimal"
                                                    style="width: 100%;" data-placeholder="Pilih Tipe Digit Decimal"
                                                    required>
                                                    <option></option>
                                                    <option value="0">0</option>
                                                    <option value="2">2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_w_pembulatan">Pembulatan</label>
                                                <select class="js-select2" id="m_w_pembulatan" name="m_w_pembulatan"
                                                    style="width: 100%;" data-placeholder="Pilih Pembulatan" required>
                                                    <option></option>
                                                    <option value="ya">ya</option>
                                                    <option value="tidak">tidak</option>
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
    $('.js-select2').select2({dropdownParent: $('#formAction')})
    $(".buttonInsert").on('click', function() {
            $('[name="action"]').val('add');
            var id = $(this).attr('value');
            $('.js-select2').val(null).trigger('change');
            $("#myModalLabel").html('Tambah Waroeng');
            $("#form-waroeng").modal('show');
    });
     $("#m_w").on('click','.buttonEdit', function() {
                var id = $(this).attr('value');
                $('[name="action"]').val('edit');
                $('#form-waroeng form')[0].reset();
                $("#myModalLabel").html('Ubah Waroeng');
                $.ajax({
                    url: "/master/m_waroeng/edit/"+id,
                    type: "GET",
                    dataType: 'json',
                    success: function(respond) {
                        console.log();
                        $("#m_w_id").val(respond.m_w_id).trigger('change');
                        $("#m_w_nama").val(respond.m_w_nama).trigger('change');
                        $("#m_w_m_area_id").val(respond.m_w_m_area_id).trigger('change');
                        $("#m_w_m_w_jenis_id").val(respond.m_w_m_w_jenis_id).trigger('change');
                        $("#m_w_status").val(respond.m_w_status).trigger('change');
                        $("#m_w_alamat").val(respond.m_w_alamat).trigger('change');
                        $("#m_w_m_kode_nota").val(respond.m_w_m_kode_nota).trigger('change');
                        $("#m_w_m_pajak_id").val(respond.m_w_m_pajak_id).trigger('change');
                        $("#m_w_m_modal_tipe_id").val(respond.m_w_m_modal_tipe_id).trigger('change');
                        $("#m_w_m_sc_id").val(respond.m_w_m_sc_id).trigger('change');
                        $("#m_w_decimal").val(respond.m_w_decimal).trigger('change');
                        $("#m_w_pembulatan").val(respond.m_w_pembulatan).trigger('change');
                        $("#m_w_currency").val(respond.m_w_currency).trigger('change');
                    },
                    error: function() {
                    }
                });
                $("#form-waroeng").modal('show');
            }); 
    var t = $('#m_w').DataTable({
      processing: false,
      serverSide: false,
      destroy: true,
      order: [0, 'asc'],
    });
    $('#formAction').submit( function(e){
                if(!e.isDefaultPrevented()){
                    $.ajax({
                        url : "{{ route('action.m_waroeng') }}",
                        type : "POST",
                        data : $('#form-waroeng form').serialize(),
                        success: function(data) {
                        $('#form-waroeng').modal('hide');
                        Codebase.helpers('jq-notify', {
                            align: 'right',
                            from: 'top',
                            type: data.type,
                            icon: 'fa fa-info me-5',
                            message: data.messages
                        }); 
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        },
                        error : function(){
                            alert("Tidak dapat menyimpan data!");
                        }
                    });
                    return false;
                }
            });
    
      $("#m_w").append(
        $('<tfoot/>').append($("#m_w thead tr").clone())
      );
    });
</script>
@endsection
