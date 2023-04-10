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
                                            <input name="r_t_tanggal" class="cari form-control filter_tanggal" type="text"
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
                                            @if (in_array(Auth::user()->waroeng_id, $data->akses_pusat ))
                                                <select id="filter_area2" data-placeholder="Pilih Area" style="width: 100%;"
                                                class="cari f-area js-select2 form-control filter_area" name="m_w_m_area_id">
                                                <option></option>
                                                @foreach ($data->area as $area)
                                                    <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }} </option>
                                                @endforeach
                                                </select>
                                            @else
                                                <select id="filter_area" data-placeholder="Pilih Area" style="width: 100%;"
                                                class="cari f-area js-select2 form-control filter_area" name="m_w_m_area_id" disabled>
                                                <option value="{{ ucwords($data->area_nama->m_area_id) }}">{{ ucwords($data->area_nama->m_area_nama) }}</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label">Waroeng</label>
                                        <div class="col-sm-9">
                                            @if (in_array(Auth::user()->waroeng_id, $data->akses_pusat))
                                                <select id="filter_waroeng1" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control filter_waroeng" data-placeholder="Pilih Waroeng" name="m_w_id">
                                                <option></option>
                                                </select>
                                            @elseif (in_array(Auth::user()->waroeng_id, $data->akses_pusar))
                                                <select id="filter_waroeng3" style="width: 100%;" data-placeholder="Pilih Waroeng"
                                                class="cari f-area js-select2 form-control filter_waroeng" name="waroeng">
                                                <option></option>
                                                @foreach ($data->waroeng as $waroeng)
                                                    <option value="{{ $waroeng->m_w_id }}"> {{ $waroeng->m_w_nama }} </option>
                                                @endforeach
                                                </select>
                                            @else
                                                <select id="filter_waroeng2" style="width: 100%;"
                                                class="cari f-area js-select2 form-control filter_waroeng" name="waroeng" disabled>
                                                <option value="{{ ucwords($data->waroeng_nama->m_w_id) }}">{{ ucwords($data->waroeng_nama->m_w_nama) }}</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="user-info" data-waroeng-id="{{ Auth::user()->waroeng_id }}" data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_area) ? 'true' : 'false' }}"></div>
                            <div id="user-info-pusat" data-waroeng-id="{{ Auth::user()->waroeng_id }}" data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_pusat) ? 'true' : 'false' }}"></div>

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
                                    <th>Sesi</th>
                                    <th>Operator</th>
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

    var userInfo = document.getElementById('user-info');
    var userInfoPusat = document.getElementById('user-info-pusat');
    var waroengId = userInfo.dataset.waroengId;
    var HakAksesArea = userInfo.dataset.hasAccess === 'true';
    var HakAksesPusat = userInfoPusat.dataset.hasAccess === 'true';

      $('#cari').on('click', function(e) {
      var waroeng   = $('.filter_waroeng').val();
      var tanggal   = $('.filter_tanggal').val();

      $('#tampil_rekap').DataTable({
          button: [],
          destroy: true,
          orderCellsTop: true,
          processing: true,
          scrollX: true,
          scrollY: '300px',
          autoWidth: false,
          columnDefs: [ 
                    {
                        targets: '_all',
                        className: 'dt-body-center'
                    },
                ],
          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
          pageLength: 10,
          ajax: {
              url: '{{route("kas_kasir.show")}}',
              data: {
                  waroeng: waroeng,
                  tanggal: tanggal,
              },
              type: "GET",
          },
          success: function(data) {
              console.log(data);
          }
      });
  });

  if(HakAksesPusat){
      $('.filter_area').on('select2:select', function(){
        var id_area = $(this).val();
        var tanggal  = $('.filter_tanggal').val();
        var prev = $(this).data('previous-value');
        if(id_area && tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("kas_kasir.select_waroeng")}}',
            dataType: 'JSON',
            destroy: true,    
            data : {
                id_area: id_area,
            },
            success:function(res){    
              // console.log(res);           
                if(res){
                    $(".filter_waroeng").empty();
                    $(".filter_waroeng").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_waroeng").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_waroeng").empty();
                }
            }
            });
        }else{
          alert('Harap lengkapi kolom tanggal');
            $(".filter_waroeng").empty();
            $(".filter_area").val(prev).trigger('change');
        }      
    });
  } 

  if(HakAksesArea){
    $('.filter_waroeng').on('select2:select', function(){
        var id_waroeng = $(this).val();   
        var tanggal  = $('.filter_tanggal').val(); 
        var prev = $(this).data('previous-value');
        if(!id_waroeng || !tanggal){
            alert('Harap lengkapi kolom tanggal');
            $(".filter_waroeng").val(prev).trigger('change');
        }  
    });
  }

    $('.filter_tanggal').flatpickr({
            mode: "range",
            dateFormat: 'Y-m-d',
    });

            $("#tampil_rekap").on('click','#button_detail', function() {
                var id = $(this).attr('value');
                var waroeng  = $('.filter_waroeng').val();
                var tanggal  = $('.filter_tanggal').val();
                var operator = $('.filter_operator').val();
                var sesi     = $('.filter_sesi').val();
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
                                  sesi: sesi,
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
                var waroeng = $('.filter_waroeng').val();
                var tanggal = $('.filter_tanggal').val();
                var url = 'kas_kasir/export_pdf?id='+id+'&waroeng='+waroeng+'&tanggal='+tanggal;
                window.open(url,'_blank');
            });


});
</script>
@endsection
