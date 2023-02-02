@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              List Akuntansi
          </div>
          <div class="block-content text-muted">
                <form action="{{route('rek_list.save')}} " method="post">
                  @csrf
                <div class="table-responsive">
                <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                  <thead>
                    <th> Isikan Nama List Akuntansi</th>
                </thead>
                    <tbody>
                        <tr>
                        <td>
                        <input type="text" step="" class="form-control form-control-sm" name="list_akt_nama" id="list_akt_nama" 
                        placeholder="Contoh. Hutang Dagang">
                        </td>
                        </tr>
                    </tbody>
                </table>
                <div class="block-content block-content-full text-end bg-transparent">
                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                  </div>
                </div>
                </form>

                <div class="table-responsive">
                    <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                      <thead>
                        <th>No</th>
                        <th>Nama Akun</th>
                    </thead>
                        <tbody>
                          @foreach ($data->listakt as $la)
                          <tr>
                            <td>{{$data->no++}}</td>
                            <td>{{$la->list_akt_nama}}</td>
                            </tr> 
                          @endforeach
                            
                        </tbody>
                    </table>
                    </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Page Content -->
@endsection
