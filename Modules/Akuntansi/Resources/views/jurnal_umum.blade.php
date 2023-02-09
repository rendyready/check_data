@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title" style="font-size:1.5rem">
                            Jurnal Umum</h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="jurnal-insert">
                            <div class="col-md-15">
                                <div class="row mb-2 col-5">
                                    <label class="col-sm-4 col-form-label" id="namaWaroeng"
                                        for="example-hf-text">Waroeng</label>
                                    <div class="col-sm-8">
                                        <select id="filter-waroeng" style="width: 100%;"
                                            class="cari js-select2 form-control" name="m_jurnal_umum_m_waroeng_id">
                                            @foreach ($waroeng as $wrg)
                                                <option value="{{ $wrg->m_w_id }}"> {{ $wrg->m_w_nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2 col-5">
                                    <label class="col-sm-4 col-form-label" id="categoryAccount"
                                        for="example-hf-text">Tanggal</label>
                                    <div class="col-md-8">
                                        <input type="date" value="<?= date('Y-m-d') ?>" id="filter-tanggal"
                                            class="cari form-control " style="width: 100%;"
                                            name="m_jurnal_umum_tanggal">
                                    </div>
                                </div>
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>
                                <div class="table-responsive">
                                    <table id="form" class="table table-bordered table-striped table-vcenter mb-4">
                                        <thead>
                                            <tr>
                                                <th>No Akun</th>
                                                <th>Nama Akun</th>
                                                <th>Particul</th>
                                                <th>Debit</th>
                                                <th>Kredit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Input Nomor Akun"
                                                        id="m_jurnal_umum_m_rekening_no_akun"
                                                        name="m_jurnal_umum_m_rekening_no_akun[]"
                                                        class="form-control set form-control-sm no-akun text-center" />
                                                </td>
                                                <td>
                                                    <select id="m_rekening_nama"
                                                        name="m_jurnal_umum_m_rekening_nama[]"
                                                        class="js-select2 set_select showrek" style="width:200px;">
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Input Particul"
                                                        id="m_jurnal_particul" name="m_jurnal_umum_particul[]"
                                                        class="form-control set form-control-sm text-center" />
                                                </td>
                                                <td>
                                                    <input type="text" step="any" id="m_jurnal_debit"
                                                        name="m_jurnal_umum_debit[]" value="0"
                                                        class="form-control set form-control-sm saldodebit text-end number" />
                                                </td>
                                                <td>
                                                    <input type="text" step="any" id="m_jurnal_kredit"
                                                        name="m_jurnal_umum_kredit[]" value="0"
                                                        class="form-control set form-control-sm saldokredit text-end number" />
                                                </td>
                                                <td>
                                                    <button type="button" class="btn tambah btn-primary">+</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row col-md-12">
                                        <div class="col-sm-7">
                                            <label for="total">Total</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" step="any" class="form-control set text-end mask" id="totaldebit" style="color:aliceblue; background-color: rgba(230, 42, 42, 0.6);" readonly />
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" step="any" class="form-control set text-end mask" id="totalkredit" style="color:aliceblue; background-color: rgba(230, 42, 42, 0.6);" readonly />
                                        </div>
                                    </div>
                                    <div class="bg-transparent text-center">
                                        <button type="submit" id="simpanfile" class="btn btn-sm btn-success mt-2 simpan">
                                            Simpan</button>
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
                            Daftar Jurnal
                        </h3>
                    </div>
                    <div class="block block-rounded">
                        <div class="block-content text-mute">
                            <div class="table-responsive">
                                <table id="jurnal-tampil" class="table table-striped">
                                    <thead class="justify-content-center">
                                        <tr>
                                            <th>No Akun</th>
                                            <th>Nama Akun</th>
                                            <th>Particul</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
                                            <th>User</th>
                                            <th>No Bukti</th>
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
    var no = 0;
    $('.tambah').on('click', function() {
      no++;
      $('#form').append('<tr class="hapus" id="' + no + '">' +
        '<td><input type="text" placeholder="Input Nomor Akun" id="m_jurnal_umum_m_rekening_no_akunjq'+ no +'" name="m_jurnal_umum_m_rekening_no_akun[]" class="form-control form-control-sm no-akunjq text-center"/></td>' +
        '<td><select id="m_rekening_namajq' + no + '" class="js-select2 showrekjq" name="m_jurnal_umum_m_rekening_nama[]" style="width:200px;"></select></td>' +
        '<td><input type="text" class="form-control form-control-sm text-center" name="m_jurnal_umum_particul[]" id="m_jurnal_particul" placeholder="Input Particul"></td>' +
        '<td><input type="text" step="any" class="form-control form-control-sm saldodebit text-end number" name="m_jurnal_umum_debit[]" id="m_jurnal_debit" value="0"></td>' +
        '<td><input type="text" step="any" class="form-control form-control-sm saldokredit text-end number" name="m_jurnal_umum_kredit[]" id="m_jurnal_kredit" value="0"></td>' +
        '<td><button type="button" class="btn btn-danger btn_remove saldodebit saldokredit"> - </button></td> </tr> ');
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

    //auto sum multiple insert debit
    $(document).on('input', '.saldodebit', function() {
        var sum = 0;
        $(".saldodebit").each(function(){
            sum += +$(this).val().replace(/\./g, '').replace(/\,/g, '.');
        });
        $('#totaldebit').val(sum); 
    }); 

     //auto sum multiple insert kredit
     $(document).on('input', '.saldokredit', function() {
        var sum = 0;
        $(".saldokredit").each(function(){
            sum += +$(this).val().replace(/\./g, '').replace(/\,/g, '.');
        });
        $('#totalkredit').val(sum); 
    });

    var filwaroeng  = $('#filter-waroeng').val();
    var filtanggal  = $('#filter-tanggal').val();
    
    //tampil
        $('#jurnal-tampil').DataTable({
            "columnDefs": [
                { 
                  "render": DataTable.render.number( '.', ',', 2, 'Rp. ' ),
                  "targets":[3, 4],
                }
            ],
        button:[],
        destroy: true,
        lengthMenu: [ 10, 25, 50, 75, 100],
        ajax: {
            url: '{{route("jurnal_umum.tampil")}}',
            data : {
                m_jurnal_umum_m_waroeng_id: filwaroeng,
                m_jurnal_umum_tanggal: filtanggal,
            },
            type : "GET",
            },
            columns: [
            { data: 'm_jurnal_umum_m_rekening_no_akun' },
            { data: 'm_jurnal_umum_m_rekening_nama' },
            { data: 'm_jurnal_umum_particul' },
            { data: 'm_jurnal_umum_debit' },
            { data: 'm_jurnal_umum_kredit' },
            { data: 'm_jurnal_umum_user' },
            { data: 'm_jurnal_umum_no_bukti' },
        ],
      });

    //insert
    $(document).on('click', '#simpanfile', function() {
    var debit       = $('#totaldebit').val();
    var kredit      = $('#totalkredit').val();
    var filwaroeng  = $('#filter-waroeng').val();
    var filtanggal  = $('#filter-tanggal').val();

    if(debit == kredit){
    $('#jurnal-insert').submit(function(e) {
      if (!e.isDefaultPrevented()) {
        $.ajax({
          url: "{{ route('jurnal_umum.simpan') }}",
          type: "POST",
          data: $('form').serialize(),
          success: function(data) {
            if($.isEmptyObject(data.error)){         
                Codebase.helpers('jq-notify', {
                              align: 'right', // 'right', 'left', 'center'
                              from: 'top', // 'top', 'bottom'
                              type: data.type, // 'info', 'success', 'warning', 'danger'
                              icon: 'fa fa-info me-5', // Icon class
                              message: data.messages
                            });
            $('.hapus').remove();
            $('.print-error-msg').remove();
            $('.set').val('');
            $('#m_rekening_nama').val('').trigger("change");
            var filwaroeng2  = $('#filter-waroeng').val();
            var filtanggal2  = $('#filter-tanggal').val();
            $('#jurnal-tampil').DataTable({
                "columnDefs": [
                    { 
                    "render": DataTable.render.number( '.', ',', 2, 'Rp. ' ),
                    "targets":[3, 4],
                    }
                ],
                button:[],
                destroy: true,
                lengthMenu: [ 10, 25, 50, 75, 100],
                ajax: {
                    url: '{{route("jurnal_umum.tampil")}}',
                    data : {
                        m_jurnal_umum_m_waroeng_id: filwaroeng2,
                        m_jurnal_umum_tanggal: filtanggal2,
                    },
                    type : "GET",
                    },
                    columns: [
                    { data: 'm_jurnal_umum_m_rekening_no_akun' },
                    { data: 'm_jurnal_umum_m_rekening_nama' },
                    { data: 'm_jurnal_umum_particul' },
                    { data: 'm_jurnal_umum_debit' },
                    { data: 'm_jurnal_umum_kredit' },
                    { data: 'm_jurnal_umum_user' },
                    { data: 'm_jurnal_umum_no_bukti' },
                ],
            });
            } else {
            printErrorMsg(data.error);
            }
          },
          error: function() {
            alert("Tidak dapat menyimpan data!");
          }
        });
        return false;
      }
    });
    } else {
        alert('Debit dan kredit tidak balance ! silahkan cek kembali.')
        return false;
    }
    });

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>Kolom masih kosong, atau tanggal bukan hari ini. Silahkan periksa kembali.</li>');
            });
        }

    //hapus multiple
    $(document).on('click', '.btn_remove', function() {
      $(this).parents('tr').remove();
      $('.saldodebit').trigger("input");
      $('.saldokredit').trigger("input");
    });

    //filter tampil
    $('.cari').on('change', function() {
        var filwaroeng  = $('#filter-waroeng').val();
        var filtanggal  = $('#filter-tanggal').val();
        $('#jurnal-tampil').DataTable({
            "columnDefs": [
                { 
                  "render": DataTable.render.number( '.', ',', 2, 'Rp. ' ),
                  "targets":[3, 4],
                }
            ],
        button:[],
        destroy: true,
        lengthMenu: [ 10, 25, 50, 75, 100],
        ajax: {
            url: '{{route("jurnal_umum.tampil")}}',
            data : {
                m_jurnal_umum_m_waroeng_id: filwaroeng,
                m_jurnal_umum_tanggal: filtanggal,
            },
            type : "GET",
            },
            columns: [
            { data: 'm_jurnal_umum_m_rekening_no_akun' },
            { data: 'm_jurnal_umum_m_rekening_nama' },
            { data: 'm_jurnal_umum_particul' },
            { data: 'm_jurnal_umum_debit' },
            { data: 'm_jurnal_umum_kredit' },
            { data: 'm_jurnal_umum_user' },
            { data: 'm_jurnal_umum_no_bukti' },
        ],
      });
    });

    //default select nama rekening
    $.ajax({
            url: '{{route("jurnal_bank.rekeninglink")}}',
            type: 'GET',
            dataType: 'Json',
            success: function(data) {
                $('#m_rekening_nama').append('<option></option>'); 
                $.each(data, function(key, value) {
                    $('#m_rekening_nama').append('<option value="'+ key +'">' + value + '</option>');
                });
            }
        })    

        //default select nama rekening jquery
        $('.tambah').on('click', function() {
            var id = $(this).closest("tr").index()+no++;
            $('#m_rekening_namajq'+id).select2(); 
            // console.log(id);
            $.ajax({
                url: '{{route("jurnal_umum.rekeninglink")}}',
                type: 'GET',
                dataType: 'Json',
                success: function(data) {
                    // console.log(data);
                    $('#m_rekening_namajq'+id).append('<option></option>'); 
                    $.each(data, function(key, value) {
                        $('#m_rekening_namajq'+id).append('<option value="'+ key +'">' + value + '</option>');
                    });
                },
            });
        });
    
    //show nama rekening
        $('#m_jurnal_umum_m_rekening_no_akun').on('keyup', function() {
        var filnomor    = $('#m_jurnal_umum_m_rekening_no_akun').val();
            $.ajax({
            type: "get",
            url: '{{ route("jurnal_umum.carijurnalnoakun") }}',
            data: {
                m_rekening_no_akun: filnomor,
                },
                success: function(data){
                    console.log(data);
                    $('#m_rekening_nama').val(data.m_rekening_nama).trigger("change");                                                       
                }
        });
    });

    //show nama rekening jquery
    $(document).on('keyup', '.no-akunjq', function() {
        var id           = $(this).closest("tr").attr("id"); 
        var filnomor2    = $('#m_jurnal_umum_m_rekening_no_akunjq'+id).val();
            $.ajax({
            type: "get",
            url: '{{ route("jurnal_umum.carijurnalnoakun") }}',
            data: {
                m_rekening_no_akun: filnomor2
                },
                success: function(data){
                // console.log(data);
                $('#m_rekening_namajq'+id).val(data.m_rekening_nama).trigger("change");                           
                }
        });
    });

    //show no rekening
    $('#m_rekening_nama').on('select2:select', function() {
        var filnama    = $('#m_rekening_nama').val();
            $.ajax({
            type: "get",
            url: '{{ route("jurnal_umum.carijurnalnamaakun") }}',
            data: {
                m_rekening_nama: filnama,
                },
                success: function(data){
                    console.log(data);    
                        $('#m_jurnal_umum_m_rekening_no_akun').val(data.m_rekening_no_akun);
                }
        });
    });

    //show no rekening jquery
    $(document).on('select2:select', '.showrekjq', function() {
        var id           = $(this).closest("tr").attr("id"); 
        var filnama    = $('#m_rekening_namajq'+id).val();
            $.ajax({
            type: "get",
            url: '{{ route("jurnal_umum.carijurnalnamaakun") }}',
            data: {
                m_rekening_nama: filnama,
                },
                success: function(data){
                    console.log(data);    
                        $('#m_jurnal_umum_m_rekening_no_akunjq'+id).val(data.m_rekening_no_akun);
                }
        });
    });
});
</script>
@endsection
