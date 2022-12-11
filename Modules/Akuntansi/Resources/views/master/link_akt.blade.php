@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Form Input Link Akuntansi
          </div>
          <div class="block-content text-muted">
                <form action="#" method="post">
                <div class="table-responsive">
                <table id="form" class="table table-sm table-bordered table-striped table-vcenter">
                  <thead>
                    <th>Link Akuntansi</th>
                    <th>No Rekening</th>
                    <th>Nama Akun</th>
                </thead>
                    <tbody>
                        <tr>
                        <td><select class="js-select2 form-control-sm" style="width: 100%;" name="no_rekening[]" id="no_rekening" >
                          @foreach ($listakt as $lst)
                          <option value="{{ $lst->list_akt_nama}}"> {{$lst->list_akt_nama}}</option>
                          @endforeach
                        </select></td>
                        <td>
                              <select class="js-select2 form-control-sm" style="width: 100%;" name="no_rekening[]" id="no_rekening" >
                                @foreach ($data as $item)
                                <option value="{{ $item->m_rekening_no_akun}}"> {{$item->m_rekening_no_akun}}</option>
                                @endforeach
                              </select>
                        </td>
                        <td>
                          {{-- <select class="js-select2 form-control-sm" style="width: 100%;" name="no_rekening[]" id="no_rekening" >
                          @foreach ($data as $item)
                          <option value="{{ $item->m_rekening_nama}}"> {{$item->m_rekening_nama}}</option>
                          @endforeach
                        </select> --}}
                        </td>
                        </tr>
                    </tbody>
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
