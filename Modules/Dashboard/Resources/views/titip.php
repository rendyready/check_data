$('#cari').click(function(){
        var waroeng  = $('#filter_waroeng').val();
        var tanggal  = $('#filter_tanggal').val();
        var operator = $('#filter_operator').val();    
            $.ajax({
            type:"GET",
            url: '{{route("detail.show")}}',
            dataType: 'JSON',
            data : 
            {
              waroeng: waroeng,
              tanggal: tanggal,
              operator: operator,
            },
            success:function(data){  
              // console.log(data);
              $.each(data.transaksi_rekap, function (key, value) {
                // console.log(item.r_t_id);
                $('#show_nota').append('<div class="col-xl-4" id="sub_nota'+ value.r_t_id +'">'+
                        '<div class="block block-rounded mb-1">'+
                          '<div class="block-header block-header-default block-header-rtl bg-pulse">'+
                            '<h3 class="block-title text-light"><small class="fw-semibold">'+ value.r_t_nota_code +'</small><br><small>Dine-In</small></h3>'+
                            '<div class="alert alert-warning py-2 mb-0">'+
                              '<h3 class="block-title text-black"><i class="fa fa-calendar opacity-50 ms-1"></i> <small>'+ value.r_t_tanggal +'</small>'+
                                '<br><small class="fw-semibold">'+ value.name +'</small></h3>'+
                            '</div>'+
                          '</div>'+
                          '<div class="block-content mb-4" style="background-color: rgba(224, 224, 224, 0.5)">'
                          );
                          
                       
                      $.each(data.detail_nota, function (key, item) {
                        console.log(item.r_t_detail_r_t_id);
                        $('#sub_nota'+ item.r_t_detail_r_t_id).append(
                          '<table class="table table-border" style="font-size: 13px;">'+
                              '<tbody>'+
                                '<tr style="background-color: white;">'+
                                  '<td>'+
                                    '<small class="fw-semibold" style="font-size: 15px;">'+ item.r_t_detail_m_produk_nama +'</small> <br>'+
                                    '<small>'+ item.r_t_detail_qty +' x '+ item.r_t_detail_price +'</small>'+
                                  '</td>'+
                                  '<td class="text-end fw-semibold" >'+ item.r_t_detail_nominal + ''+
                                  '</td>'+
                                '</tr>'+
                              
                                // $('#sub_nota'+ value.r_t_id).append('<tr style="background-color: white;" class="text-end fw-semibold">'+
                                //   '<td>Total</td>'+
                                //   '<td>'+
                                //     ''+ value.r_t_nominal +''+
                                //   '</td>'+
                                // '</tr>'+
                                // '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                //   '<td>Tax (10%)</td>'+
                                //   '<td>'+
                                //     ''+ value.r_t_nominal_pajak +''+
                                //   '</td>'+
                                // '</tr>'+
                                // '<tr style="background-color: white;" class="text-end fw-semibold">'+
                                //   '<td>Bayar</td>'+
                                //   '<td>'+
                                //     ''+ value.r_t_nominal_total_bayar +''+
                                //   '</td>'+
                                // '</tr>'+
                              '</tbody>'+
                            '</table>'+
                          '</div>'+
                        '</div>'+
                      '</div>');
                    });
                    });
            }           
          });           
    });

    // foreach ($transaksi_rekap as $key => $v ) {
    //         $data->transaksi[$v->r_t_id]=$v->r_t_id;
    //         $data->transaksi[$v->r_t_nota_code]=$v->r_t_nota_code;
    //         $data->transaksi[$v->r_t_tanggal]=$v->r_t_tanggal;
    //         $data->transaksi[$v->name]=$v->name;
    //         $data->transaksi[$v->r_t_nominal]=rupiah($v->r_t_nominal);
    //         $data->transaksi[$v->r_t_nominal_pajak]=rupiah($v->r_t_nominal_pajak);
    //         $data->transaksi[$v->r_t_nominal_total_bayar]=$v->r_t_nominal_total_bayar;
    // }
    // foreach ($detail_nota as $key => $v) {
    //     $data->detail[$v->r_t_detail_m_produk_nama]=$v->r_t_detail_m_produk_nama;
    //     $data->detail[$v->r_t_detail_qty]=$v->r_t_detail_qty;
    //     $data->detail[$v->r_t_detail_price]=rupiah($v->r_t_detail_price);
    //     $data->detail[$v->r_t_detail_nominal]=rupiah($v->r_t_detail_nominal);
    // }

    // foreach ($get as $value) {
    //         $row = array();
    //         $row[] = $value->r_t_nota_code;
    //         $row[] = date('d-m-Y', strtotime($value->r_t_tanggal));
    //         $row[] = $value->name;
    //         $row[] = $value->r_t_detail_m_produk_nama;
    //         $row[] = $value->r_t_detail_qty;
    //         $row[] = rupiah($value->r_t_detail_price);
    //         $row[] = rupiah($value->r_t_detail_nominal);
    //         $row[] = rupiah($value->r_t_nominal);
    //         $row[] = rupiah($value->r_t_nominal_pajak);
    //         $row[] = $value->r_t_nominal_total_bayar;
    //         $data[] = $row;
    //     }

    $('#show_nota').hide();

      $('#cari').click(function(){
        var waroeng  = $('#filter_waroeng').val();
        var tanggal  = $('#filter_tanggal').val();
        var operator = $('#filter_operator').val();    
            $.ajax({
            type:"GET",
            url: '{{route("detail.show")}}',
            dataType: 'JSON',
            data : 
            {
              waroeng: waroeng,
              tanggal: tanggal,
              operator: operator,
            },
            success:function(data){  
              $('#show_nota').show();
                $('#no_nota').val(data.r_t_nota_code);
                         
                $.each(data, function (key, value) {
              //     $.each(data, function (key, value, tbl) {
              //     console.log(value=r_t_nota_code);

                $('#no_nota').append(''+ value.r_t_nota_code +'');
              //   $('#tgl_nota').append('');
              //   $('#nama_kons').append('');
              //   $('#nm_produk').append('');
              //   $('#qty_produk').append('');
              //   $('#price_produk').append('');
              //   $('#sub_total').append('');
              //   $('#total').append('');
              //   $('#pajak').append('');
              //   $('#bayar').append('');
                       
                });
              // });
            }           
          });           
    });

    <div class="col-xl-4" id="sub_nota'+val+'">
                        <div class="block block-rounded mb-1">
                          <div class="block-header block-header-default block-header-rtl bg-pulse">
                            <h3 class="block-title text-light"><small class="fw-semibold" id="no_nota"></small><br><small id="ket_trans">Dine-In</small></h3>
                            <div class="alert alert-warning py-2 mb-0">
                              <h3 class="block-title text-black"><i class="fa fa-calendar opacity-50 ms-1"></i> <small id="tgl_nota"></small>
                                <br><small class="fw-semibold" id="nama_kons"></small></h3>
                            </div>
                          </div>
                          <div class="block-content mb-4" style="background-color: rgba(224, 224, 224, 0.5)">
                            <table class="table table-border" style="font-size: 13px;">
                              <tbody>
                                <tr style="background-color: white;">
                                  <td>
                                    <small class="fw-semibold" style="font-size: 15px;" id="nm_produk"></small> <br>
                                    <small id="qty_produk"> x</small><small id="price_produk"></small>
                                  </td>
                                  <td class="text-end fw-semibold" id="sub_total">
                                  </td>
                                </tr>
                                <tr style="background-color: white;" class="text-end fw-semibold">
                                  <td>Total</td>
                                  <td id="total">
                                  </td>
                                </tr>
                                <tr style="background-color: white;" class="text-end fw-semibold">
                                  <td>Tax (10%)</td>
                                  <td id="pajak">
                                  </td>
                                </tr>
                                <tr style="background-color: white;" class="text-end fw-semibold">
                                  <td>Bayar</td>
                                  <td id="bayar">
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>