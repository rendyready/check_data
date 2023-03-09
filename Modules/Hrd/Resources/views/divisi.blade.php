@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Master Divisi
                    </div>
                    <div class="block-content text-muted">
                        <a class="btn btn-success mr-2 mb-2 buttonInsert" title="Edit" style="color: #fff"><i
                            class="fa fa-plus mr-5"></i> Divisi</a>
                        @csrf
                        <div class="table-responsive">
                            <table id="m_divisi"
                                class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>KODE</th>
                                        <th>NAMA DIVISI</th>
                                        <th>INDUK</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tablecontents">
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($divisi as $item)
                                        <tr class="row1">
                                            <td>{{ $no++ }}</td>
                                            <td>{{$item->m_divisi_id}}</td>
                                            <td>{{ ucwords($item->m_divisi_name) }}</td>
                                            <td>{{ $item->parent }}</td>
                                            <td><a id="buttonEdit" class="btn btn-sm buttonEdit btn-success" value="{{ $item->m_divisi_id }}" title="Edit"><i class="fa fa-pencil"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Select2 in a modal -->
                <div class="modal" id="form-divisi" tabindex="-1" role="dialog" aria-labelledby="form-gudang"
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
                                        <input type="hidden" name="action" id="action">
                                        <input type="hidden" name="m_divisi_id">

                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_divisi_name">Nama Divisi</label>
                                                <input class="form-group" style="width: 100%;" type="text" name="m_divisi_name" id="m_divisi_name" required>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="m_divisi_parent_id">Induk Divisi</label>
                                                <select class="js-select2" id="m_divisi_parent_id" name="m_divisi_parent_id"
                                                    style="width: 100%;" data-placeholder="Pilih Area" required>
                                                    <option></option>
                                                    @foreach ($parent as $item)
                                                        <option value="{{ $item->m_divisi_id }}">{{ ucwords($item->m_divisi_name) }}
                                                        </option>
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

    $('.js-select2').select2({dropdownParent: $('#formAction')})

    $(".buttonInsert").on('click', function() {
            $('[name="action"]').val('add');
            var id = $(this).attr('value');
            $('.js-select2').val(null).trigger('change');
            $("#myModalLabel").html('Tambah Divisi');
            $('#form-divisi form')[0].reset();
            $("#form-divisi").modal('show');
    });
    
    $("#m_divisi").on('click','.buttonEdit', function() {
        var id = $(this).attr('value');
        $('[name="action"]').val('edit');
        $('#form-divisi form')[0].reset();
        $("#myModalLabel").html('Ubah Divisi');
        $.ajax({
            url: "/hrd/master/divisi/"+id,
            type: "GET",
            dataType: 'json',
            success: function(respond) {
                console.log(respond);
                $("#m_divisi_id").val(respond.m_divisi_id);
                $("#m_divisi_name").val(respond.m_divisi_name);
                $("#m_divisi_parent_id").val(respond.m_divisi_parent_id).trigger('change');
            },
            error: function() {
            }
        });
        $("#form-divisi").modal('show');
    }); 

    var t = $('#m_divisi').DataTable({
      processing: false,
      serverSide: false,
      destroy: true,
      order: [0, 'asc'],
    });

    $('#formAction').submit( function(e){
        if(!e.isDefaultPrevented()){
            $.ajax({
                url : "{{ route('divisi.store') }}",
                type : "POST",
                data : $('#form-divisi form').serialize(),
                success : function(data){
                    $('#form-divisi').modal('hide');
                    Codebase.helpers('jq-notify', {
                        align: 'right', // 'right', 'left', 'center'
                        from: 'top', // 'top', 'bottom'
                        type: data.type, // 'info', 'success', 'warning', 'danger'
                        icon: 'fa fa-info me-5', // Icon class
                        message: data.messages
                    });
                    table.ajax.reload();
                },
                error : function(){
                    alert("Tidak dapat menyimpan data!");
                }
            });
            return false;
        }
    });
    
    $("#m_divisi").append(
        $('<tfoot/>').append($("#m_divisi thead tr").clone())
    );
});
</script>
@endsection
