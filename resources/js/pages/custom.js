(function ($) {
  'use strict';
  $(document).on('input', '.number', function () {
    var angka = $(this).val();
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    angka_hasil     = split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan){
      var separator = sisa ? '.' : '';
      angka_hasil += separator + ribuan.join('.');
    }

    $(this).val(angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] : angka_hasil);
  });
  $(".number").on("keypress", function (evt) {
    $(this).val($(this).val().replace(/[^0-9\.|\,]/g,''));
        if(evt.which == 44)
        {
        return true;
        }
        if ((evt.which != 46 || $(this).val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57  )) {
        
          evt.prevtDefault();
        }
    });
  // $(document).ready(function () {
  //   $("input.mask").each((i,ele)=>{
  //           let clone=$(ele).clone(false)
  //           clone.attr("type","text")
  //           let ele1=$(ele)
  //           clone.val(Number(ele1.val()).toLocaleString("id"))
  //           $(ele).after(clone)
  //           $(ele).hide()
  //           setInterval(()=>{
  //               let newv=Number(ele1.val()).toLocaleString("id")
  //               if(clone.val()!=newv){
  //                   clone.val(newv)
  //               }
  //           },10)
  //           $(ele).mouseleave(()=>{
  //               $(clone).show()
  //               $(ele1).hide()
  //           })
  //       })
  // });
})(jQuery);