//java rubah numeric ke indo
function dec_indo(number) {
    var saldo = number.toString().replace(".", ",");
    var saldo_formatted = saldo.replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1.");
    return saldo_formatted;
}
//notifikasi
function displayNotification(type, message) {
    Codebase.helpers('jq-notify', {
        align: 'right',
        from: 'top',
        type: type,
        icon: 'fa fa-info me-5',
        message: message
    });
}
function texttoarray(arr1) {
    var arr = arr1.slice(1, -1).split(", ") // Menghapus kurung siku dan memisahkan string dengan koma dan spasi
             .map(function(item) { // Mengubah setiap elemen menjadi angka
               return parseInt(item);
             });
}
//Select2
$(document).ready(function () {
    // Mencari elemen select2
    var select2_elem = $(".js-select2");
    // Menambahkan validasi required pada elemen select2
    select2_elem.on("select2:close", function () {
        if (!$(this).val()) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });
});
$(document).on("select2:open", () => {
    document.querySelector(".select2-search__field").focus();
});
//end select2
(function ($) {
    "use strict";
    $(document).on("input", ".number", function () {
        var angka = $(this).val();
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            angka_hasil = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            var separator = sisa ? "." : "";
            angka_hasil += separator + ribuan.join(".");
        }

        $(this).val(
            (angka_hasil =
                split[1] != undefined
                    ? angka_hasil + "," + split[1]
                    : angka_hasil)
        );
    });

    $(".number").on("keypress", function (evt) {
        $(this).val(
            $(this)
                .val()
                .replace(/[^0-9\.|\,]/g, "")
        );
        if (evt.which == 44) {
            return true;
        }
        if (
            (evt.which != 46 || $(this).val().indexOf(".") != -1) &&
            (evt.which < 48 || evt.which > 57)
        ) {
            evt.prevtDefault();
        }
    });
    //prevent duplicate value, default option value must be "0"
    $(document)
        .on("select2:open", ".nama_barang", function () {
            var index = $(this).attr("id");
            $(this).data("val", $(this).val());
            $(this).data("id", index);
            var g_id = $(".gudang_code").val();
            if (g_id == "") {
                Codebase.helpers("jq-notify", {
                    align: "right", // 'right', 'left', 'center'
                    from: "top", // 'top', 'bottom'
                    type: "danger", // 'info', 'success', 'warning', 'danger'
                    icon: "fa fa-info me-5", // Icon class
                    message: "Pilih Gudang Dahulu",
                });
            }
        })
        .on("change", ".nama_barang", function (e) {
            var prev = $(this).data("val");
            var current = $(this).val();
            var id = $(this).data("id");
            var satuanId = $(this).closest("tr").find(".satuan").attr("id");
            var stoksisa = $(this).closest("tr").find(".stok").attr("id");
            var gudangId = $(".gudang_code").val();
            var hppId = $(this).closest("tr").find(".hpp").attr("id");
            console.log('hppid'+hppId);
            console.log('satuanid'+satuanId);
            console.log('stoksisa'+stoksisa);
            $.get(
                "/inventori/stok_harga/" + gudangId + "/" + current,
                function (data) {
                    console.log(data);
                    $("#" + hppId).val(dec_indo(data.m_stok_hpp));
                    $("#" + satuanId).val(data.m_stok_satuan);
                    $("#" + stoksisa).html("stok : " + dec_indo(data.m_stok_saldo));
                }
            );
            if (!current) {
                // If the selected value is empty, skip the duplicate value check
                return;
            }
            var values = $(".nama_barang")
                .map(function () {
                    return this.value.trim();
                })
                .get();
            var filteredValues = values.filter(function (value) {
                return value !== "";
            });
            var unique = [...new Set(filteredValues)];
            if (filteredValues.length !== unique.length) {
                e.preventDefault();
                Codebase.helpers("jq-notify", {
                    align: "right", // 'right', 'left', 'center'
                    from: "top", // 'top', 'bottom'
                    type: "danger", // 'info', 'success', 'warning', 'danger'
                    icon: "fa fa-info me-5", // Icon class
                    message: "Nama Barang Telah Ada",
                });
                $("#" + id)
                    .val(prev)
                    .trigger("change");
            }
        });
    //end prevent duplicate value
})(jQuery);
