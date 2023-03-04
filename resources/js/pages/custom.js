    function formatRupiah(angka) {
      var rupiah = '';    
      var angkarev = angka.toString().split('').reverse().join('');
      for(var i = 0; i < angkarev.length; i++) {
        if(i%3 == 0) {
          rupiah += angkarev.substr(i,3)+'.';        
        }
      }
      return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    }

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

  // $(".number").on("keypress", function (evt) {
  //   if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
  //   {
  //       evt.preventDefault();
  //   }
  //   });
})(jQuery);