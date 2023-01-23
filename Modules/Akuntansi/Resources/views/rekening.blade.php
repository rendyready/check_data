@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Form Input Rekening
                    </div>
                    <div class="block block-rounded">
                        <div class="block-content text-muted">
                            <form id="rekening-insert">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row mb-2 col-6">
                                        <label class="col-sm-4 col-form-label" id="namaWaroeng"
                                            for="example-hf-text">Waroeng</label>
                                        <div class="col-sm-8">
                                            <select id="filter-waroeng" style="width: 100%;"
                                                class="cari f-wrg js-select2 form-control" name="m_rekening_m_waroeng_id">
                                                @foreach ($waroeng as $wrg)
                                                    <option value="{{ $wrg->m_w_id }}"> {{ $wrg->m_w_nama }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2 col-6">
                                        <label class="col-sm-4 col-form-label" id="categoryAccount"
                                            for="example-hf-text">Kategori Akun</label>
                                        <div class="col-md-8">
                                            <select id="filter-rekening" class="cari js-select2 form-control "
                                                style="width: 100%;" name="m_rekening_kategori">
                                                <option value="Aktiva Lancar">Aktiva Lancar</option>
                                                <option value="Aktiva Tetap">Aktiva Tetap</option>
                                                <option value="Modal">Modal</option>
                                                <option value="Kewajiban Jangka Pendek">Kewajiban Jangka Pendek</option>
                                                <option value="Kewajiban Jangka Panjang">Kewajiban Jangka Panjang
                                                </option>
                                                <option value="Pendapatan Operasional">Pendapatan Operasional</option>
                                                <option value="Pendapatan Non Operasional">Pendapatan Non Operasional
                                                </option>
                                                <option value="Badan Organisasi">Badan Organisasi</option>
                                                <option value="Badan Usaha">Badan Usaha</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="form" class="table table-bordered table-striped table-vcenter mb-4">
                                            <thead>
                                                <tr>
                                                    <th>No Akun</th>
                                                    <th>Nama Akun</th>
                                                    <th>Saldo</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="number" placeholder="Input Nomor Akun"
                                                            id="m_rekening_no_akun" name="m_rekening_no_akun[]"
                                                            class="form-control set form-control-sm m_rekening_no_akun"
                                                            required />
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Input Nama Rekening"
                                                            id="m_rekening_nama" name="m_rekening_nama[]"
                                                            class="form-control set form-control-sm m_rekening_nama"
                                                            required />
                                                    </td>
                                                    <td>
                                                        <input type="number" placeholder="Input Saldo Rekening"
                                                            id="m_rekening_saldo" name="m_rekening_saldo[]"
                                                            class="form-control set saldo form-control-sm" required />
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn tambah btn-primary">+</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row" style="padding-left: 715px; margin-right: 10px;">
                                            <label class="col-sm-2 col-form-label" id="categoryAccount"
                                                for="example-hf-text">Total </label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control set form-control-sm" id="total"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="bg-transparent text-center">
                                            <button type="submit" class="btn btn-sm btn-success mt-2"> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                            Daftar Rekening
                        </h3>
                    </div>
                    <div class="block block-rounded">
                        <div class="block-content text-mute">
                            <div class="table-responsive">
                                <table id="rekening-tampil" class="table table-bordered table-striped table-vcenter mb-4">
                                    <thead class="justify-content-center">
                                        <tr>
                                            <th>Kategori</th>
                                            <th>No Akun</th>
                                            <th>Nama Akun</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataReload">
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mb-2 col-md-6">
                                <label class="col-sm-4 col-form-label" for="example-hf-text">Copy Ke Waroeng
                                    Lain</label>
                                <div class="col-sm-8">
                                    <select style="width: 100%;" id="m_rekening_m_waroeng_id2"
                                        class="js-select2 form-control text-center m_rekening_m_waroeng_id2"
                                        name="m_rekening_m_waroeng_id">
                                        <option>-- Pilih Waroeng --</option>
                                        @foreach ($waroeng as $wrg)
                                            <option value="{{ $wrg->m_w_id }}"> {{ $wrg->m_w_nama }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-4 col-form-label" for="example-hf-text">Dengan Saldo</label>
                                <div class="col-sm-8">
                                  <select style="width: 100%;" id="m_rekening_copy_saldo"
                                      class="js-select2 form-control text-center m_rekening_copy_saldo"
                                      name="m_rekening_copy_saldo">
                                      <option value="tidak">Tidak</option>
                                      <option value="ya">Ya</option>
                                  </select>
                              </div>
                                <div class="col-sm-8">
                                  <button type="submit" id="copyrecord"
                                      class="btn btn-success btn-sm col-form-label mt-3">Copy Sekarang</button>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="module">
  $(document).ready(function() {
    Codebase.helpersOnLoad(['jq-select2']);
    var no = 0;
    $('.tambah').on('click', function() {
      no++;
      $('#form').append('<tr class="hapus" id="row' + no + '">' +
        '<td><input type="number" class="form-control form-control-sm m_rekening_no_akunjq" name="m_rekening_no_akun[]" id="m_rekening_no_akunjq' + no + '" placeholder="Input Nama Akun" required></td>' +
        '<td><input type="text" class="form-control form-control-sm m_rekening_namajq" name="m_rekening_nama[]" id="m_rekening_namajq' + no + '" placeholder="Input Nama Rekening" required></td>' +
        '<td><input type="number" class="form-control saldo form-control-sm" name="m_rekening_saldo[]" id="m_rekening_saldo" placeholder="Input Saldo Rekening" required></td>' +
        '<td><button type="button" id="' + no + '" class="btn btn-danger btn_remove"> - </button></td> </tr> ');
    });

    var waroengid           = $('#filter-waroeng').val();
    var rekeningkategori    = $('#filter-rekening').val();
    
        $('#rekening-tampil').DataTable({
        button:[],
        destroy: true,
        lengthMenu: [ 10, 25, 50, 75, 100],
        ajax: {
            url: '{{route("rekening.tampil")}}',
            data : {
                m_rekening_m_waroeng_id: waroengid,
                m_rekening_kategori: rekeningkategori,
            },
            type : "GET",
            },
            columns: [
            { data: 'm_rekening_kategori' },
            { data: 'm_rekening_no_akun' },
            { data: 'm_rekening_nama' },
            { data: 'm_rekening_saldo' },
        ],
      });


    $('#rekening-insert').submit(function(e) {
      if (!e.isDefaultPrevented()) {
      $.ajax({
          url: "{{ route('rekening.simpan') }}",
          type: "POST",
          data: $('form').serialize(),
          success: function(data) {
            Codebase.helpers('jq-notify', {
                              align: 'right', // 'right', 'left', 'center'
                              from: 'top', // 'top', 'bottom'
                              type: data.type, // 'info', 'success', 'warning', 'danger'
                              icon: 'fa fa-info me-5', // Icon class
                              message: data.messages
                            });
            $('.hapus').remove();
            $('.set').val('');

            var waroengid2= $('#filter-waroeng').val();
            var rekeningkategori2 = $('#filter-rekening').val();

            $('#rekening-tampil').DataTable({
                button:[],
                destroy: true,
                lengthMenu: [ 10, 25, 50, 75, 100],
                ajax: {
                    url: '{{route("rekening.tampil")}}',
                    data : {
                        m_rekening_m_waroeng_id: waroengid2,
                        m_rekening_kategori: rekeningkategori2,
                    },
                    type : "GET",
                    },
                    columns: [
                    { data: 'm_rekening_kategori' },
                    { data: 'm_rekening_no_akun' },
                    { data: 'm_rekening_nama' },
                    { data: 'm_rekening_saldo' },
                ],
            });
          },
          error: function() {
            alert("Tidak dapat menyimpan data!");
          }
        });
        return false;
      }
    });

    $(document).on('click', '.btn_remove', function() {
      var button_id = $(this).attr("id");
     $('#row' + button_id + '').remove();
     $('.saldo').trigger("input");
    });
    
    $('.cari').on('change', function() {
        var waroengid = $('#filter-waroeng').val();
        var rekeningkategori = $('#filter-rekening').val();
        $('#rekening-tampil').DataTable({
        button:[],
        destroy: true,
        lengthMenu: [ 10, 25, 50, 75, 100],
        ajax: {
            url: '{{route("rekening.tampil")}}',
            data : {
                m_rekening_m_waroeng_id: waroengid,
                m_rekening_kategori: rekeningkategori,

            },
            type : "GET",
            },
            columns: [
            { data: 'm_rekening_kategori' },
            { data: 'm_rekening_no_akun' },
            { data: 'm_rekening_nama' },
            { data: 'm_rekening_saldo' },
        ],

      });
    });

    $(document).on("input", ".saldo", function() {
        var sum = 0;
        $(".saldo").each(function(){
            sum += +$(this).val();
        });
        $('#total').val(sum);
        
    });

    //validasi nama
    $(document).on("change", ".m_rekening_nama", function() {
        var nama = $('#m_rekening_nama').val().toLowerCase();
                $.ajax({
                url: "{{ route('rekening.validasinama') }}",
                data : {
                    m_rekening_nama: nama,
                },
                type: "get",
                success: function(data) {
                    if (data > 0){
                    alert('Nama rekening yang anda inputkan sama/ duplikat ! ');
                    $('.m_rekening_nama').val('');
                    }  
                },
            }); 
        }); 

        //validasi no akun
        $(document).on("change", ".m_rekening_no_akun", function() {
        var no = $('#m_rekening_no_akun').val();
                $.ajax({
                url: "{{ route('rekening.validasino') }}",
                data : {
                m_rekening_no_akun: no,
                },
                type: "get",
                success: function(data) {

                    // console.log(data);
                    if (data > 0){
                    alert('No Akun yang anda inputkan sama/duplikat ! ');
                    $('.m_rekening_no_akun').val('');
                    }  
                },
            }); 
        });
    
        //validasi nama jquery
        $(document).on("change", ".m_rekening_namajq", function() {
        var id   = $(this).closest("tr").index(); 
        var nama = $('#m_rekening_namajq'+id).val().toLowerCase();
                $.ajax({
                url: "{{ route('rekening.validasinama') }}",
                data : {
                    m_rekening_nama: nama,
                },
                type: "get",
                success: function(data) {
                    if (data > 0){
                    alert('Nama rekening yang anda inputkan sama/ duplikat ! ');
                    $('#m_rekening_namajq'+id).val('');
                    }  
                },
            }); 
        }); 

        //validasi no akun jquery
        $(document).on("change", ".m_rekening_no_akunjq", function() {
        var id = $(this).closest("tr").index(); 
        var no = $('#m_rekening_no_akunjq'+id).val();
                $.ajax({
                url: "{{ route('rekening.validasino') }}",
                data : {
                m_rekening_no_akun: no,
                },
                type: "get",
                success: function(data) {
                    if (data > 0){
                    alert('No Akun yang anda inputkan sama/duplikat ! ');
                    $('#m_rekening_no_akunjq'+id).val('');
                    }  
                },
            }); 
        });

    $(document).on('click', '.btn_remove', function() {
      var button_id = $(this).attr("id");
     $('#row' + button_id + '').remove();
     $('.saldo').trigger("input");
    });


    //copyrecord
    $(document).on('click', '#copyrecord', function() {
        var waroengasal     = $('#filter-waroeng').val();
        var waroengtj       = $('#m_rekening_m_waroeng_id2').val();
        var waroengasal1     = $('#filter-waroeng').val();
        var waroengtj1       = $('#m_rekening_m_waroeng_id2').val();
    if(waroengasal1 != waroengtj1){

        $.ajax({
            url: "{{ route('rekening.copyrecord') }}",
            data : { 
                waroeng_asal: waroengasal,
                waroeng_tujuan: waroengtj,
            },            
            type : "GET",
            success: function(data) {
              Codebase.helpers('jq-notify', {
                              align: 'right', // 'right', 'left', 'center'
                              from: 'top', // 'top', 'bottom'
                              type: data.type, // 'info', 'success', 'warning', 'danger'
                              icon: 'fa fa-info me-5', // Icon class
                              message: data.messages
                            });
            },
        });
      }else{
      alert('waroeng yang anda pilih sama dengan yang di halaman !');
      $('#m_rekening_m_waroeng_id2').val('-- Pilih Waroeng --');
      }
    });


});
</script>
@endsection
