@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Data Area
          </div>
          <div class="block-content text-muted">
            @csrf
            <table id="sample_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>No.</th>
                  <th>Nama Area</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->m_area_nama}}</td>
                    </tr>
                @endforeach
              </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Page Content -->
@endsection
@section('js')
<script type="module" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="module">
  $(document).ready(function(){
    $.ajaxSetup({
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });
      var t = $('#sample_data').DataTable({
      "processing" : false,
      "serverSide" : false,
      "order" : [],
      "dom": "Blfrtip",
        "language": { // language settings
            "GroupActions": "_TOTAL_ records selected:  ",
            "AjaxRequestGeneralError": "Could not complete request. Please check your internet connection",
            "lengthMenu": "<span class='seperator'></span>View _MENU_ records",
            "info": "<span class='seperator'></span>Found total _TOTAL_ records",
            "infoEmpty": "No records found to show",
            "emptyTable": "No data available in table",
            "zeroRecords": "No matching records found",
            "paginate": {
                "previous": "Prev",
                "next": "Next",
                "last": "Last",
                "first": "First",
                "page": "Page",
                "pageOf": "of"
            }
        },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": -1,
    });
    $("#tablecontents").sortable({
      items: "tr",
      cursor: 'move',
      opacity: 0.6,
      update: function() {
          sendOrderToServer();
      }
    });

    function sendOrderToServer() {

  var order = [];
  $('tr.row1').each(function(index,element) {
    order.push({
      id: $(this).attr('data-id'),
      position: index+1
    });
  });
    }

    $('#sample_data').Tabledit({
    url:'{{ route("action.area") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'id'],
      editable:[[1, 'm_area_nama']]
    },
    restoreButton:false,
    onSuccess:function(data, textStatus, jqXHR)
    {
      if (data.action == 'add') {
        window.location.reload();
      }
      if(data.action == 'delete')
      {
        $('#'+data.id).remove();
      }
    }
  });
  $("#sample_data").append(
       $('<tfoot/>').append( $("#sample_data thead tr").clone() )
      );
  });
  </script>
@endsection