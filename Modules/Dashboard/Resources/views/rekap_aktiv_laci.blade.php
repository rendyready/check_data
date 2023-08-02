@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Rekap Aktivitas Kasir - Buka Laci
                        </h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="rekap_insert">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-1">
                                        <label class="col-sm-3 col-form-label">Tanggal</label>
                                        <div class="col-sm-9">
                                            <input style="z-index: 6;" name="r_t_tanggal"
                                                class="cari form-control filter_tanggal" type="text"
                                                placeholder="Pilih Tanggal.." id="filter_tanggal" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label">Area</label>
                                        <div class="col-sm-9">
                                            @if (in_array(Auth::user()->waroeng_id, $data->akses_pusat))
                                                <select id="filter_area2" data-placeholder="Pilih Area" style="width: 100%;"
                                                    class="cari f-area js-select2 form-control filter_area"
                                                    name="m_w_m_area_id">
                                                    <option></option>
                                                    @foreach ($data->area as $area)
                                                        <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }}
                                                        </option>
                                                    @endforeach
                                                    <option value="all">all area</option>
                                                </select>
                                            @else
                                                <select id="filter_area" data-placeholder="Pilih Area" style="width: 100%;"
                                                    class="cari f-area js-select2 form-control filter_area"
                                                    name="m_w_m_area_id" disabled>
                                                    <option value="{{ ucwords($data->area_nama->m_area_id) }}">
                                                        {{ ucwords($data->area_nama->m_area_nama) }}</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="row mb-2" id="select_waroeng">
                                        <label class="col-sm-3 col-form-label">Waroeng</label>
                                        <div class="col-sm-9">
                                            @if (in_array(Auth::user()->waroeng_id, $data->akses_pusat))
                                                <select id="filter_waroeng1" style="width: 100%;"
                                                    class="cari f-wrg js-select2 form-control filter_waroeng"
                                                    data-placeholder="Pilih Waroeng" name="m_w_id">
                                                    <option></option>
                                                </select>
                                            @elseif (in_array(Auth::user()->waroeng_id, $data->akses_pusar))
                                                <select id="filter_waroeng3" style="width: 100%;"
                                                    data-placeholder="Pilih Waroeng"
                                                    class="cari f-area js-select2 form-control filter_waroeng"
                                                    name="waroeng">
                                                    <option></option>
                                                    @foreach ($data->waroeng as $waroeng)
                                                        <option value="{{ $waroeng->m_w_id }}"> {{ $waroeng->m_w_nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select id="filter_waroeng2" style="width: 100%;"
                                                    class="cari f-area js-select2 form-control filter_waroeng"
                                                    name="waroeng" disabled>
                                                    <option value="{{ ucwords($data->waroeng_nama->m_w_id) }}">
                                                        {{ ucwords($data->waroeng_nama->m_w_nama) }}</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5" id="select_operator">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                            for="rekap_inv_penjualan_created_by">Operator</label>
                                        <div class="col-sm-9">
                                            <select id="filter_operator" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control filter_operator"
                                                data-placeholder="Pilih Operator" name="r_t_created_by">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="user-info" data-waroeng-id="{{ Auth::user()->waroeng_id }}"
                                data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_area) ? 'true' : 'false' }}">
                            </div>
                            <div id="user-info-pusat" data-waroeng-id="{{ Auth::user()->waroeng_id }}"
                                data-has-access="{{ in_array(Auth::user()->waroeng_id, $data->akses_pusat) ? 'true' : 'false' }}">
                            </div>

                            <div class="col-sm-8">
                                <button type="button" id="cari"
                                    class="btn btn-primary btn-sm col-1 mt-2 mb-3">Cari</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            {{-- <table id="tampil_rekap"
                            class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full"
                            style="width:100%"> --}}
                            <table id="tampil_rekap" class="table table-striped table-bordered nowrap table-hover"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Waroeng</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Kasir</th>
                                        <th class="text-center">Sesi</th>
                                        <th class="text-center">Intensitas Buka Laci</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="show_data">
                                    <!-- Data dari DataTables akan diisi di sini -->
                                </tbody>
                            </table>
                        </div>

                        {{-- <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
                            <button style="margin-left: 5px;" id="prevButton">Previous</button>
                            <button style="margin-left: 5px;" id="nextButton">Next</button>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Select2 in a modal -->
    <div class="modal" id="tampil_modal" tabindex="-1" role="dialog" aria-labelledby="tampil_modal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
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
                                    <div class="col-md-12">
                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label" style="font-size:14px">Tanggal</label>
                                            <div class="col-sm-9">
                                                <input class="col-sm-10 col-form-label" type="text"
                                                    style="border: none; font-size:14px" id="tanggal_pop" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="col-md-12">
                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label" style="font-size:14px">Waroeng</label>
                                            <div class="col-sm-9">
                                                <input class="col-sm-10 col-form-label" type="text"
                                                    style="border: none; font-size:14px" id="waroeng_pop" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="col-md-12">
                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label" style="font-size:14px">Operator</label>
                                            <div class="col-sm-9">
                                                <input class="col-sm-10 col-form-label" type="text"
                                                    style="border: none; font-size:14px" id="operator_pop" readonly>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table id="detail_modal"
                                    class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">Intensitas</th>
                                            <th class="text-center">Keterangan</th>
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

    var table;
    $('#cari').on('click', function() {
        var area = $('.filter_area option:selected').val();
        var waroeng = $('.filter_waroeng option:selected').val();
        var tanggal = $('.filter_tanggal').val();
        var operator = $('.filter_operator option:selected').val();

        if (tanggal === "" || area === "" || waroeng === "" || operator === "") {
            Swal.fire({
                title: 'Informasi',
                text: 'Silahkan lengkapi semua kolom',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'bg-red-500',
                },
            });
        } else {
         table =   $('#tampil_rekap').DataTable({
                destroy: true,
                orderCellsTop: true,
                processing: true,
                serverSide: true,
                pagingType: 'full_numbers',
                lengthChange: true, 
                scrollX: true,
                columnDefs: [
                    {
                        targets: '_all',
                        className: 'dt-body-center'
                    },
                ],
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: 'Rekap Buka Laci - ' + tanggal,
                        pageSize: 'A4',
                        pageOrientation: 'portrait',
                    }
                ],
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                pageLength: 10,
                ajax: {
                    url: '{{ route("rekap_aktiv_laci.tampil_laci") }}',
                    type: 'GET',
                    data: {
                        area: area,
                        waroeng: waroeng,
                        tanggal: tanggal,
                        operator: operator,
                    },
                },
                success:function(data){ 
                    console.log(data);
                },
                columns: [
                    { data: '0' }, // Kolom 1
                    { data: '1' }, // Kolom 2
                    { data: '2' }, // Kolom 3
                    { data: '3' }, // Kolom 4
                    { data: '4' }, // Kolom 5
                    { data: '5' }, // Kolom 6
                    { data: '6' }, // Kolom 7
                ],
               
            });
        }
    });


    //eksekusi filter
    // $('#cari').on('click', function() {
    //     var area  = $('.filter_area option:selected').val();
    //     var waroeng  = $('.filter_waroeng option:selected').val();
    //     var tanggal  = $('.filter_tanggal').val();
    //     var operator = $('.filter_operator option:selected').val();

    //     if (tanggal === "" || area === "" || waroeng === "" || operator === "") {
    //         Swal.fire({
    //         title: 'Informasi',
    //         text: 'Silahkan lengkapi semua kolom',
    //         confirmButtonColor: '#d33',
    //         confirmButtonText: 'OK',
    //         customClass: {
    //             confirmButton: 'bg-red-500',
    //         },
    //         });
    //       } else {
    //         $('#tampil_rekap').DataTable({
    //         button: [],
    //         destroy: true,
    //         orderCellsTop: true,
    //         processing: true,
    //         scrollX: true,
    //         columnDefs: [ 
    //                         {
    //                             targets: '_all',
    //                             className: 'dt-body-center'
    //                         },
    //                     ],
    //         buttons: [
    //                 {
    //                     extend: 'excelHtml5',
    //                     text: 'Export Excel',
    //                     title: 'Rekap Buka Laci - ' + tanggal,
    //                     pageSize: 'A4',
    //                     pageOrientation: 'potrait',
    //                 }
    //             ],
    //         lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    //         pageLength: 10,
    //         ajax: {
    //             url: '{{route("rekap_aktiv_laci.tampil_laci")}}',
    //             data : {
    //                 area: area,
    //                 waroeng: waroeng,
    //                 tanggal: tanggal,
    //                 operator: operator,
    //             },
    //             type : "GET",
    //             },
    //             success:function(data){ 
    //                 console.log(data);
    //             },
    //   });
    // }
    // });

    if(HakAksesPusat){
      $('.filter_area').on('select2:select', function(){
        var id_area = $(this).val();
        var tanggal  = $('.filter_tanggal').val();
        var prev = $(this).data('previous-value');

        if (id_area == 'all'){
            $("#select_waroeng").hide();
            $("#select_operator").hide();
        } else {
            $("#select_waroeng").show();
            $("#select_operator").show();
        }

        if(id_area && tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_aktiv_laci.select_waroeng")}}',
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
            Swal.fire({
                    title: 'Informasi',
                    text: "Harap lengkapi kolom tanggal",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-red-500',
                    },
                });
            $(".filter_waroeng").empty();
            $(".filter_area").val(prev).trigger('change');
        }      
        $(".filter_operator").empty();
    });
  } 

  if(HakAksesArea){
    $('.filter_waroeng').on('select2:select', function(){
        var id_waroeng = $(this).val();   
        var tanggal  = $('.filter_tanggal').val(); 
        var prev = $(this).data('previous-value');

        if (id_waroeng == 'all'){
            $("#select_operator").hide();
        } else {
            $("#select_operator").show();
        }

        if(id_waroeng && tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_aktiv_laci.select_user_laci")}}',
            dataType: 'JSON',
            data : {
              id_waroeng: id_waroeng,
              tanggal: tanggal,
            },
            success:function(res){   
            //   console.log(res);       
                if(res){
                    $(".filter_operator").empty();
                    $(".filter_operator").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_operator").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_operator").empty();
                }
            }
            });
        }else{
            Swal.fire({
                    title: 'Informasi',
                    text: "Harap lengkapi kolom tanggal",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-red-500',
                    },
                });
            $(".filter_operator").empty();
            $(".filter_waroeng").val(prev).trigger('change');
        }      
    });

  } else {

    $('.filter_tanggal').on('change', function(){
      var tanggal  = $('.filter_tanggal').val();
        if(tanggal){
            $.ajax({
            type:"GET",
            url: '{{route("rekap_aktiv_laci.select_user_laci")}}',
            dataType: 'JSON',
            data : {
              tanggal: tanggal,
            },
            success:function(res){         
            //   console.log(res);      
                if(res){
                    $(".filter_operator").empty();
                    $(".filter_operator").append('<option></option>');
                    $.each(res,function(key,value){
                        $(".filter_operator").append('<option value="'+key+'">'+value+'</option>');
                    });
                }else{
                $(".filter_operator").empty();
                }
            }
            });
        }else{
            $(".filter_operator").empty();
        }     
        $(".filter_operator").empty(); 
    });
  }

    //filter tanggal
    $('.filter_tanggal').flatpickr({
            mode: "range",
            dateFormat: 'Y-m-d',
    });

    //detail rekap laci
    $("#tampil_rekap").on('click','#button_detail', function() {
        var id = $(this).attr('value');
        var waroeng  = $('.filter_waroeng').val();
        var tanggal  = $('.filter_tanggal').val();
        var operator = $('.filter_operator').val();
        $('#tampil_modal form')[0].reset();
        $("#myModalLabel").html('Rekap Buka Laci');
        $.ajax({
            url: "/dashboard/rekap_aktiv_laci/detail_laci/"+id,
            type: "GET",
            dataType: 'json',
            destroy: true,
            success: function(data) {
              console.log(data.rekap_modal_m_w_nama);
              var date = new Date(data.r_b_l_tanggal);
              var formattedDate = ("0" + date.getDate()).slice(-2) + "/" + ("0" + (date.getMonth() + 1)).slice(-2) + "/" + date.getFullYear();

              $('#tanggal_pop').val(formattedDate);
              $('#waroeng_pop').val(data.r_b_l_m_w_nama);
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
                searching: false,
                ajax: {
                    url: "/dashboard/rekap_aktiv_laci/detail_show_laci/"+id,
                    data : {
                      waroeng: waroeng,
                      tanggal: tanggal,
                      operator: operator,
                    },
                type : "GET",
                },
                columns: [
                          { data: 'waktu', class: 'text-center'},
                          { data: 'intensitas', class: 'text-center'},
                          { data: 'keterangan', class: 'text-center' },
                        ],
            });
          },
        });
      $("#tampil_modal").modal('show');
    }); 

            // $("#tampil_rekap").on('click','#button_pdf', function() {
            //     var id = $(this).attr('value');
            //     var waroeng = $('.filter_waroeng').val();
            //     var tanggal = $('.filter_tanggal').val();
            //     var url = 'kas_kasir/export_pdf?id='+id+'&waroeng='+waroeng+'&tanggal='+tanggal;
            //     window.open(url,'_blank');
            // });

});
</script>
@endsection
