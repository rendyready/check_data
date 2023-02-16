@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Detail Nota Penjualan
            </h3>
              </div>
                <div class="block-content text-muted">
                    <form id="rekap_insert">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-2">
                                    <label class="col-sm-3 col-form-label">Area</label>
                                    <div class="col-sm-9">
                                        <select id="filter_area" data-placeholder="Pilih Area" style="width: 100%;"
                                            class="cari f-area js-select2 form-control" name="m_w_m_area_id">
                                            <option></option>
                                            {{-- @foreach ($data->area as $area)
                                                <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }} </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="row mb-2">
                                    <label class="col-sm-3 col-form-label">Waroeng</label>
                                    <div class="col-sm-9">
                                        <select id="filter_waroeng" style="width: 100%;"
                                            class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Waroeng" name="m_w_id">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label" >Tanggal</label>
                                    <div class="col-sm-9 datepicker">
                                        <input name="r_t_tanggal" class="cari form-control form-control-sm" type="text" placeholder="Pilih Tanggal.." id="filter_tanggal" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label" for="rekap_inv_penjualan_created_by">Operator</label>
                                    <div class="col-sm-9">
                                        <select id="filter_operator" style="width: 100%;"
                                        class="cari f-wrg js-select2 form-control" data-placeholder="Pilih Operator" name="r_t_created_by">
                                        <option></option>
                                        {{-- @foreach ($data->user as $user)
                                        <option value="{{ $user->id }}"> {{ $user->name }} </option>
                                        @endforeach --}}
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="col-sm-8">
                            <button type="button" id="cari"
                                class="btn btn-primary btn-sm col-1 mt-2 mb-5">Cari</button>
                        </div>

                    </form>      
                
            <table id="tampil_rekap" class="table ">
              <thead>
                <tr>
                  {{-- <th>Tanggal</th>
                  <th>Operator</th>
                  <th>No. Nota</th>
                  <th>Total</th>
                  <th>Tax</th>
                  <th>Bayar</th> --}}
                  {{-- <th>Pembayaran</th> --}}
                </tr>
              </thead>
              <tbody id="show_data">

                    <div class="row items-push">
                      <div class="col-md-6 col-xl-4">
                        <div class="block block-rounded h-100 mb-0">
                          <div class="block-header block-header-default">
                            <h3 class="block-title">
                              Nota 1
                            </h3>
                          </div>
                          <div class="block-content text-muted">
                            <p> 1 </p>
                            <p> 2 </p>
                            <p> 3 </p>
                            <p> 4 </p>
                          </div>
                        </div>
                      </div>

                        <div class="col-md-6 col-xl-4">
                          <div class="block block-rounded h-100 mb-0">
                            <div class="block-header block-header-default">
                              <h3 class="block-title">
                                Nota 2
                              </h3>
                            </div>
                            <div class="block-content text-muted">
                              <p> 1 </p>
                              <p> 2 </p>
                              <p> 3 </p>
                              <p> 4 </p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="block block-rounded h-100 mb-0">
                              <div class="block-header block-header-default">
                                <h3 class="block-title">
                                  Nota 3
                                </h3>
                              </div>
                              <div class="block-content text-muted">
                                <p> 1 </p>
                                <p> 2 </p>
                                <p> 3 </p>
                                <p> 4 </p>
                              </div>
                            </div>
                          </div>
                      </div>
                      
                  
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
// $(document).ready(function() {
//     Codebase.helpersOnLoad(['jq-select2']);

//     $('#cari').on('click', function() {
//         var waroeng  = $('#filter_waroeng').val();
//         var tanggal  = $('#filter_tanggal').val();
//         var operator = $('#filter_operator').val();
//         console.log(tanggal);
//     $('#tampil_rekap').DataTable({
//         button: [],
//         destroy: true,
//         orderCellsTop: true,
//         processing: true,
//         autoWidth: true,
//         lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
//         pageLength: 10,
//         ajax: {
//             url: '{{route("rekap.show")}}',
//             data : {
//                 waroeng: waroeng,
//                 tanggal: tanggal,
//                 operator: operator,
//             },
//             type : "GET",
//             },
//             success:function(data){ 
//                 console.log(data);
//             }
//       });
//     });

//     $('#filter_area').change(function(){
//         var id_area = $(this).val();    
//         if(id_area){
//             $.ajax({
//             type:"GET",
//             url: '{{route("rekap.select_waroeng")}}',
//             dataType: 'JSON',
//             data : {
//                 id_area: id_area,
//             },
//             success:function(res){               
//                 if(res){
//                     $("#filter_waroeng").empty();
//                     $("#filter_waroeng").append('<option></option>');
//                     $.each(res,function(key,value){
//                         $("#filter_waroeng").append('<option value="'+key+'">'+value+'</option>');
//                     });
//                 }else{
//                 $("#filter_waroeng").empty();
//                 }
//             }
//             });
//         }else{
//             $("#filter_waroeng").empty();
//         }      
//     });

//     $('#filter_tanggal').flatpickr({
//             mode: "range",
//             dateFormat: 'Y-m-d',
            // noCalendar: false,
            // allowInput: true,            
    // });

// });
</script>
@endsection
