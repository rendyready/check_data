@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Form Input Pembelian
          </div>
          <div class="block-content text-muted">
                <form action="#">
                <div class="row">
                    <div class="col-md-5">
                        <div class="row mb-2">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Area Waroeng</label>
                            <div class="col-sm-8">
                              <select class="js-select2 form-control-sm" style="width: 100%;" name="kode_area" id="kode_area" data-placeholder="pilih area/waroeng">
                                @foreach ($data as $item)
                                <option value="{{ $item->m_w_id}}"> {{$item->m_w_nama}}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                         <div class="row mb-2">
                            <label class="col-sm-4 col-form-label" for="example-hf-text">Kode Akun</label>
                            <div class="col-sm-8">
                              <select class="js-select2 form-control-sm" style="width: 100%;" name="kode_supplier" id="kode_supplier" data-placeholder="pilih kode akun">
                                <option></option>
                                <option value="aktiva lancar">Aktiva Lancar</option>
                                <option value="aktiva tetap">Aktiva Tetap</option>
                                <option value="modal">Modal</option>
                                <option value="kewajiban jangka panjang">Kewajiban Jangka Panjang</option>
                                <option value="pendapatan operasional">Pendapatan Operasional </option>
                                <option value="pendapatan non operasional">Pendapatan Non Operasional </option>
                                <option value="biaya usaha">Biaya Usaha</option>
                                <option value="biaya non usaha">Biaya Non Usaha</option>
                              </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                  <thead>
                    <th>No Akun</th>
                    <th>Nama Akun</th>
                    <th>Saldo</th>
                    <th><button type="button" class="btn tambah btn-success">Add</button></th>
                </thead>
                    <tbody>
                        <tr>
                        <td><input type="number" step="0.01" class="form-control form-control-sm" name="name[]" id=""></td>
                        <td><input type="text" class="form-control form-control-sm" name="name[]" id=""></td>
                        <td><input type="text" class="form-control form-control-sm txtCal" name="name[]" id=""></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th>No Akun</th>
                        <th>Nama Akun</th>
                        <th>Saldo</th>
                        <th><button type="button" class="btn tambah btn-success">Add</button></th>
                      </tfoot>
                </table>
                </div>
                </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Page Content -->
@endsection
@section('js')
<script type="module">
 $(document).ready(function(){
    Codebase.helpersOnLoad(['jq-select2']);
	var no =1;
    var  selectValues = { "1": "Minyak Goreng", "2": "Beras C4","3":"Terasi" }; //Contoh bentuk data

	$('.tambah').on('click',function(){
	    no++;
		$('#form').append('<tr id="row'+no+'">'+
                        '<td><input type="number" class="form-control form-control-sm" name="name[]" id=""></td>'+
                        '<td><input type="text" class="form-control form-control-sm" name="name[]" id=""></td>'+
                        '<td><input type="text" class="form-control form-control-sm txtCal" name="name[]" id=""></td>'+
                        '<td><button type="button" id="'+no+'" class="btn btn-danger btn_remove">Hapus</button></td></tr>');
        
            $.each(selectValues, function(key, value) {
            $('#nama_barang'+no)
            .append($('<option>', { value : key })
            .text(value));
    });
        Codebase.helpersOnLoad(['jq-select2']);
        });
 
   $.each(selectValues, function(key, value) {
     $('.nama_barang')
          .append($('<option>', { value : key })
          .text(value));
    });
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
    $("#form").on('input', '.txtCal', function () {
       var calculated_total_sum = 0;
     
       $("#form .txtCal").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              calculated_total_sum += parseFloat(get_textbox_value);
              }                  
            });
              $("#total_sum_value").html('Rp '+calculated_total_sum);
       });
       
});
</script>
@endsection