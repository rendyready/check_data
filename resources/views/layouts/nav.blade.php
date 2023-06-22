<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="space-x-1">
            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- END Toggle Sidebar -->

            <!-- Open Search Section -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="space-x-1">
            <!-- User Dropdown -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block fw-semibold">{{ strtoupper($waroeng) }}</span>
                    <i class="fa fa-angle-down opacity-50 ms-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0"
                    aria-labelledby="page-header-user-dropdown">
                    <div class="px-2 py-3 bg-body-light rounded-top">
                        <h5 class="h6 text-center mb-0">
                            {{ Auth::user()->name }}
                        </h5>
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1"
                            href="javascript:void(0)" onclick="event.stopPropagation();">
                            <div class="form-group">
                                <select class="js-select2-nav" id="waroeng_default" name="waroeng_id" style="width: 100%;"
                                    data-placeholder="Ganti Waroeng">
                                    <option></option>
                                </select>
                            </div>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1"
                            href="javascript:void(0)" onclick="event.stopPropagation();">
                            <span>Sign Out</span>
                            <i class="fa fa-fw fa-sign-out-alt opacity-25"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- END User Dropdown -->

            <!-- Notifications -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-notifications"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-flag"></i>
                    <span class="text-primary">&bull;</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications">
                    <div class="px-2 py-3 bg-body-light rounded-top">
                        <h5 class="h6 text-center mb-0">
                            Notifications
                        </h5>
                    </div>
                    <ul class="nav-items my-2 fs-sm">
                        <li>
                            <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                <div class="flex-shrink-0 me-2 ms-3">
                                    <i class="fa fa-fw fa-check text-success"></i>
                                </div>
                                <div class="flex-grow-1 pe-2">
                                    <p class="fw-medium mb-1">You’ve upgraded to a VIP account successfully!</p>
                                    <div class="text-muted">15 min ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                <div class="flex-shrink-0 me-2 ms-3">
                                    <i class="fa fa-fw fa-exclamation-triangle text-warning"></i>
                                </div>
                                <div class="flex-grow-1 pe-2">
                                    <p class="fw-medium mb-1">Please check your payment info since we can’t validate
                                        them!</p>
                                    <div class="text-muted">50 min ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                <div class="flex-shrink-0 me-2 ms-3">
                                    <i class="fa fa-fw fa-times text-danger"></i>
                                </div>
                                <div class="flex-grow-1 pe-2">
                                    <p class="fw-medium mb-1">Web server stopped responding and it was automatically
                                        restarted!</p>
                                    <div class="text-muted">4 hours ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                <div class="flex-shrink-0 me-2 ms-3">
                                    <i class="fa fa-fw fa-exclamation-triangle text-warning"></i>
                                </div>
                                <div class="flex-grow-1 pe-2">
                                    <p class="fw-medium mb-1">Please consider upgrading your plan. You are running out
                                        of space.</p>
                                    <div class="text-muted">16 hours ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                <div class="flex-shrink-0 me-2 ms-3">
                                    <i class="fa fa-fw fa-plus text-primary"></i>
                                </div>
                                <div class="flex-grow-1 pe-2">
                                    <p class="fw-medium mb-1">New purchases! +$250</p>
                                    <div class="text-muted">1 day ago</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="p-2 bg-body-light rounded-bottom">
                        <a class="dropdown-item text-center mb-0" href="javascript:void(0)">
                            <i class="fa fa-fw fa-flag opacity-50 me-1"></i> View All
                        </a>
                    </div>
                </div>
            </div>
            <!-- END Notifications -->

            <!-- Toggle Side Overlay -->
            <!-- END Toggle Side Overlay -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Loader -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="far fa-sun fa-spin text-white"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header justify-content-lg-center">
            <!-- Logo -->
            <div>
                <span class="smini-visible fw-bold tracking-wide fs-lg">
                    S<span class="text-primary">P</span>
                </span>
                <a class="link-fx fw-bold tracking-wide mx-auto" href="/">
                    <span class="smini-hidden">
                        <i class="fa fa-fire text-primary"></i>
                        <span class="fs-4 text-dual">Sipedas</span><span class="fs-4 text-primary">V4</span>
                    </span>
                </a>
            </div>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout"
                    data-action="sidebar_close">
                    <i class="fa fa-fw fa-times"></i>
                </button>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
        <!-- END Side Header -->

        <!-- Sidebar Scrolling -->
        <div class="js-sidebar-scroll">
            <!-- Side User -->
            <div class="content-side content-side-user px-0 py-0">
                <!-- Visible only in mini mode -->
                <div class="smini-visible-block animated fadeIn px-3">
                    <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar15.jpg') }}"
                        alt="">
                </div>
                <!-- END Visible only in mini mode -->
                <!-- Visible only in normal mode -->
                <div class="smini-hidden text-center mx-auto">
                    <a class="img-link" href="javascript:void(0)">
                        <img class="img-avatar" src="{{ asset('media/avatars/avatar15.jpg') }}" alt="">
                    </a>
                    <ul class="list-inline mt-3 mb-0">
                        <li class="list-inline-item">
                            <a class="link-fx text-dual fs-sm fw-semibold text-uppercase"
                                href="javascript:void(0)">{{ Auth::user()->name }}</a>
                        </li>
                        <li class="list-inline-item">
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <a class="link-fx text-dual" data-toggle="layout" data-action="dark_mode_toggle"
                                href="javascript:void(0)">
                                <i class="fa fa-burn"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="link-fx text-dual" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- END Visible only in normal mode -->
            </div>
            <!-- END Side User -->

            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                <ul class="nav-main">
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="/dashboard">
                            <i class="nav-main-link-icon fa fa-house-user"></i>
                            <span class="nav-main-link-name">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-main-heading">Menu</li>
                    @can('module cr55.view')
                        <li class="nav-main-item{{ request()->is('master/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-lightbulb"></i>
                                <span class="nav-main-link-name">CR55</span>
                            </a>
                            <ul class="nav-main-submenu">
                                @can('setting cr.view')
                                    <li class="nav-main-item{{ request()->is('master/*') ? ' open' : '' }}">
                                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                            aria-haspopup="true" aria-expanded="true" href="#">
                                            <span class="nav-main-link-name">Setting CR</span>
                                        </a>
                                        <ul class="nav-main-submenu">
                                            @can('daftar produk.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_produk') ? ' active' : '' }}"
                                                        href="{{ route('m_produk.index') }}">
                                                        <span class="nav-main-link-name">Daftar Produk</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('subjenis produk.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_produk_relasi') ? ' active' : '' }}"
                                                        href="{{ route('m_produk_relasi.index') }}">
                                                        <span class="nav-main-link-name">Set. Sub Jenis Produk</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('setting harga.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_jenis_nota') ? ' active' : '' }}"
                                                        href="{{ route('m_jenis_nota.index') }}">
                                                        <span class="nav-main-link-name">Setting Harga</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('setting meja.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/meja') ? ' active' : '' }}"
                                                        href="{{ route('meja.index') }}">
                                                        <span class="nav-main-link-name">Setting Meja</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('seting footer.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/conf_footer') ? ' active' : '' }}"
                                                        href="{{ route('conf_footer.index') }}">
                                                        <span class="nav-main-link-name">Footer Waroeng</span>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan
                                @can('master cr.view')
                                    <li class="nav-main-item{{ request()->is('master/*') ? ' open' : '' }}">
                                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                            aria-haspopup="true" aria-expanded="true" href="#">
                                            <span class="nav-main-link-name">Master</span>
                                        </a>
                                        <ul class="nav-main-submenu">
                                            @can('area.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/area') ? ' active' : '' }}"
                                                        href="{{ route('area.index') }}">
                                                        <span class="nav-main-link-name">Area</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('tipe waroeng.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_w_jenis') ? ' active' : '' }}"
                                                        href="{{ route('m_w_jenis.index') }}">
                                                        <span class="nav-main-link-name">Tipe Waroeng</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('pajak.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_pajak') ? ' active' : '' }}"
                                                        href="{{ route('m_pajak.index') }}">
                                                        <span class="nav-main-link-name">Pajak</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('service charge.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_sc') ? ' active' : '' }}"
                                                        href="{{ route('m_sc.index') }}">
                                                        <span class="nav-main-link-name">Service Charge</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('waroeng.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_waroeng') ? ' active' : '' }}"
                                                        href="{{ route('m_waroeng.index') }}">
                                                        <span class="nav-main-link-name">Waroeng</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('jenis produk.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/jenis_menu') ? ' active' : '' }}"
                                                        href="{{ route('jenis_menu.index') }}">
                                                        <span class="nav-main-link-name">Jenis Produk</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('klasifikasi produk.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_klasifikasi') ? ' active' : '' }}"
                                                        href="{{ route('m_klasifikasi.index') }}">
                                                        <span class="nav-main-link-name">Klasifikasi Produk</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('m_subjenis produk.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/sub_jenis_menu') ? ' active' : '' }}"
                                                        href="{{ route('sub_jenis_menu.index') }}">
                                                        <span class="nav-main-link-name">Sub Jenis Produk</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('modal tipe.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/modal_tipe') ? ' active' : '' }}"
                                                        href="{{ route('modal_tipe.index') }}">
                                                        <span class="nav-main-link-name">Modal Tipe</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('jenis meja.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_jenis_meja') ? ' active' : '' }}"
                                                        href="{{ route('m_jenis_meja.index') }}">
                                                        <span class="nav-main-link-name">Jenis Meja</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('transaksi tipe.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_transaksi_tipe') ? ' active' : '' }}"
                                                        href="{{ route('m_transaksi_tipe.index') }}">
                                                        <span class="nav-main-link-name">Transaksi Tipe</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('satuan.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_satuan') ? ' active' : '' }}"
                                                        href="{{ route('m_satuan.index') }}">
                                                        <span class="nav-main-link-name">Satuan</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('plot produksi.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/plot-produksi') ? ' active' : '' }}"
                                                        href="{{ route('plot-produksi.index') }}">
                                                        <span class="nav-main-link-name">Plot Produksi</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('level jabatan.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/level-jabatan') ? ' active' : '' }}"
                                                        href="{{ route('level-jabatan.index') }}">
                                                        <span class="nav-main-link-name">Level jabatan</span>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan
                                @can('laporan cr.view')
                                    <li class="nav-main-item{{ request()->is('dashboard/*') ? ' open' : '' }}">
                                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                            aria-haspopup="true" aria-expanded="true" href="#">
                                            <span class="nav-main-link-name">Laporan CR55</span>
                                        </a>
                                        <ul class="nav-main-submenu">
                                            @can('detail nota.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/detail') ? ' active' : '' }}"
                                                        href="{{ route('detail.index') }}">
                                                        <span class="nav-main-link-name">Detail Nota</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap nota.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/rekap') ? ' active' : '' }}"
                                                        href="{{ route('rekap.index') }}">
                                                        <span class="nav-main-link-name">Rekap Nota</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap nota harian.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/harian') ? ' active' : '' }}"
                                                        href="{{ route('harian.index') }}">
                                                        <span class="nav-main-link-name">Rekap Nota Harian</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap menu summary.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/rekap_menu') ? ' active' : '' }}"
                                                        href="{{ route('rekap_menu.index') }}">
                                                        <span class="nav-main-link-name">Rekap Menu Summary</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap menu tarikan.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/menu_harian') ? ' active' : '' }}"
                                                        href="{{ route('menu_harian.index') }}">
                                                        <span class="nav-main-link-name">Rekap Menu Tarikan</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap refund.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/rekap_refund') ? ' active' : '' }}"
                                                        href="{{ route('rekap_refund.index') }}">
                                                        <span class="nav-main-link-name">Rekap Refund</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap lostbill.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/rekap_lostbill') ? ' active' : '' }}"
                                                        href="{{ route('rekap_lostbill.index') }}">
                                                        <span class="nav-main-link-name">Rekap Lostbill</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap garansi.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/rekap_garansi') ? ' active' : '' }}"
                                                        href="{{ route('rekap_garansi.index') }}">
                                                        <span class="nav-main-link-name">Rekap Garansi</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('laporan kas harian.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/kas_kasir') ? ' active' : '' }}"
                                                        href="{{ route('kas_kasir.index') }}">
                                                        <span class="nav-main-link-name">Laporan Kas Harian Kasir</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap summary penjualan.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/rekap_kategori') ? ' active' : '' }}"
                                                        href="{{ route('rekap_kategori.index') }}">
                                                        <span class="nav-main-link-name">Rekap Summary Penjualan</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap penjualan kat menu.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/rekap_penj_kat') ? ' active' : '' }}"
                                                        href="{{ route('rekap_penj_kat.index') }}">
                                                        <span class="nav-main-link-name">Rekap Penjualan Kategori Menu</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap penjualan non menu.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('dashboard/non_menu') ? ' active' : '' }}"
                                                        href="{{ route('non_menu.index') }}">
                                                        <span class="nav-main-link-name">Rekap Penjualan Non Menu</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('rekap aktifitas kasir.view')
                                                <li
                                                    class="nav-main-item{{ request()->is('dashboard/rekap_aktiv') ? ' open' : '' }}">
                                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                        aria-haspopup="true" aria-expanded="true" href="#">
                                                        <span class="nav-main-link-name">Rekap Aktivitas Kasir</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        @can('rekap buka laci.view')
                                                            <li class="nav-main-item">
                                                                <a class="nav-main-link{{ request()->is('dashboard/rekap_aktiv_laci') ? ' active' : '' }}"
                                                                    href="{{ route('rekap_aktiv_laci.rekap_laci') }}">
                                                                    <span class="nav-main-link-name">Rekap Buka Laci</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('rekap hapus menu.view')
                                                            <li class="nav-main-item">
                                                                <a class="nav-main-link{{ request()->is('dashboard/rekap_aktiv_menu') ? ' active' : '' }}"
                                                                    href="{{ route('rekap_aktiv_menu.rekap_hps_menu') }}">
                                                                    <span class="nav-main-link-name">Rekap Hapus Menu</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('rekap nota kasir.view')
                                                            <li class="nav-main-item">
                                                                <a class="nav-main-link{{ request()->is('dashboard/rekap_aktiv_nota') ? ' active' : '' }}"
                                                                    href="{{ route('rekap_aktiv_nota.rekap_hps_nota') }}">
                                                                    <span class="nav-main-link-name">Rekap Nota</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('module inventori.view')
                        <li class="nav-main-item{{ request()->is('inventori/master') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-warehouse"></i>
                                <span class="nav-main-link-name">Inventori</span>
                            </a>
                            <ul class="nav-main-submenu">
                                @can('master inventori.view')
                                    <li class="nav-main-item{{ request()->is('inventori/master') ? ' open' : '' }}">
                                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                            aria-haspopup="true" aria-expanded="true" href="#">
                                            <span class="nav-main-link-name">Master</span>
                                        </a>
                                        <ul class="nav-main-submenu">
                                            @can('resep.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('master/m_resep') ? ' active' : '' }}"
                                                        href="{{ route('m_resep.index') }}">
                                                        <span class="nav-main-link-name">Resep</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('data bb.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('inventori/m_bb') ? ' active' : '' }}"
                                                        href="{{ route('m_bb.index') }}">
                                                        <span class="nav-main-link-name">Data Bahan Baku</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('inventori/m_grub_bb') ? ' active' : '' }}"
                                                        href="{{ route('m_grub_bb.index') }}">
                                                        <span class="nav-main-link-name">Grub Bahan Baku</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('data gudang.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('inventori/m_gudang') ? ' active' : '' }}"
                                                        href="{{ route('m_gudang.index') }}">
                                                        <span class="nav-main-link-name">Data Gudang</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('stok awal.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('inventori/stok_awal') ? ' active' : '' }}"
                                                        href="{{ route('stok_awal.index') }}">
                                                        <span class="nav-main-link-name">Stok Awal</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('supplier.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('inventori/supplier') ? ' active' : '' }}"
                                                        href="{{ route('supplier.index') }}">
                                                        <span class="nav-main-link-name">Supplier & Pelanggan</span>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan
                                @can('rph.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/rph') ? ' active' : '' }}"
                                            href="{{ route('rph.index') }}">
                                            <span class="nav-main-link-name">RPH</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('kebutuhan belanja.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/rph_belanja') ? ' active' : '' }}"
                                            href="{{ route('belanja.index') }}">
                                            <span class="nav-main-link-name">Kebutuhan Belanja</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('purchase order.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/po') ? ' active' : '' }}"
                                            href="{{ route('po.index') }}">
                                            <span class="nav-main-link-name">Purchase Order (PO)</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('pembelian.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/beli') ? ' active' : '' }}"
                                            href="{{ route('beli.index') }}">
                                            <span class="nav-main-link-name">Pembelian</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('cht pembelian.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/cht') ? ' active' : '' }}"
                                            href="{{ route('cht.index') }}">
                                            <span class="nav-main-link-name">CHT Pembelian</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('keluar gudang.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/m_gudang/out') ? ' active' : '' }}"
                                            href="{{ route('m_gudang_out.index') }}">
                                            <span class="nav-main-link-name">Keluar Gudang</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('terima gudang.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/gudang/terima') ? ' active' : '' }}"
                                            href="{{ route('m_gudang.terima_tf') }}">
                                            <span class="nav-main-link-name">Terima Gudang</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('pecah gabung barang.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/pecah_gabung') ? ' active' : '' }}"
                                            href="{{ route('pcb.index') }}">
                                            <span class="nav-main-link-name">Pecah Gabung Barang</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('penjualan bb internal.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/penj_gudang') ? ' active' : '' }}"
                                            href="{{ route('penj_gudang.index') }}">
                                            <span class="nav-main-link-name">Penjualan BB Internal</span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('invetori/penjualan_inv') ? ' active' : '' }}"
                                        href="{{ route('penjualan_inv.index') }}">
                                        <span class="nav-main-link-name">Penjualan BB Umum</span>
                                    </a>
                                </li> --}}
                                @can('barang rusak.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/rusak') ? ' active' : '' }}"
                                            href="{{ route('rusak.index') }}">
                                            <span class="nav-main-link-name">Barang Rusak</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('stok opname.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('invetori/stok_so') ? ' active' : '' }}"
                                            href="{{ route('stok_so.index') }}">
                                            <span class="nav-main-link-name">Stok Opname</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('laporan inventori.view')
                                    <li class="nav-main-item{{ request()->is('inventori/laporan') ? ' open' : '' }}">
                                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                            aria-haspopup="true" aria-expanded="true" href="#">
                                            <span class="nav-main-link-name">Laporan</span>
                                        </a>
                                        <ul class="nav-main-submenu">
                                            @can('kartu stok.view')
                                                <li
                                                    class="nav-main-item{{ request()->is('inventori/kartu_stock') ? ' open' : '' }}">
                                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                        aria-haspopup="true" aria-expanded="true" href="#">
                                                        <span class="nav-main-link-name">Laporan Stock</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/kartu_stock') ? ' active' : '' }}"
                                                                href="{{ route('kartu_stock.kartu_stk') }}">
                                                                <span class="nav-main-link-name">Kartu Stock</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/rekap_stock') ? ' active' : '' }}"
                                                                href="{{ route('rekap_stock.rekap_stk') }}">
                                                                <span class="nav-main-link-name">Rekap Stock</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endcan
                                            @can('laporan rph.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('inventori/lap_rph') ? ' active' : '' }}"
                                                        href="{{ route('kartu_stock.kartu_stk') }}">
                                                        <span class="nav-main-link-name">Laporan RPH</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('laporan pembelian.view')
                                                <li
                                                    class="nav-main-item{{ request()->is('inventori/lap_pem_harian') ? ' open' : '' }}">
                                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                        aria-haspopup="true" aria-expanded="true" href="#">
                                                        <span class="nav-main-link-name">Laporan Pembelian</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/lap_pem_detail') ? ' active' : '' }}"
                                                                href="{{ route('lap_pem_detail.lap_detail') }}">
                                                                <span class="nav-main-link-name">Detail Pembelian</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/lap_pem_rekap') ? ' active' : '' }}"
                                                                href="{{ route('lap_pem_rekap.lap_rekap') }}">
                                                                <span class="nav-main-link-name">Rekap Pembelian</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/lap_pem_harian') ? ' active' : '' }}"
                                                                href="{{ route('lap_pem_harian.lap_harian') }}">
                                                                <span class="nav-main-link-name">Rekap Pembelian Harian</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endcan
                                            @can('laporan cht.view')
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('invetori/lap_cht') ? ' active' : '' }}"
                                                        href="{{ route('lap_cht.index') }}">
                                                        <span class="nav-main-link-name">Laporan CHT</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('keluar masuk gudang.view')
                                                <li
                                                    class="nav-main-item{{ request()->is('inventori/lap_gudang_rekap') ? ' open' : '' }}">
                                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                        aria-haspopup="true" aria-expanded="true" href="#">
                                                        <span class="nav-main-link-name">laporan Keluar dan Masuk Gudang</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/lap_gudang_detail') ? ' active' : '' }}"
                                                                href="{{ route('lap_gudang_detail.lap_detail') }}">
                                                                <span class="nav-main-link-name">Detail Keluar dan Masuk
                                                                    Gudang</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/lap_gudang_rekap') ? ' active' : '' }}"
                                                                href="{{ route('lap_gudang_rekap.lap_rekap') }}">
                                                                <span class="nav-main-link-name">Rekap Keluar dan Masuk
                                                                    Gudang</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/lap_gudang_harian') ? ' active' : '' }}"
                                                                href="{{ route('lap_gudang_harian.lap_harian') }}">
                                                                <span class="nav-main-link-name">Rekap Keluar dan Masuk Gudang
                                                                    Harian</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endcan
                                            @can('laporan pengiriman.view')
                                                <li
                                                    class="nav-main-item{{ request()->is('inventori/lap_kirim') ? ' open' : '' }}">
                                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                        aria-haspopup="true" aria-expanded="true" href="#">
                                                        <span class="nav-main-link-name">Laporan Pengiriman</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/lap_kirim_detail') ? ' active' : '' }}"
                                                                href="{{ route('lap_kirim_detail.lap_detail') }}">
                                                                <span class="nav-main-link-name">Detail Pengiriman</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/lap_kirim_rekap') ? ' active' : '' }}"
                                                                href="{{ route('lap_kirim_rekap.lap_rekap') }}">
                                                                <span class="nav-main-link-name">Rekap Pengiriman</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link{{ request()->is('inventori/lap_kirim_harian') ? ' active' : '' }}"
                                                                href="{{ route('lap_kirim_harian.lap_harian') }}">
                                                                <span class="nav-main-link-name">Rekap Pengiriman Harian</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('module akuntansi.view')
                        <li class="nav-main-item{{ request()->is('akuntansi/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-money-bill-1"></i>
                                <span class="nav-main-link-name">Akuntansi</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('akuntansi/rekening') ? ' active' : '' }}"
                                        href="{{ route('rekening.index') }}">
                                        <span class="nav-main-link-name">Rekening Akuntansi</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('akuntansi/link') ? ' active' : '' }}"
                                        href="{{ route('link.index') }}">
                                        <span class="nav-main-link-name">Link Akuntansi</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('akuntansi/jurnal_kas') ? ' active' : '' }}"
                                        href="{{ route('jurnal_kas.index') }}">
                                        <span class="nav-main-link-name">Jurnal Kas</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('akuntansi/jurnal_bank') ? ' active' : '' }}"
                                        href="{{ route('jurnal_bank.index') }}">
                                        <span class="nav-main-link-name">Jurnal Bank</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('akuntansi/jurnal_umum') ? ' active' : '' }}"
                                        href="{{ route('jurnal_umum.index') }}">
                                        <span class="nav-main-link-name">Jurnal Umum</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcan
                    @can('module hrd.view')
                        <li class="nav-main-item{{ request()->is('hrd/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-money-bill-1"></i>
                                <span class="nav-main-link-name">HRD</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item{{ request()->is('hrd/master/*') ? ' open' : '' }}">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                        aria-haspopup="true" aria-expanded="true" href="#">
                                        <span class="nav-main-link-name">Master</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link{{ request()->is('hrd/master/divisi*') ? ' active' : '' }}"
                                                href="{{ route('divisi.index') }}">
                                                <span class="nav-main-link-name">Divisi</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('module user.view')
                        <li class="nav-main-heading">Pengaturan</li>
                        <li class="nav-main-item{{ request()->is('users/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-user"></i>
                                <span class="nav-main-link-name">User</span>
                            </a>
                            <ul class="nav-main-submenu">
                                @can('user.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('users') ? ' active' : '' }}"
                                            href="{{ route('users.index') }}">
                                            <span class="nav-main-link-name">User</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('hak akses.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('users/akses') ? ' active' : '' }}"
                                            href="{{ route('akses.index') }}">
                                            <span class="nav-main-link-name">Hak Akses</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('permission.view')
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('users/permission') ? ' active' : '' }}"
                                            href="{{ route('permission.index') }}">
                                            <span class="nav-main-link-name">Permission</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                </ul>
            </div>
            <!-- END Side Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
    </div>
    <!-- Sidebar Content -->
</nav>
