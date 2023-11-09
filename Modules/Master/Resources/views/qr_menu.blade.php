@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/mycustom.scss') }}">
@endsection
@section('content')
    <!-- Submenu -->
    <div class="container text-center submenu" id="kategori">
        <div id="button-container"></div>
    </div>

    <!-- Menu List -->
    <div class="container mt-3 menu-list">
        <input class="searchInput" type="text" id="searchInput" placeholder="Cari Menu..." oninput="searchMenu()">
        <div class="menu-container">
        </div>
        <!-- Add more menu items here -->
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script>
        function ucwords(str) {
            return str.toLowerCase().replace(/(?:^|\s)\S/g, function(a) {
                return a.toUpperCase();
            });
        }
        function filterByCategory(category) {
            var menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(function(item) {
                if (item.getAttribute('data-category') === category || category === 'All') {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function showAll() {
            console.log(sessionStorage.getItem("notable"));
            var menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(function(item) {
                item.style.display = 'flex';
            });
        }

        function searchMenu() {
            var input, filter, menuItems, menuItem, itemName, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            menuItems = document.querySelectorAll('.menu-item');

            for (i = 0; i < menuItems.length; i++) {
                menuItem = menuItems[i];
                itemName = menuItem.querySelector('.item-name');
                txtValue = itemName.textContent || itemName.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    menuItem.style.display = 'flex';
                } else {
                    menuItem.style.display = 'none';
                }
            }
        }

        function status_menu(btn) {
            var itemDetails = $(btn).closest('.menu-wrap');
            var m_produk_id = itemDetails.find('.item-id').text();
            var m_w_id = itemDetails.find('.item-m_wid').text();
            console.log(m_w_id);

            const senddata = {
                m_w_id: m_w_id,
                m_produk_id: m_produk_id,
            };

            fetch('/qr/menu_update', {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': $("input[name=_token]").val()
                    },
                    method: 'POST',
                    body: JSON.stringify(senddata),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Handle the response data here if needed
                    console.log(data);
                    if (data.messages == 'tidak') {
                        itemDetails.find('.qr_status_label').text('Non Aktif');
                    } else {
                        itemDetails.find('.qr_status_label').text('Aktif');
                    }

                })
                .catch(error => {
                    console.error('Error posting menu data:', error);
                    // You can add code here to handle the error, like showing an error message to the user.
                });
        }


        window.onscroll = function() {
            var searchInput = document.getElementById('searchInput');
            var kategori = document.getElementById('kategori');
            var header = document.getElementById('page-header');
            var scrollY = window.scrollY;
            var containerOffsetTop = document.querySelector('.container.text-center').offsetTop;

            if (scrollY > containerOffsetTop) {
                searchInput.classList.add('fixed');
                kategori.classList.add('fixed');
                header.style.display = 'none';
            } else {
                searchInput.classList.remove('fixed');
                kategori.classList.remove('fixed');
                header.removeAttribute('style');
            }
        };

        $(document).ready(function() {
            //get menu
            $.ajax({
                url: '/qr/get_menu',
                type: 'GET',
                success: function(response) {
                    $.each(response.kategori, function(index, kategori) {
                        var button = $('<button>', {
                            class: 'btn btn-custom btn-' + kategori.m_jenis_produk_nama
                                .toLowerCase(),
                            text: ucwords(kategori.m_jenis_produk_nama),
                            click: function() {
                                filterByCategory(kategori.m_jenis_produk_nama);
                            }
                        });
                        $('#button-container').append(button);
                    });
                    $.each(response.menu, function(index, menu) {
                        var menuItem = $('<div>', {
                            class: 'menu-wrap',
                            html: $('<div>', {
                                class: 'menu-item',
                                'data-category': menu.m_jenis_produk_nama,
                                html: '<img src="' + (menu.m_produk_image ||
                                        'https://via.placeholder.com/80') +
                                    '" alt="' + menu.m_produk_nama +
                                    '" style="width:80px">' +
                                    '<div class="item-id" style="display: none;">' +
                                    menu.m_produk_id + '</div>' +
                                    '<div class="item-m_wid" style="display: none;">' +
                                    menu.m_w_id + '</div>' +
                                    '<div class="item-details">' +
                                    '<div class="item-note-qty">' +
                                    '<div class="item-name">' + ucwords(menu
                                        .m_produk_nama) + '</div>' +
                                    '<div class="qty">' +
                                    '<div class="form-check form-switch">' +
                                    '<input class="form-check-input qr_status" type="checkbox" role="switch" id="qr_status' +
                                    menu.m_produk_id + '" ' +
                                    (menu.m_menu_harga_qr_status === 'ya' ?
                                        'checked' : '') + '>' +
                                    '<label class="form-check-label qr_status_label" for="qr_status' +
                                    menu.m_produk_id + '">' +
                                    (menu.m_menu_harga_qr_status === 'ya' ?
                                        'Aktif' : 'Non Aktif') + '</label>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' + // close item-note-qty
                                    '</div>' + // close item-details
                                    '</div>' // close menu-item
                            })
                        });
                        $('.menu-container').append(menuItem);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error loading data:", error);
                }
            });
        });
        $(document).on('input', '.qr_status', function() {
            status_menu(this);
        });
    </script>
@endsection
