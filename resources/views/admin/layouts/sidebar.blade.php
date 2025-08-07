<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/dashboard" class="brand-link">
      {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light ml-4">ADMIN DELIGO</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="/admin/pages" class="nav-link {{ Request::is('admin/pages') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          {{-- <li class="nav-item">
            <a href="/admin/transaksi" class="nav-link {{ Request::is('admin/transaksi*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-exchange-alt"></i>
              <p>
                Pesanan
              </p>
            </a>
          </li> --}}

          <li class="nav-item">
            <a href="/admin/produk" class="nav-link {{ Request::is('admin/produk*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Pembuatan Katalog Menu
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/laporan" class="nav-link {{ Request::is('admin/laporan*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Laporan Penjualan
              </p>
            </a>
          </li>

          {{-- <li class="nav-item">
            <a href="/admin/user" class="nav-link {{ Request::is('admin/user*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User
              </p>
            </a>
          </li> --}}


        </ul>
      </nav>
      <!-- // sidebar-menu -->
    </div>
    <!-- // sidebar -->
  </aside>

  <div class="content-wrapper">
