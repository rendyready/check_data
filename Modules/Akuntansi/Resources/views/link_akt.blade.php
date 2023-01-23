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
                      <form>
                      @foreach ($data as $la)
                          <tr>
                            <td>{{$la->list_akt_nama}}</td>
                            <td>
                            <select class="js-select2 form-control-sm" style="width: 100%" name="no_rekening[]" id="no_rekening" onchange="pilihrek()" >
                              <option>Pilih Rekening</option>
                              @foreach ($rekening as $item)
                              @if ($item->m_rekening_id == $la->link_akt_m_rekening_id)
                              <option value="{{$item->m_rekening_no_akun}}" selected="selected"> {{$item->m_rekening_no_akun}}</option>
                              @else
                              <option value="{{$item->m_rekening_no_akun}}"> {{$item->m_rekening_no_akun}}</option> 
                              @endif
                              @endforeach
                            </select>
                            </td>
                            <td>
                              <input type="text" style="width: 100%">
                           </td> 
                          </tr>
                      @endforeach
                      </form>
                      {{-- @foreach ($listakt as $lakt)
                      <tr>
                        <td>
                          @foreach ($listakt as $lakt)
                          <input type="text" class="form-control form-control-sm" style="width: 100%"value="{{$lakt->list_akt_nama}}" placeholder="{{$lakt->list_akt_nama}}"
                          style="width: 100%;" name="list_akt" id="list_akt">
                          @endforeach
                        </td>
                        <td>
                          @foreach ($listakt as $la)
                          <select class="js-select2 form-control-sm" style="width: 100%" name="no_rekening[]" id="no_rekening" >
                            @foreach ($data as $item)
                            <option value="{{$item->m_rekening_no_akun}}"> {{$item->m_rekening_no_akun}}</option>
                            @endforeach
                          </select>
                          @endforeach
                        </td>
                        <td>
                          @foreach ($listakt as $la)
                          <input type="text" class="form-control form-control-sm" style="width: 100%" 
                          style="width: 100%;" name="nama_akun" id="nama_akun">
                          </select>
                          @endforeach
                        </td>
                        </tr>
                      @endforeach --}}
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
