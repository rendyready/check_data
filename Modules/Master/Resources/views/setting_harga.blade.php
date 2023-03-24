@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Setting Harga Nota
                    </div>
                    <div class="block-content text-muted">
                        <a class="btn btn-success mr-5 mb-5 buttonInsert" value="" title="Edit" style="color: #fff"><i
                                class="fa fa-plus mr-5"></i> Harga Nota</a>
                        <a class="btn btn-info mr-5 mb-5 buttonCopy" value="" title="copy" style="color: #fff"><i
                                class="fa fa-copy mr-5"></i> Copy Nota</a>
                        <a class="btn btn-warning mr-5 mb-5 buttonUpdate" value="" title="update"
                            style="color: #fff"><i class="fa fa-refresh mr-5"></i> Update Harga</a>
                        @csrf
                        <table id="my_table" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Waroeng</th>
                                    <th>Jenis Transaksi</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                              @php
                                  $no=1;
                              @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $no++; }}</td>
                                        <td>{{ $item->m_w_nama }}</td>
                                        <td>{{ $item->m_t_t_name }}</td>
                                        <td> <a class="btn btn-info buttonEdit" value="{{ $item->m_jenis_nota_id }}"
                                                title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('m_jenis_nota.detail_harga', $item->m_jenis_nota_id) }}"
                                                class="btn btn-warning" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            {{-- <a href="{{route('m_jenis_nota.hapus',$item->m_jenis_nota_id)}}" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Select2 in a modal -->
        <div class="modal" id="modal-block-select2" tabindex="-1" role="dialog" aria-labelledby="modal-block-select2"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed shadow-none mb-0">
                        <div class="block-header block-header-default bg-pulse">
                            <h3 class="block-title" id="myModalLabel"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <!-- Select2 is initialized at the bottom of the page -->
                            <form method="post" action="" id="formAction">
                                @csrf
                                <div class="mb-4">
                                    <input name="m_jenis_nota_id" type="hidden" id="m_jenis_nota_id">
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_jenis_nota_m_w_id">Nama Waroeng</label>
                                        <div>
                                            <select class="js-select2" id="m_jenis_nota_m_w_id" name="m_jenis_nota_m_w_id"
                                                style="width: 100%;" data-container="#modal-block-select2"
                                                data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($listWaroeng as $wr)
                                                    <option value="{{ $wr->m_w_id }}">{{ ucwords($wr->m_w_nama) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_jenis_nota_m_t_t_id">Jenis Transaksi</label>
                                        <div>
                                            <select class="js-select2" id="m_jenis_nota_m_t_t_id"
                                                name="m_jenis_nota_m_t_t_id" style="width: 100%;"
                                                data-container="#modal-block-select2" data-placeholder="Choose one..">
                                                <option></option>

                                                @foreach ($listTipeTransaksi as $tipe)
                                                    <option value="{{ $tipe->m_t_t_id }}">{{ ucwords($tipe->m_t_t_name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content block-content-full text-end bg-transparent">
                                    <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Select2 in a modal tambah nota-->
        <!-- Select2 in a modal copy nota -->
        <div class="modal" id="copy_nota" tabindex="-1" role="dialog" aria-labelledby="copy_nota" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed shadow-none mb-0">
                        <div class="block-header block-header-default bg-pulse">
                            <h3 class="block-title" id="myModalLabel2"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <!-- Select2 is initialized at the bottom of the page -->
                            <form method="post" action="" id="formAction2">
                                @csrf
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_jenis_nota_trans_id">Jenis Transaksi</label>
                                        <div>
                                            <select class="js-select2" id="m_jenis_nota_trans_id"
                                                name="m_jenis_nota_trans_id" style="width: 100%;"
                                                data-container="#copy_nota" data-placeholder="Choose one..">
                                                <option></option>

                                                @foreach ($listTipeTransaksi as $tipe)
                                                    <option value="{{ $tipe->m_t_t_id }}">{{ ucwords($tipe->m_t_t_name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_jenis_nota_waroeng_sumber_id">Sumber Nota Waroeng</label>
                                        <div>
                                            <select class="js-select2" id="m_jenis_nota_waroeng_sumber_id"
                                                name="m_jenis_nota_waroeng_sumber_id" style="width: 100%;"
                                                data-container="#copy_nota" data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($listWaroeng as $wr)
                                                    <option value="{{ $wr->m_w_id }}">{{ ucwords($wr->m_w_nama) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_jenis_nota_waroeng_tujuan_id">Tujuan Nota Waroeng</label>
                                        <div>
                                            <select class="js-select2" id="m_jenis_nota_waroeng_tujuan_id"
                                                name="m_jenis_nota_waroeng_tujuan_id" style="width: 100%;"
                                                data-container="#copy_nota" data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($listWaroeng as $wr)
                                                    <option value="{{ $wr->m_w_id }}">{{ ucwords($wr->m_w_nama) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content block-content-full text-end bg-transparent">
                                    <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Select2 in a modal copy nota-->
        <!-- Select2 in a modal update harga -->
        <div class="modal" id="update_harga" tabindex="-1" role="dialog" aria-labelledby="update_harga"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed shadow-none mb-0">
                        <div class="block-header block-header-default bg-pulse">
                            <h3 class="block-title" id="myModalLabel3"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <!-- Select2 is initialized at the bottom of the page -->
                            <form method="post" action="" id="formAction3">
                                @csrf
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_produk_id">Nama Menu</label>
                                        <div>
                                            <select class="js-select2" id="m_produk_id" name="m_produk_id"
                                                style="width: 100%;" data-container="#update_harga"
                                                data-placeholder="Choose one..">
                                                <option></option>
                                                @foreach ($produk as $val)
                                                    <option value="{{ $val->m_produk_id }}">
                                                        {{ ucwords($val->m_produk_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="m_area_id">Area</label>
                                        <div>
                                            <select class="js-select2" id="m_area_id" name="m_area_id"
                                                style="width: 100%;" data-container="#update_harga"
                                                data-placeholder="Choose one..">
                                                <option></option>
                                                <option value="0">All Area</option>
                                                @foreach ($area as $val)
                                                    <option value="{{ $val->m_area_id }}">
                                                        {{ ucwords($val->m_area_nama) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                  <div class="form-group">
                                      <label for="update_m_jenis_nota_trans_id">Jenis Transaksi</label>
                                      <div>
                                          <select class="js-select2" id="update_m_jenis_nota_trans_id"
                                              name="update_m_jenis_nota_trans_id" style="width: 100%;"
                                              data-container="#update_harga" data-placeholder="Choose one..">
                                              <option></option>
                                              @foreach ($listTipeTransaksi as $tipe)
                                                  <option value="{{ $tipe->m_t_t_id }}">{{ ucwords($tipe->m_t_t_name) }}
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                              </div>
                                <div class="mb-4">
                                  <div class="form-group">
                                    <label for="nota a">Harga Nota A</label>
                                    <input type="hidden" value="nota a" name="nota_kode[]">
                                      <input type="text" class="form-control number" name="nom_harga[]">
                                  </div>
                                </div>
                                <div class="mb-4">
                                  <div class="form-group">
                                    <label for="nota b">Harga Nota B</label>
                                    <input type="hidden" value="nota b" name="nota_kode[]">
                                      <input type="text" class="form-control number" name="nom_harga[]">
                                  </div>
                                </div>
                                <div class="block-content block-content-full text-end bg-transparent">
                                    <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Select2 in a modal update harga-->
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script type="module">
  $(document).ready(function(){
      Codebase.helpersOnLoad(['jq-select2', 'jq-rangeslider']);
      $(".buttonInsert").on('click', function() {
            $("#myModalLabel").html('Tambah Harga Nota');
            $("#formAction").attr('action',"/master/m_jenis_nota/store");
            $("#modal-block-select2").modal('show');
      });
      $(".buttonCopy").on('click', function() {
            $("#myModalLabel2").html('Copy Harga Nota');
            $("#formAction2").attr('action',"/master/m_jenis_nota/copy");
            $("#copy_nota").modal('show');
      });
      $(".buttonUpdate").on('click', function() {
            $("#myModalLabel3").html('Update Harga Nota');
            $("#formAction3").attr('action',"/master/m_jenis_nota/update");
            $("#update_harga").modal('show');
      });
      $(".buttonEdit").on('click', function() {
          var id = $(this).attr('value');
          $("#myModalLabel").html('Ubah Harga Nota');
          $("#formAction").attr('action','/master/m_jenis_nota/store');
          $.ajax({
              url: "/master/m_jenis_nota/show/"+id,
              type: "GET",
              dataType: 'json',
              success: function(respond) {
                console.log(respond)
                  $("#m_jenis_nota_id").val(respond.m_jenis_nota_id).trigger('change');
                  $("#m_jenis_nota_m_w_id").val(respond.m_jenis_nota_m_w_id).trigger('change');
                  $("#m_jenis_nota_m_t_t_id").val(respond.m_jenis_nota_m_t_t_id).trigger('change');
              },
              error: function() {
              }
          });
          $("#modal-block-select2").modal('show');
      }); 
      $("#my_table").append(
          $('<tfoot/>').append( $("#my_table thead tr").clone() )
      );
  });
  </script>
@endsection
