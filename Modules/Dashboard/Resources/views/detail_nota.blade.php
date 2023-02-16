@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">

                    </div>
                    <div class="block-content text-muted">
                        <form id="detail_insert">
                            <div class="col-md-12">
                                <div class="row mb-2 col-6">
                                    <label class="col-sm-4 col-form-label" id="namaWaroeng"
                                        for="example-hf-text">Waroeng</label>
                                    <div class="col-sm-8">
                                        <select id="filter-waroeng" style="width: 100%;"
                                            class="cari js-select2 form-control" name="m_jurnal_kas_m_waroeng_id">
                                            @foreach ($data->waroeng as $wrg)
                                                <option value="{{ $wrg->m_w_id }}"> {{ $wrg->m_w_nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-2 col-6">
                                    <label class="col-sm-4 col-form-label" id="categoryAccount"
                                        for="example-hf-text">Tanggal</label>
                                    <div class="col-md-8">
                                        <input type="date" value="<?= date('Y-m-d') ?>" id="filter-tanggal"
                                            class="cari form-control " style="width: 100%;"
                                            name="m_jurnal_kas_tanggal">
                                    </div>
                                </div>
                                <div class="row mb-2 col-6">
                                    <label class="col-sm-4 col-form-label" id="categoryAccount" for="example-hf-text">Nama Operator</label>
                                    <div class="col-md-8">
                                        <select id="filter-kas" class="cari js-select2 form-control kas-click"
                                            style="width: 100%;" name="m_jurnal_kas">
                                            <option value="km">Kas Masuk</option>
                                            <option value="kk">Kas Keluar</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Detail Nota
                        </h3>
                    </div>
                    <div class="block block-rounded">
                        <div class="block-content text-mute">
                            <div class="table-responsive">
                                <table id="jurnal-tampil" class="table table-bordered table-striped table-vcenter mb-4">
                                    <thead class="justify-content-center">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>No Nota</th>
                                            <th>Operator</th>
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataReload">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- js -->
    
    <script type="module">

$(document).ready(function() {
    Codebase.helpersOnLoad(['jq-select2']);
    
//     var filwaroeng  = $('#filter-waroeng').val();
//     var filkas      = $('#filter-kas').val();
//     var filtanggal  = $('#filter-tanggal').val();

//     //tampil
//         $('#jurnal-tampil').DataTable({
//             "columnDefs": [
//                 { 
//                   "render": DataTable.render.number( '.', ',', 2, 'Rp. ' ),
//                   "targets":3,
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
