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
        <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user d-sm-none"></i>
          <span class="d-none d-sm-inline-block fw-semibold">J. Smith</span>
          <i class="fa fa-angle-down opacity-50 ms-1"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
          <div class="px-2 py-3 bg-body-light rounded-top">
            <h5 class="h6 text-center mb-0">
              John Smith
            </h5>
          </div>
          <div class="p-2">
            <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" href="javascript:void(0)">
              <span>Profile</span>
              <i class="fa fa-fw fa-user opacity-25"></i>
            </a>
            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
              <span>Inbox</span>
              <i class="fa fa-fw fa-envelope-open opacity-25"></i>
            </a>
            <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" href="javascript:void(0)">
              <span>Invoices</span>
              <i class="fa fa-fw fa-file opacity-25"></i>
            </a>
            <div class="dropdown-divider"></div>

            <!-- Toggle Side Overlay -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
              <span>Settings</span>
              <i class="fa fa-fw fa-wrench opacity-25"></i>
            </a>
            <!-- END Side Overlay -->

            <div class="dropdown-divider"></div>
            <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" href="javascript:void(0)">
              <span>Sign Out</span>
              <i class="fa fa-fw fa-sign-out-alt opacity-25"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- END User Dropdown -->

      <!-- Notifications -->
      <div class="dropdown d-inline-block">
        <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-notifications" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-flag"></i>
          <span class="text-primary">&bull;</span>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications">
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
                  <p class="fw-medium mb-1">Please check your payment info since we can’t validate them!</p>
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
                  <p class="fw-medium mb-1">Web server stopped responding and it was automatically restarted!</p>
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
                  <p class="fw-medium mb-1">Please consider upgrading your plan. You are running out of space.</p>
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
        <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout" data-action="sidebar_close">
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
          <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar15.jpg') }}" alt="">
        </div>
        <!-- END Visible only in mini mode -->

        <!-- Visible only in normal mode -->
        <div class="smini-hidden text-center mx-auto">
          <a class="img-link" href="javascript:void(0)">
            <img class="img-avatar" src="{{ asset('media/avatars/avatar15.jpg') }}" alt="">
          </a>
          <ul class="list-inline mt-3 mb-0">
            <li class="list-inline-item">
              <a class="link-fx text-dual fs-sm fw-semibold text-uppercase" href="javascript:void(0)">{{Auth::user()->name}}</a>
            </li>
            <li class="list-inline-item">
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <a class="link-fx text-dual" data-toggle="layout" data-action="dark_mode_toggle" href="javascript:void(0)">
                <i class="fa fa-burn"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a class="link-fx text-dual" href="{{ route('logout') }}" onclick="event.preventDefault();
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
          <li class="nav-main-item{{ request()->is('master/*') ? ' open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
              <i class="nav-main-link-icon fa fa-lightbulb"></i>
              <span class="nav-main-link-name">Sipedas</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('master/area') ? ' active' : '' }}" href="{{route('area.index')}}">
                  <span class="nav-main-link-name">Area</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('master/m_waroeng') ? ' active' : '' }}" href="{{route('m_waroeng.index')}}">
                  <span class="nav-main-link-name">Waroeng</span>
                </a>
              </li>
              <li class="nav-main-item{{ request()->is('master/*') ? ' open' : '' }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                  <span class="nav-main-link-name">CR55</span>
                </a>
                <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_w_jenis') ? ' active' : '' }}" href="{{route('m_w_jenis.index')}}">
                      <span class="nav-main-link-name">Jenis Waroeng</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_produk') ? ' active' : '' }}" href="{{route('m_produk.index')}}">
                      <span class="nav-main-link-name">Produk</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_klasifikasi') ? ' active' : '' }}" href="{{route('m_klasifikasi.index')}}">
                      <span class="nav-main-link-name">Produk Klasifikasi</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_produk_relasi') ? ' active' : '' }}" href="{{route('m_produk_relasi.index')}}">
                      <span class="nav-main-link-name">Produk Relasi Katergori</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_resep') ? ' active' : '' }}" href="{{route('m_resep.index')}}">
                      <span class="nav-main-link-name">Resep</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/jenis_menu') ? ' active' : '' }}" href="{{route('jenis_menu.index')}}">
                      <span class="nav-main-link-name">Jenis Menu</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/sub_jenis_menu') ? ' active' : '' }}" href="{{route('sub_jenis_menu.index')}}">
                      <span class="nav-main-link-name">Sub Jenis Menu</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_jenis_nota') ? ' active' : '' }}" href="{{route('m_jenis_nota.index')}}">
                      <span class="nav-main-link-name">Jenis Nota</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/modal_tipe') ? ' active' : '' }}" href="{{route('modal_tipe.index')}}">
                      <span class="nav-main-link-name">Modal Tipe</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_pajak') ? ' active' : '' }}" href="{{route('m_pajak.index')}}">
                      <span class="nav-main-link-name">Pajak</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_sc') ? ' active' : '' }}" href="{{route('m_sc.index')}}">
                      <span class="nav-main-link-name">Service Charge</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_jenis_meja') ? ' active' : '' }}" href="{{route('m_jenis_meja.index')}}">
                      <span class="nav-main-link-name">Jenis Meja</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_transaksi_tipe') ? ' active' : '' }}" href="{{route('m_transaksi_tipe.index')}}">
                      <span class="nav-main-link-name">Transaksi Tipe</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/meja') ? ' active' : '' }}" href="{{route('meja.index')}}">
                      <span class="nav-main-link-name">Meja</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/conf_footer') ? ' active' : '' }}" href="{{route('conf_footer.index')}}">
                      <span class="nav-main-link-name">Footer Waroeng</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/m_satuan') ? ' active' : '' }}" href="{{route('m_satuan.index')}}">
                      <span class="nav-main-link-name">Satuan</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/plot-produksi') ? ' active' : '' }}" href="{{route('plot-produksi.index')}}">
                      <span class="nav-main-link-name">Plot Produksi</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('master/level-jabatan') ? ' active' : '' }}" href="{{route('level-jabatan.index')}}">
                      <span class="nav-main-link-name">Level jabatan</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-main-item{{ request()->is('dashboard/*') ? ' open' : '' }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                  <span class="nav-main-link-name">Laporan Penjualan</span>
                </a>
                <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('dashboard/detail') ? ' active' : '' }}" href="{{route('detail.index')}}">
                      <span class="nav-main-link-name">Detail Nota</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('dashboard/rekap') ? ' active' : '' }}" href="{{route('rekap.index')}}">
                      <span class="nav-main-link-name">Rekap Nota</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('dashboard/harian') ? ' active' : '' }}" href="{{route('harian.index')}}">
                      <span class="nav-main-link-name">Rekap Nota Harian</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('dashboard/rekap_menu') ? ' active' : '' }}" href="{{route('rekap_menu.index')}}">
                      <span class="nav-main-link-name">Rekap Menu</span>
                    </a>
                  </li>
                </ul>
            </li>     

            </ul>
          </li>
          <li class="nav-main-item{{ request()->is('inventori/*') ? ' open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
              <i class="nav-main-link-icon fa fa-warehouse"></i>
              <span class="nav-main-link-name">Inventori</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item{{ request()->is('inventori/*') ? ' open' : '' }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                  <span class="nav-main-link-name">Master</span>
                </a>
                <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('inventori/m_bb') ? ' active' : '' }}" href="{{route('m_bb.index')}}">
                      <span class="nav-main-link-name">Data Bahan Baku</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('inventori/m_gudang') ? ' active' : '' }}" href="{{route('m_gudang.index')}}">
                      <span class="nav-main-link-name">Data Gudang</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('inventori/stok_awal') ? ' active' : '' }}" href="{{route('stok_awal.index')}}">
                      <span class="nav-main-link-name">Stok Awal</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('inventori/supplier') ? ' active' : '' }}" href="{{route('supplier.index')}}">
                      <span class="nav-main-link-name">Supplier & Pelanggan</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('invetori/po') ? ' active' : '' }}" href="{{route('po.index')}}">
                  <span class="nav-main-link-name">Purchase Order (PO)</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('invetori/beli') ? ' active' : '' }}" href="{{route('beli.index')}}">
                  <span class="nav-main-link-name">Pembelian</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('invetori/cht') ? ' active' : '' }}" href="{{route('cht.index')}}">
                  <span class="nav-main-link-name">CHT Pembelian</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('invetori/m_gudang/out') ? ' active' : '' }}" href="{{route('m_gudang_out.index')}}">
                  <span class="nav-main-link-name">Keluar Gudang</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('invetori/gudang/terima') ? ' active' : '' }}" href="{{route('m_gudang.terima_tf')}}">
                  <span class="nav-main-link-name">Terima Gudang</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('invetori/pecah_gabung') ? ' active' : '' }}" href="{{route('pcb.index')}}">
                  <span class="nav-main-link-name">Pecah Gabung Barang</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('invetori/penjualan_inv') ? ' active' : '' }}" href="{{route('penjualan_inv.index')}}">
                  <span class="nav-main-link-name">Penjualan Barang Ke Waroeng</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('invetori/rusak') ? ' active' : '' }}" href="{{route('rusak.index')}}">
                  <span class="nav-main-link-name">Barang Rusak</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item{{ request()->is('akuntansi/*') ? ' open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
              <i class="nav-main-link-icon fa fa-money-bill-1"></i>
              <span class="nav-main-link-name">Akuntansi</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('akuntansi/rekening') ? ' active' : '' }}" href="{{route('rekening.index')}}">
                  <span class="nav-main-link-name">Rekening Akuntansi</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('akuntansi/jurnal_kas') ? ' active' : '' }}" href="{{route('jurnal_kas.index')}}">
                  <span class="nav-main-link-name">Jurnal Kas</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('akuntansi/jurnal_bank') ? ' active' : '' }}" href="{{route('jurnal_bank.index')}}">
                  <span class="nav-main-link-name">Jurnal Bank</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('akuntansi/jurnal_umum') ? ' active' : '' }}" href="{{route('jurnal_umum.index')}}">
                  <span class="nav-main-link-name">Jurnal Umum</span>
                </a>
              </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('akuntansi/link') ? ' active' : '' }}" href="{{route('link.index')}}">
                      <span class="nav-main-link-name">Link Akuntansi</span>
                    </a>
                  </li>
                </ul>
              </li>
          <li class="nav-main-heading">Pengaturan</li>
          <li class="nav-main-item{{ request()->is('users/*') ? ' open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
              <i class="nav-main-link-icon fa fa-user"></i>
              <span class="nav-main-link-name">User</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('users') ? ' active' : '' }}" href="{{route('users.index')}}">
                  <span class="nav-main-link-name">User</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('user/akses') ? ' active' : '' }}" href="{{route('akses.index')}}">
                  <span class="nav-main-link-name">Hak Akses</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
  </div>
  <!-- Sidebar Content -->
</nav>