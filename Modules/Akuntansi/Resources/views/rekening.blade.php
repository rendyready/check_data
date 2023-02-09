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
                                                <option value="aktiva lancar">Aktiva Lancar</option>
                                                <option value="aktiva tetap">Aktiva Tetap</option>
                                                <option value="modal">Modal</option>
                                                <option value="kewajiban jangka pendek">Kewajiban Jangka Pendek</option>
                                                <option value="kewajiban jangka panjang">Kewajiban Jangka Panjang
                                                </option>
                                                <option value="pendapatan operasional">Pendapatan Operasional</option>
                                                <option value="pendapatan non operasional">Pendapatan Non Operasional
                                                </option>
                                                <option value="badan organisasi">Badan Organisasi</option>
                                                <option value="badan usaha">Badan Usaha</option>
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
                                                        <input type="text" placeholder="Input Nomor Akun"
                                                            id="m_rekening_no_akun" name="m_rekening_no_akun[]"
                                                            class="form-control set form-control-sm m_rekening_no_akun text-center"
                                                            required />
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Input Nama Rekening"
                                                            id="m_rekening_nama" name="m_rekening_nama[]"
                                                            class="form-control set form-control-sm m_rekening_nama text-center"
                                                            required />
                                                    </td>
                                                    <td>
                                                        <input type="text" step="any" placeholder="Input Saldo Rekening"
                                                            id="m_rekening_saldo" name="m_rekening_saldo[]"
                                                            class="form-control set saldo form-control-sm text-end number"  required />
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
                                                <input type="text" class="form-control set form-control-sm text-end mask" style="color:aliceblue; background-color: rgba(230, 42, 42, 0.6);" id="total"
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
        '<td><input type="text" class="form-control form-control-sm m_rekening_no_akunjq text-center" name="m_rekening_no_akun[]" id="m_rekening_no_akunjq' + no + '" placeholder="Input Nama Akun" required></td>' +
        '<td><input type="text" class="form-control form-control-sm m_rekening_namajq text-center" name="m_rekening_nama[]" id="m_rekening_namajq' + no + '" placeholder="Input Nama Rekening" required></td>' +
        '<td><input type="text" class="form-control saldo form-control-sm text-end number" name="m_rekening_saldo[]" id="m_rekening_saldo" placeholder="Input Saldo Rekening" required></td>' +
        '<td><button type="button" id="' + no + '" class="btn btn-danger btn_remove"> - </button></td> </tr> ');
    });

    $(document).on('input', '.number', function () {
			var angka = $(this).val();
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			angka_hasil     = split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			if(ribuan){
				var separator = sisa ? '.' : '';
				angka_hasil += separator + ribuan.join('.');
			}

			$(this).val(angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] : angka_hasil);
    });

    $("input.mask").each((i,ele)=>{
            let clone=$(ele).clone(false)
            clone.attr("type","text")
            let ele1=$(ele)
            clone.val(Number(ele1.val()).toLocaleString("id"))
            $(ele).after(clone)
            $(ele).hide()
            setInterval(()=>{
                let newv=Number(ele1.val()).toLocaleString("id")
                if(clone.val()!=newv){
                    clone.val(newv)
                }
            },10)
            $(ele).mouseleave(()=>{
                $(clone).show()
                $(ele1).hide()
            })
        })

     //auto sum multiple insert
     $(document).on('input', '.saldo', function() {
        var sum = 0;
        $(".saldo").each(function(){
            sum += +$(this).val().replace(/\./g, '').replace(/\,/g, '.');
        });
        $('#total').val(sum);  
    });

    var waroengid           = $('#filter-waroeng').val();
    var rekeningkategori    = $('#filter-rekening').val();
    
        $('#rekening-tampil').DataTable({
            "columnDefs": [
                { 
                  "render": DataTable.render.number( '.', ',', 2, 'Rp. ' ),
                  "targets":3,
                }
            ],
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
                "columnDefs": [
                    { 
                    "render": DataTable.render.number( '.', ',', 2, 'Rp. ' ),
                    "targets":3,
                    }
                ],
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
            "columnDefs": [
                { 
                  "render": DataTable.render.number( '.', ',', 2, 'Rp. ' ),
                  "targets":3,
                }
            ],
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

    //validasi nama
    $(document).on("change", ".m_rekening_nama", function() {
        var nama                = $('#m_rekening_nama').val().toLowerCase();
        var waroengid           = $('#filter-waroeng').val();
        var rekeningkategori    = $('#filter-rekening').val();
                $.ajax({
                url: "{{ route('rekening.validasinama') }}",
                data : {
                    m_rekening_nama: nama,
                    m_rekening_m_waroeng_id: waroengid,
                    m_rekening_kategori: rekeningkategori,
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
            var waroengid           = $('#filter-waroeng').val();
            var rekeningkategori    = $('#filter-rekening').val();
                $.ajax({
                url: "{{ route('rekening.validasino') }}",
                data : {
                m_rekening_no_akun: no,
                m_rekening_m_waroeng_id: waroengid,
                m_rekening_kategori: rekeningkategori,
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
        var waroengid           = $('#filter-waroeng').val();
        var rekeningkategori    = $('#filter-rekening').val();
                $.ajax({
                url: "{{ route('rekening.validasinama') }}",
                data : {
                    m_rekening_nama: nama,
                    m_rekening_m_waroeng_id: waroengid,
                    m_rekening_kategori: rekeningkategori,
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
        var waroengid           = $('#filter-waroeng').val();
        var rekeningkategori    = $('#filter-rekening').val();
                $.ajax({
                url: "{{ route('rekening.validasino') }}",
                data : {
                m_rekening_no_akun: no,
                m_rekening_m_waroeng_id: waroengid,
                m_rekening_kategori: rekeningkategori,
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
        var waroengasal      = $('#filter-waroeng').val();
        var waroengtj        = $('#m_rekening_m_waroeng_id2').val();
        var waroengasal1     = $('#filter-waroeng').val();
        var waroengtj1       = $('#m_rekening_m_waroeng_id2').val();
        var saldo            = $('#m_rekening_copy_saldo').val();
    if(waroengasal1 != waroengtj1){

        $.ajax({
            url: "{{ route('rekening.copyrecord') }}",
            data : { 
                waroeng_asal: waroengasal,
                waroeng_tujuan: waroengtj,
                m_rekening_copy_saldo: saldo,
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
