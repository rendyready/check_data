@extends('layouts.app')
@section('content')
  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
      <div class="col-md-12 col-xl-12">
        <div class="block block-themed h-100 mb-0">
          <div class="block-header bg-pulse">
            <h3 class="block-title">
              Data Jenis Menu
          </div>
          <div class="block-content text-muted">
            @csrf
            <table id="jenis_menu" class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>NAMA JENIS MENU</th>
                  <th>ODCR55 JENIS MENU</th>
                  <th>URUT JENIS MENU</th>
              </tr>
              </thead>
              <tbody id="tablecontents">
                @foreach ($data as $item)
                    <tr class="row1">
                      <td>{{$item->id}}</td>
                      <td>{{$item->m_menu_jenis_nama}}</td>
                      <td>{{$item->m_menu_jenis_odcr55}}</td>
                      <td>{{$item->m_menu_jenis_urut}}</td>
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
      var t = $('#jenis_menu').DataTable({
        processing : false,
        serverSide : false,
        destroy: true,
        order : [3,'asc'],
      });
    $("#tablecontents").sortable({
      opacity: 0.7,
      items: 'tr',
        cursor: 'pointer',
        axis: 'y',
        dropOnEmpty: false,
        start: function (e, ui) {
            ui.item.addClass("selected");
        },
        stop: function (e, ui) {
            ui.item.removeClass("selected");
            $(this).find("tr").each(function (index) {
                if (index >= 0) {
                    $(this).find("td").eq(3).html(index+1);
                }
            });
        },
        update: function() {
          sendOrderToServer();
      }
    });

    function sendOrderToServer() {

      var order = [];
      $('tr.row1').each(function(index,element) {
        order.push({
          id: $(this).attr('id'),
          position: index+1
        });
      });
      
      $.ajax({
        type: "POST", 
        dataType: "json", 
        url: '{{route("sort.jenis_menu")}}',
        data: {
          order:order,
          _token: '{{csrf_token()}}'
        },
        success: function(response) {
            if (response.status == "success") {
              console.log(response);
            } else {
              console.log(response);
            }
        }
      });
    }

    $('#jenis_menu').Tabledit({
    url:'{{ route("action.jenis_menu") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'id'],
      editable:[[1, 'm_menu_jenis_nama'],[2,'m_menu_jenis_odcr55','{"makan": "makan", "minum": "minum"}']]
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
  $("#jenis_menu").append(
       $('<tfoot/>').append( $("#jenis_menu thead tr").clone() )
      );
  });
  </script>
@endsection