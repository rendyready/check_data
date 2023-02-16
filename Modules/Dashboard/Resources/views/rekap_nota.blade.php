@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Rekap Nota Penjualan
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label">Area</label>
                                    <div class="col-sm-8">
                                        <select id="filter_area" data-placeholder="Pilih Area" style="width: 100%;"
                                            class="cari f-area js-select2 form-control" name="m_w_m_area_id">
                                            <option>-- Pilih Area --</option>
                                            @foreach ($data->area as $area)
                                                <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label">Waroeng</label>
                                    <div class="col-sm-8">
                                        <select id="filter_waroeng" style="width: 100%;"
                                            class="cari f-wrg js-select2 form-control" name="m_w_id">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="row mb-1">
                                    <label class="col-sm-4 col-form-label">Tanggal</label>
                                    <div class="col-sm-8">
                                      <input type="text" class="form-control form-control-sm flatpickr" id="filter_tanggal" name="r_t_tanggal">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="row mb-1">
                                    <label class="col-sm-4 col-form-label" for="rekap_inv_penjualan_created_by">Operator</label>
                                    <div class="col-sm-8">
                                        <select id="filter_area" style="width: 100%;"
                                        class="cari f-wrg js-select2 form-control" name="m_w_id">
                                        <option>-- Pilih Operator --</option>
                                        @foreach ($data->user as $user)
                                        <option value="{{ $user->id }}"> {{ $user->name }} </option>
                                        @endforeach
                                        <option data-placeholder="Pilih Nama Operator" value=""> </option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </form>      
                </div>
                
            <table id="tampil_rekap" class="table table-sm table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Operator</th>
                  <th>No. Nota</th>
                  <th>Total</th>
                  <th>Tax</th>
                  <th>Bayar</th>
                  {{-- <th>Pembayaran</th> --}}
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
@endsection
@section('js')
    <!-- js -->
    
    <script type="module">

flatpickr('#filter_tanggal', {
        inline: true,
        mode: 'range',
        minDate: 'today',
        dateFormat: 'd-m-Y'
    });

$(document).ready(function() {
    Codebase.helpersOnLoad(['jq-select2']);
    
    var filwaroeng  = $('#filter_waroeng').val();
    var filopr      = $('#filter_opr').val();
    var filtanggal  = $('#filter_tanggal').val();

    $('#tampil_rekap').DataTable({
        button: [],
        destroy: true,
        orderCellsTop: true,
        processing: true,
        autoWidth: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        pageLength: 10,
        ajax: {
            url: '{{route("rekap.show")}}',
            // data : {
            //     m_rekening_m_waroeng_id: waroengid,
            //     m_rekening_kategori: rekeningkategori,
            // },
            type : "GET",
            },
      });

      $('#filter_area').change(function(){
        var id_area = $(this).val();    
        if(id_area){
            $.ajax({
            type:"GET",
            url: '{{route("rekap.select_waroeng")}}',
            dataType: 'JSON',
            data : {
                id_area: id_area,
            },
            success:function(res){               
                if(res){
                    $("#filter_waroeng").empty();
                    $("#filter_waroeng").append('<option>-- Pilih Waroeng --</option>');
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

    


//     //filter tampil
//     $('.cari').on('change', function() {
//         var filwaroeng  = $('#filter-waroeng').val();
//         var filkas      = $('#filter-kas').val();
//         var filtanggal  = $('#filter-tanggal').val();
//         $('#jurnal-tampil').DataTable({
//             "columnDefs": [
//                 { 
//                   "render": DataTable.render.number( '.', ',', 2, 'Rp. ' ),
//                   "targets":[3],
//                 }
//             ],
//         button:[],
//         destroy: true,
//         lengthMenu: [ 10, 25, 50, 75, 100],
//         ajax: {
//             url: '{{route("jurnal.tampil")}}',
//             data : {
//                 m_jurnal_kas_m_waroeng_id: filwaroeng,
//                 m_jurnal_kas: filkas,
//                 m_jurnal_kas_tanggal: filtanggal,
//             },
//             type : "GET",
//             },
//             columns: [
//             { data: 'm_jurnal_kas_m_rekening_no_akun' },
//             { data: 'm_jurnal_kas_m_rekening_nama' },
//             { data: 'm_jurnal_kas_particul' },
//             { data: 'm_jurnal_kas_saldo' },
//             { data: 'm_jurnal_kas_user' },
//             { data: 'm_jurnal_kas_no_bukti' },
//         ],
//       });
//     });

});
</script>
@endsection
