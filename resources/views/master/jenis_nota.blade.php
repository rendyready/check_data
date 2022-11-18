@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="blocitem blocitem-themed h-100 mb-0">
          <div class="blocitem-header bg-pulse">
            <h3 class="blocitem-title">
              NOTA
          </div>
          <div class="blocitem-content text-muted">
            @csrf
            <table id="m_jenis_nota" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
                <th>ID</th>
                <th>NAMA WAROENG</th>
                <th>NAMA NOTA</th>
                <th>KELOMPOK Nota</th>
                <th>JUMLAH MENU</th>
                <th>ACTION</th>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr>
                      <td>{{$item->m_jenis_nota_id}}</td>
                      <td>{{$item->m_w_nama}}</td>
                      <td>{{$item->m_jenis_nota_nama}}</td>
                      <td>{{$item->m_jenis_nota_group}}</td>
                      <td>{{$item->total}}</td>
                      <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-fadein"><i class="fa fa-edit"></i></button>        
                        </button>
                        <a href="{{route('m_jenis_nota.index',$item->m_jenis_nota_id)}}"
                           class="btn btn-info" title="Detail">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button id="deletem_jenis_nota{{$item->m_jenis_nota_id}}" class="btn btn-danger">
                            <i class="fa fa-eraser"></i>
                        </button>
                    </td>
                    </tr>
                @endforeach
              </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Fade In Modal -->
  <div class="modal fade" id="modal-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-themed shadow-none mb-0">
          <div class="block-header block-header-default bg-pulse">
            <h3 class="block-title">Nota</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content fs-sm">
            @csrf
            <form action="#">
              <div class="mb-4">
                <label class="form-label" for="example-text-input">Nama Nota</label>
                <input type="text" class="form-control" id="m_jenis_nota_nama" name="m_jenis_nota_nama" placeholder="Masukan Nama">
              </div>
              <div class="mb-4">
                <label class="form-label" for="m_jenis_nota_sumber">Nota Sumber</label>
                <select class="form-select" id="m_jenis_nota_sumber" name="m_jenis_nota_sumber">
                  <option selected="">Pilih Sumber Nota</option>
                    @foreach ($data as $list)
                        <option value="{{$list->m_jenis_nota_id}}">{{$list->m_jenis_nota_nama}}</option>
                    @endforeach
                </select>
              </div>
              <div class="mb-4">
                <label class="form-label" for="m_jenis_nota_sumber">Kelompok Jenis Nota</label>
                <select class="form-select" id="m_jenis_nota_sumber" name="m_jenis_nota_sumber">
                  <option selected="">Search</option>
                  <option value="Nota A">Nota A</option>
                  <option value="Nota B">Nota B</option>  
                </select>
              </div>
            </form>
          </div>
          <div class="block-content block-content-full block-content-sm text-end border-top">
            <button type="button" class="btn btn-alt-warning" data-bs-dismiss="modal">
              Close
            </button>
            <button type="button" class="btn btn-alt-success" data-bs-dismiss="modal">
              Simpan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Fade In Modal -->
  <!-- END Page Content -->
@endsection
@section('js')
<script type="module">
  $(document).ready(function(){
    $.ajaxSetup({
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });
      var t = $('#m_jenis_nota').DataTable({
        processing : false,
        serverSide : false,
        destroy: true,
        order : [0,'asc'],
      });
     $("#m_jenis_nota").append(
       $('<tfoot/>').append( $("#m_jenis_nota thead tr").clone() )
      );

      
  });
  </script>
@endsection