@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title" style="font-size:1.5rem">
                            Jurnal Kas</h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="jurnal-insert">
                            <div class="col-md-12">
                                <div class="row mb-2 col-6">
                                    <label class="col-sm-4 col-form-label" id="namaWaroeng"
                                        for="example-hf-text">Waroeng</label>
                                    <div class="col-sm-8">
                                        <select id="filter-waroeng" style="width: 100%;"
                                            class="cari js-select2 form-control" name="m_jurnal_kas_m_waroeng_id">
                                            @foreach ($waroeng as $wrg)
                                                <option value="{{ $wrg->m_w_id }}"> {{ $wrg->m_w_nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2 col-6">
                                    <label class="col-sm-4 col-form-label" id="categoryAccount" for="example-hf-text">Jenis
                                        Transaksi</label>
                                    <div class="col-md-8">
                                        <select id="filter-kas" class="cari js-select2 form-control kas-click"
                                            style="width: 100%;" name="m_jurnal_kas">
                                            <option value="km">Kas Masuk</option>
                                            <option value="kk">Kas Keluar</option>
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
                                    <label class="col-sm-4 col-form-label" id="categoryAccount" for="example-hf-text">No
                                        Akun Kas</label>
                                    <div class="col-md-8">
                                        <input type="text" class="cari form-control " style="width: 100%;"
                                            name="" disabled>
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
                                                <th class="kas">Kredit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Input Nomor Akun"
                                                        id="m_jurnal_kas_m_rekening_no_akun"
                                                        name="m_jurnal_kas_m_rekening_no_akun[]"
                                                        class="form-control set form-control-sm no-akun text-center" />
                                                </td>
                                                <td>                                                   
                                                    <select id="m_rekening_nama"
                                                        name="m_jurnal_kas_m_rekening_nama[]"
                                                        class="js-select2 set_select showrek" style="width:200px;">
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Input Particul"
                                                        id="m_jurnal_kas_particul" name="m_jurnal_kas_particul[]"
                                                        class="form-control set form-control-sm text-center" />
                                                </td>
                                                <td>
                                                    <input type="number" placeholder="Input Saldo"
                                                        id="m_jurnal_kas_kredit" name="m_jurnal_kas_saldo[]"
                                                        class="form-control set form-control-sm saldo text-end mask"/>
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
                                            <input type="number" class="form-control set form-control-sm text-end" id="total" style="color:aliceblue; background-color: rgba(230, 42, 42, 0.6);"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="bg-transparent text-center">
                                        <button type="submit" class="btn btn-sm btn-success mt-2 simpan"> Simpan</button>
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
                                <table id="jurnal-tampil" class="table table-bordered table-striped table-vcenter mb-4">
                                    <thead class="justify-content-center">
                                        <tr>
                                            <th>No Akun</th>
                                            <th>Nama Akun</th>
                                            <th>Particul</th>
                                            <th class="kas">Kredit</th>
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
        '<td><input type="text" placeholder="Input Nomor Akun" id="m_jurnal_kas_m_rekening_no_akunjq'+ no +'" name="m_jurnal_kas_m_rekening_no_akun[]" class="form-control form-control-sm no_akunjq text-center"/></td>' +
        '<td><select id="m_rekening_namajq' + no + '" style="width:200px;" class="js-select2 showrekjq" name="m_jurnal_kas_m_rekening_nama[]"></select></td>' +
        '<td><input type="text" class="form-control form-control-sm text-center" name="m_jurnal_kas_particul[]" id="m_jurnal_kas_particul" placeholder="Input Particul"></td>' +
        '<td><input type="number" class="form-control form-control-sm saldo text-end mask" name="m_jurnal_kas_saldo[]" id="m_jurnal_kas_kredit" placeholder="Input Saldo"></td>' +
        '<td><button type="button" class="btn btn-danger btn_remove saldo"> - </button></td> </tr> ');
    });

     //hapus multiple
     $(document).on('click', '.btn_remove', function() {
      $(this).parents('tr').remove();
      $('.saldo').trigger("input");
    });

        // $(document).on('input', '.number-separator', function (e) {
        //     if (/^[0-9.,]+$/.test($(this).val())) {
        //     $(this).val(
        //         parseFloat($(this).val().replace(/,/g, '')).toLocaleString('en')
        //     );
        //     } else {
        //     $(this).val(
        //         $(this)
        //         .val()
        //         .substring(0, $(this).val().length - 1)
        //     );
        //     }
        // });

        $("input.mask").each((i,ele)=>{
            let clone=$(ele).clone(false)
            clone.attr("type","text")
            let ele1=$(ele)
            clone.val(Number(ele1.val()).toLocaleString("id"))
            $(ele).after(clone)
            $(ele).hide()
            clone.mouseenter(()=>{
                ele1.show()
                clone.hide()
            })
            setInterval(()=>{
                let newv=Number(ele1.val()).toLocaleString("id")
                if(clone.val()!=newv){
                    clone.val(newv)
                }
            })
            $(ele).mouseleave(()=>{
                $(clone).show()
                $(ele1).hide()
            })
        })

        $("input#total").each((i,ele)=>{
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
            sum += parseFloat($(this).val().replace());
            // sum += $(this).val();
        });
        $('#total').val(sum);
        
    });

    //  //auto sum multiple insert
    //  $(document).on('input', '.saldo', function() {
    //     var sum = 0;
    //     $(".saldo").each(function(){
    //         sum += +$(this).val();
    //     });
    //     $('#total').val(sum);
        
    // });
    
    var filwaroeng  = $('#filter-waroeng').val();
    var filkas      = $('#filter-kas').val();
    var filtanggal  = $('#filter-tanggal').val();

    //tampil
        $('#jurnal-tampil').DataTable({
        button:[],
        destroy: true,
        lengthMenu: [ 10, 25, 50, 75, 100],
        ajax: {
            url: '{{route("jurnal.tampil")}}',
            data : {
                m_jurnal_kas_m_waroeng_id: filwaroeng,
                m_jurnal_kas: filkas,
                m_jurnal_kas_tanggal: filtanggal,
            },
            type : "GET",
            },
            columns: [
            { data: 'm_jurnal_kas_m_rekening_no_akun' },
            { data: 'm_jurnal_kas_m_rekening_nama' },
            { data: 'm_jurnal_kas_particul' },
            { data: 'm_jurnal_kas_saldo' },
            { data: 'm_jurnal_kas_user' },
            { data: 'm_jurnal_kas_no_bukti' },
        ],
      });

    //insert
    $('#jurnal-insert').submit(function(e) {
      if (!e.isDefaultPrevented()) {
        $.ajax({
          url: "{{ route('jurnal.simpan') }}",
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
            var filkas2      = $('#filter-kas').val();
            var filtanggal2  = $('#filter-tanggal').val();

            $('#jurnal-tampil').DataTable({
                button:[],
                destroy: true,
                lengthMenu: [ 10, 25, 50, 75, 100],
                ajax: {
                    url: '{{route("jurnal.tampil")}}',
                    data : {
                        m_jurnal_kas_m_waroeng_id: filwaroeng2,
                        m_jurnal_kas: filkas2,
                        m_jurnal_kas_tanggal: filtanggal2,
                    },
                    type : "GET",
                    },
                    columns: [
                    { data: 'm_jurnal_kas_m_rekening_no_akun' },
                    { data: 'm_jurnal_kas_m_rekening_nama' },
                    { data: 'm_jurnal_kas_particul' },
                    { data: 'm_jurnal_kas_saldo' },
                    { data: 'm_jurnal_kas_user' },
                    { data: 'm_jurnal_kas_no_bukti' },
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

        function printErrorMsg (msg) {
    
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>Kolom masih kosong, atau tanggal bukan hari ini. Silahkan periksa kembali.</li>');
            });
        }

    //filter tampil
    $('.cari').on('change', function() {
        var filwaroeng  = $('#filter-waroeng').val();
        var filkas      = $('#filter-kas').val();
        var filtanggal  = $('#filter-tanggal').val();
        $('#jurnal-tampil').DataTable({
        button:[],
        destroy: true,
        lengthMenu: [ 10, 25, 50, 75, 100],
        ajax: {
            url: '{{route("jurnal.tampil")}}',
            data : {
                m_jurnal_kas_m_waroeng_id: filwaroeng,
                m_jurnal_kas: filkas,
                m_jurnal_kas_tanggal: filtanggal,
            },
            type : "GET",
            },
            columns: [
            { data: 'm_jurnal_kas_m_rekening_no_akun' },
            { data: 'm_jurnal_kas_m_rekening_nama' },
            { data: 'm_jurnal_kas_particul' },
            { data: 'm_jurnal_kas_saldo' },
            { data: 'm_jurnal_kas_user' },
            { data: 'm_jurnal_kas_no_bukti' },
        ],
      });
    });

    

    //auto change debit/kredit
    $('.kas-click').on('change', function() {
        var kas = $(this).val();
        if (kas == 'kk') {
            $('.kas').html('Debit')
        } else {
            $('.kas').html('Kredit')
        }
    });  

    //default select nama rekening
        $.ajax({
            url: '{{route("jurnal.rekeninglink")}}',
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
                url: '{{route("jurnal.rekeninglink")}}',
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
    $('#m_jurnal_kas_m_rekening_no_akun').on('keyup', function() {
        var filnomor    = $('#m_jurnal_kas_m_rekening_no_akun').val();
            $.ajax({
            type: "get",
            url: '{{ route("jurnal.carijurnalnoakun") }}',
            data: {
                m_rekening_no_akun: filnomor,
                },
                success: function(data){
                    // console.log(data);
                    $('#m_rekening_nama').val(data.m_rekening_nama).trigger("change");                               
                }
        });
    });

    //show nama rekening jquery
    $(document).on('keyup', '.no_akunjq', function() {
        var id           = $(this).closest("tr").attr("id"); 
        var filnomor2    = $('#m_jurnal_kas_m_rekening_no_akunjq'+id).val();
            $.ajax({
            type: "get",
            url: '{{ route("jurnal.carijurnalnoakun") }}',
            data: {
                m_rekening_no_akun: filnomor2,
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
            url: '{{ route("jurnal.carijurnalnamaakun") }}',
            data: {
                m_rekening_nama: filnama,
                },
                success: function(data){
                    console.log(data);    
                        $('#m_jurnal_kas_m_rekening_no_akun').val(data.m_rekening_no_akun);
                }
        });
    });

    //show no rekening jquery
    $(document).on('select2:select', '.showrekjq', function() {
        var id           = $(this).closest("tr").attr("id"); 
        var filnama      = $('#m_rekening_namajq'+id).val();
            $.ajax({
            type: "get",
            url: '{{ route("jurnal.carijurnalnamaakun") }}',
            data: {
                m_rekening_nama: filnama,
                },
                success: function(data){
                    console.log(data);    
                        $('#m_jurnal_kas_m_rekening_no_akunjq'+id).val(data.m_rekening_no_akun);
                }
        });
    });


});
</script>
@endsection
