@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Laporan Kas Harian Kasir
                        </h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="rekap_insert">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label">Tanggal</label>
                                        <div class="col-sm-9">
                                            <input name="r_t_tanggal" class="cari form-control" type="text"
                                                placeholder="Pilih Tanggal.." id="filter_tanggal" tabindex="-1" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label">Area</label>
                                        <div class="col-sm-9">
                                            <select id="filter_area" data-placeholder="Pilih Area" style="width: 100%;"
                                                class="cari f-area js-select2 form-control" name="m_w_m_area_id">
                                                <option></option>
                                                @foreach ($data->area as $area)
                                                    <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label">Waroeng</label>
                                        <div class="col-sm-9">
                                            <select id="filter_waroeng" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Waroeng"
                                                name="m_w_id">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                            for="rekap_inv_penjualan_created_by">Operator</label>
                                        <div class="col-sm-9">
                                            <select id="filter_operator" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Operator"
                                                name="r_t_created_by">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <button type="button" id="cari"
                                    class="btn btn-primary btn-sm col-1 mt-2 mb-3">Cari</button>
                            </div>
                        </form>
                        <table id="tampil_rekap"
                            class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Saldo Awal</th>
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                    <th>Saldo Akhir</th>
                                    <th>Saldo Real</th>
                                    <th>Selisih</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Select2 in a modal -->
    <div class="modal" id="tampil_modal" tabindex="-1" role="dialog" aria-labelledby="tampil_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-themed shadow-none mb-0">
                    <div class="block-header block-header-default bg-pulse">
                        <h3 class="block-title text-center" id="myModalLabel"></h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <!-- Select2 is initialized at the bottom of the page -->
                        <form id="formAction">
                            <div class="mb-4">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <label class="col-sm-3 col-form-label" style="font-size:14px">Tanggal</label>
                                            <div class="col-sm-9">
                                                <input type="text" style="border: none" id="tanggal_pop" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <label class="col-sm-3 col-form-label" style="font-size:14px">Waroeng</label>
                                            <div class="col-sm-9">
                                                <input type="text" style="border: none" id="waroeng_pop" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <label class="col-sm-3 col-form-label" style="font-size:14px">Operator</label>
                                            <div class="col-sm-9">
                                                <input type="text" style="border: none" id="operator_pop" readonly>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table id="detail_modal"
                                    class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">No Nota</th>
                                            <th class="text-center">Transaksi</th>
                                            <th class="text-center">Masuk</th>
                                            <th class="text-center">Keluar</th>
                                            <th class="text-center">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- END Select2 in a modal -->
@endsection
@section('js')
    <!-- js -->

    <script type="module">
$(document).ready(function() {
    Codebase.helpersOnLoad(['jq-select2']);
    function formatNumber(number) {
      return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

      $('#cari').on('click', function(e) {
      var waroeng = $('#filter_waroeng').val().trim();
      var tanggal = $('#filter_tanggal').val().trim();
      var operator = $('#filter_operator').val().trim();

      if (waroeng === '' || tanggal === '' || operator === '') {
          displayNotification('danger', 'Pastikan Semua Kolom Terisi');
          e.preventDefault();
          return; // Stop code execution
      }

      $('#tampil_rekap').DataTable({
          button: [],
          destroy: true,
          orderCellsTop: true,
          processing: true,
          scrollX: true,
          scrollY: '300px',
          autoWidth: false,
          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
          pageLength: 10,
          ajax: {
              url: '{{route("kas_kasir.show")}}',
              data: {
                  waroeng: waroeng,
                  tanggal: tanggal,
                  operator: operator,
              },
              type: "GET",
          },
          success: function(data) {
              console.log(data);
          }
      });
  });
    $('#filter_area').change(function(){
        var id_area = $(this).val();
        if(id_area){
            $.ajax({
            type:"GET",
            url: '{{route("kas_kasir.select_waroeng")}}',
            dataType: 'JSON',
            destroy: true,    
            data : {
                id_area: id_area,
            },
            success:function(res){               
                if(res){
                    $("#filter_waroeng").empty();
                    $("#filter_waroeng").append('<option></option>');
                    $.each(res,function(key,value){
                        $("#filter_waroeng").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $("#filter_waroeng").empty();
                }
            }
            });
        }else{
            $("#filter_waroeng").empty();
        }      
    });

    $('#filter_waroeng').change(function(){
        var id_waroeng = $(this).val();    
        if(id_waroeng){
            $.ajax({
            type:"GET",
            url: '{{route("kas_kasir.select_user")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
            },
            success:function(res){               
                if(res){
                    $("#filter_operator").empty();
                    $("#filter_operator").append('<option></option>');
                    $.each(res,function(key,value){
                        $("#filter_operator").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $("#filter_operator").empty();
                }
            }
            });
        }else{
            $("#filter_operator").empty();
        }      
    });

    $('#filter_tanggal').flatpickr({
            mode: "range",
            dateFormat: 'Y-m-d',
            
    });

            $("#tampil_rekap").on('click','#button_detail', function() {
                var id = $(this).attr('value');
                var waroeng  = $('#filter_waroeng').val();
                var tanggal  = $('#filter_tanggal').val();
                var operator = $('#filter_operator').val();
                $('#tampil_modal form')[0].reset();
                $("#myModalLabel").html('Laporan Kas Kasir');
                $.ajax({
                    url: "/dashboard/kas_kasir/detail/"+id,
                    type: "GET",
                    dataType: 'json',
                    destroy: true,
                    success: function(data) {
                      console.log(data.rekap_modal_m_w_nama);
                      var date = new Date(data.rekap_modal_tanggal);
                      var formattedDate = ("0" + date.getDate()).slice(-2) + "/" + ("0" + (date.getMonth() + 1)).slice(-2) + "/" + date.getFullYear();

                        $('#tanggal_pop').val(formattedDate);
                        $('#waroeng_pop').val(data.rekap_modal_m_w_nama);
                        $('#operator_pop').val(data.name);

                        $('#detail_modal').DataTable({
                          destroy: true,
                          processing: true,
                          scrollX: true,
                        //   scrollY: "300px",
                          autoWidth: false,
                          paging: false,
                          dom: 'Bfrtip',
                          buttons: [],
                          ajax: {
                              url: "/dashboard/kas_kasir/detail_show/"+id,
                              data : {
                                  waroeng: waroeng,
                                  tanggal: tanggal,
                                  operator: operator,
                              },
                              type : "GET",
                              },
                              columns: [
                              { data: 'tanggal' },
                              { data: 'no_nota' },
                              { data: 'transaksi' },
                              { data: 'masuk', class: 'text-end' },
                              { data: 'keluar', class: 'text-end' },
                              { data: 'saldo', class: 'text-end' },
                            ],
                      });
                    },
                });
                $("#tampil_modal").modal('show');
            }); 

            $("#tampil_rekap").on('click','#button_pdf', function() {
                var id = $(this).attr('value');
                var waroeng = $('#filter_waroeng').val();
                var tanggal = $('#filter_tanggal').val();
                var operator = $('#filter_operator').val();
                var url = 'kas_kasir/export_pdf?id='+id+'&waroeng='+waroeng+'&tanggal='+tanggal+'&operator='+operator;
                window.open(url,'_blank');
            });


});
</script>
@endsection
