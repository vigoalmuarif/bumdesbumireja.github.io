  <!-- Page Wrapper -->
  <div id="wrapper">

      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

          <!-- Sidebar - Brand -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
              <div class="sidebar-brand-icon rotate-n-15">
                  <i class="fas fa-laugh-wink"></i>
              </div>
              <div class="sidebar-brand-text mx-3">BUMDes<sup>KM</sup></div>
          </a>

          <!-- Divider -->
          <hr class="sidebar-divider my-0">

          <!-- Nav Item - Dashboard -->
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url() ?>">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
          </li>

          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Heading -->
          <div class="sidebar-heading">
              Master Data
          </div>

          <!-- Nav Item - Pages Collapse Menu -->
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                  <i class="fas fa-fw fa-database"></i>
                  <span>Master</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Manajemen Pasar</h6>
                      <a class="collapse-item" href="<?= base_url('property/index') ?>">Property</a>
                      <a class="collapse-item" href="<?= base_url('Pedagang/index') ?>">Pedagang</a>
                      <a class="collapse-item" href="<?= base_url('persewaan/periode_bulanan') ?>">Periode Bulanan</a>
                      <a class="collapse-item" href="<?= base_url('retribusi/periodeRetribusi') ?>">Periode Retribusi</a>
                      <a class="collapse-item" href="<?= base_url('retribusi/retribusi') ?>">Retribusi</a>
                      <h6 class="collapse-header">Manajemen Produk ATK</h6>
                      <a class="collapse-item" href="<?= base_url('produk/kategori') ?>">Kategori</a>
                      <a class="collapse-item" href="<?= base_url('produk/satuan') ?>">Satuan</a>
                      <a class="collapse-item" href="<?= base_url('produk/supplier') ?>">Supplier</a>
                      <a class="collapse-item" href="<?= base_url('customer_atk/index') ?>">Pelanggan</a>
                      <h6 class="collapse-header">Lainnya</h6>
                      <a class="collapse-item" href="<?= base_url('petugas/index') ?>">Petugas</a>
                      <a class="collapse-item" href="<?= base_url('Pedagang/index') ?>">Pengguna</a>
                  </div>
              </div>
          </li>
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
          <!-- Heading -->
          <div class="sidebar-heading">
              Persewaan & Tagihan Bulanan
          </div>
          <!-- Nav Item - Utilities Collapse Menu -->
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('persewaan/pedagang') ?>">
                  <i class="fas fa-fw fa-money-bill-alt"></i>
                  <span>Transaksi</span></a>
          </li>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sewa" aria-expanded="true" aria-controls="">
                  <i class="fas fa-fw fa-store"></i>
                  <span>Persewaan</span>
              </a>
              <div id="sewa" class="collapse" aria-labelledby="" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Persewaan</h6>
                      <a class="collapse-item" href="<?= base_url('persewaan/index') ?>">Daftar Persewaan</a>
                      <a class="collapse-item" href="<?= base_url('persewaan/sewa_aktif') ?>">Persewaan Aktif</a>
                      <a class="collapse-item" href="<?= base_url('persewaan/sewa_belum_lunas') ?>">Persewaan Belum Lunas</a>
                      <a class="collapse-item" href="<?= base_url('persewaan/sewa_selesai') ?>">Persewaan Selesai</a>
                  </div>
              </div>
          </li>

          <!-- Nav Item - Tagihan -->
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('persewaan/tagihan_bulanan_belum_lunas') ?>">
                  <i class="fas fa-fw fa-calendar-alt"></i>
                  <span>Tagihan Bulanan</span></a>
          </li>
          <!-- Nav Item - Retribusi -->
          <hr class="sidebar-divider d-none d-md-block">
          <div class="sidebar-heading">
              Retribusi Pasar & Parkir
          </div>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('/retribusi/index') ?>">
                  <i class="fas fa-fw fa-hand-holding"></i>
                  <span>Retribusi</span></a>
              </li< <hr class="sidebar-divider d-none d-md-block">
              <div class="sidebar-heading">
                  Pengelolaan ATK
              </div>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('penjualan') ?>">
                  <i class="fas fa-fw fa-shopping-basket"></i>
                  <span>Penjualan</span></a>
          </li>
          <!-- Nav Item - Retribusi -->
          <li class=" nav-item">
              <a class="nav-link" href="<?= base_url('pembelian') ?>">
                  <i class="fas fa-fw fa-cart-plus"></i>
                  <span>Pembelian</span></a>
          </li>
          <li class=" nav-item">
              <a class="nav-link" href="<?= base_url('penjualan/list') ?>">
                  <i class="fas fa-fw fa-sign-in-alt"></i>
                  <span>Daftar Penjualan</span></a>
          </li>
          <li class=" nav-item">
              <a class="nav-link" href="<?= base_url('pembelian/list_pembelian') ?>">
                  <i class="fas fa-fw fa-sign-in-alt"></i>
                  <span>Daftar Pembelian</span></a>
          </li>
          <li class=" nav-item">
              <a class="nav-link" href="<?= base_url('Produk/index') ?>">
                  <i class="fas fa-fw fa-coins"></i>
                  <span>Produk</span></a>
          </li>
          <li class=" nav-item">
              <a class="nav-link" href="<?= base_url('Produk/stok') ?>">
                  <i class="fas fa-fw fa-sync-alt"></i>
                  <span>Stok Produk</span></a>
          </li>
          <li class=" nav-item">
              <a class="nav-link" href="<?= base_url('penjualan/piutang') ?>">
                  <i class="fas fa-fw fa-sign-in-alt"></i>
                  <span>Piutang Penjualan</span></a>
          </li>
          <li class=" nav-item">
              <a class="nav-link" href="<?= base_url('pembelian/hutang') ?>">
                  <i class="fas fa-fw fa-sign-out-alt"></i>
                  <span>Hutang Pembelian</span></a>
          </li>

          <div class="sidebar-heading">
              Keuangan
          </div>
          <!-- Nav Item - Retribusi -->
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('operasional/pemasukan') ?>">
                  <i class="fas fa-fw fa-hand-holding-usd"></i>
                  <span>Pemasukan</span></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('operasional/pengeluaran') ?>">
                  <i class="fas fa-fw fa-file-invoice"></i>
                  <span>Pengeluaran</span></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('operasional/arus_uang') ?>">
                  <i class="fas fa-fw fa-file-invoice"></i>
                  <span>Arus Uang</span></a>
          </li>

          <hr class="sidebar-divider d-none d-md-block">
          <div class="sidebar-heading">
              Retribusi Pasar & Parkir
          </div>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('retribusi/petugas') ?>">
                  <i class="fas fa-fw fa-users"></i>
                  <span>Petugas</span></a>
          </li>
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
              <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>

      </ul>
      <!-- End of Sidebar -->