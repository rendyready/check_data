@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="col-md-12 col-xl-12">
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">
                            Check Data
                        </h3>
                    </div>
                    <div class="block-content text-muted">
                        <form id="rekap_insert">

                            <div class="row">
                                <div class="col-sm-2">
                                    {{-- <div class="row mb-2">
                                        <div class="col-sm-8"> --}}
                                    <button type="button" id="check_data" class="btn btn-primary btn-md col-2 mt-2 mb-3"
                                        style="width: 100%;">Check
                                        Data <span id="export_loading" style="display: none;"><img
                                                src="{{ asset('media/gif/loading.gif') }}" alt="Loading..."
                                                style="max-width: 20px; max-height: 20px;"></span></button>
                                    {{-- </div>
                                    </div> --}}
                                </div>

                                <div class="col-sm-7">
                                    {{-- <div class="row mb-2"> --}}
                                    <div class="col-sm-3">
                                        <button type="button" id="button_refresh"
                                            class="btn btn-info btn-md col-2 mt-2 mb-3" style="width: 100%;">Refresh
                                            Table</button>
                                    </div>
                                    {{-- </div> --}}
                                </div>
                            </div>


                        </form>

                        <div id="tampil_count">
                            {{-- <div id="log_messages"></div> --}}
                            <table id="tampil_count_data"
                                class="table table-sm table-bordered table-striped table-vcenter nowrap table-hover js-dataTable-full"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">ID Waroeng</th>
                                        <th class="text-center">Waroeng</th>
                                        <th class="text-center">Nama Table</th>
                                        <th class="text-center">Jumlah Pusat</th>
                                        <th class="text-center">Jumlah Area</th>
                                        <th class="text-center">Last Check</th>
                                    </tr>
                                </thead>
                                <tbody id="show_data">
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <div id="log_messages" class="pr-2 pt-2 pb-2"></div>
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

            function formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            $('#filter_tanggal').flatpickr({
                mode: "range",
                dateFormat: 'Y-m-d',
            });

            $('#check_data').on('click', function() {
                $('#export_loading').show();

                $.ajax({
                    type: "GET",
                    url: '{{ route('count.count_data') }}',
                    success: function(res) {
                        console.log(res);
                        if (res) {
                            $('#export_loading').hide();
                            $('#log_messages').html(res);
                        }
                    }
                });
            })

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // +1 karena Januari dimulai dari 0
            var yyyy = today.getFullYear();
            var firstDayOfMonth = yyyy + '-' + mm + '-01'; // Awal bulan
            var tanggal = firstDayOfMonth + ' to ' + yyyy + '-' + mm + '-' + dd;
            console.log(tanggal);

            var table = $('#tampil_count_data').DataTable({
                destroy: true,
                orderCellsTop: true,
                processing: true,
                scrollX: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                pageLength: 10,
                columnDefs: [{
                    targets: '_all',
                    className: 'dt-body-center'
                }, ],
                buttons: [],
                ajax: {
                    url: '{{ route('count.tampil') }}',
                    type: "GET",
                    data: {
                        tanggal: tanggal,
                    },
                },
                success: function(data) {
                    console.log(data);
                }
            });

            $('#button_refresh').click(function() {
                table.ajax.reload();
            });

        });
    </script>
@endsection
