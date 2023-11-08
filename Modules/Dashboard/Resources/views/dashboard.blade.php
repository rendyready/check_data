@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Check Data Sipedas
                        </h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="rekap_insert">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label">Area</label>
                                        <div class="col-sm-9">
                                            <select id="filter_area2" data-placeholder="Pilih Area" style="width: 100%;"
                                                class="cari f-area js-select2 form-control filter_area"
                                                name="m_w_m_area_id">
                                                <option></option>
                                                {{-- @foreach ($data->area as $area)
                                                    <option value="{{ $area->m_area_id }}"> {{ $area->m_area_nama }}
                                                    </option>
                                                @endforeach --}}
                                                {{-- <option value="all">All Area</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <button type="button" id="cari_member"
                                            class="btn btn-primary btn-sm mb-3 mt-3">Check Data</button>
                                    </div>
                                </div>
                        </form>

                        <div id="member_show" style="display: none;" class="table-responsive text-center">
                            <table id="tampil_rekap"
                                class="table table-sm table-bordered table-hover table-striped table-vcenter js-dataTable-full nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Personel</th>
                                        <th class="text-center">ID Personel</th>
                                        <th class="text-center">Rangking</th>
                                        <th class="text-center">Belanja WBD</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
<script type="module">
    $(document).ready(function() {
        Codebase.helpersOnLoad(['jq-select2']);
    });
</script>
