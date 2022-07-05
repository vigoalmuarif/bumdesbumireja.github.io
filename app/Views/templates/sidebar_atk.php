  <?php $uri = service('uri') ?>
  <!-- Page Wrapper -->
  <div id="wrapper">

      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

          <!-- Sidebar - Brand -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard/pengelolaan_atk') ?>">
              <div class="sidebar-brand-icon rotate-n-15">
                  <i class="fas fa-laugh-wink"></i>
              </div>
              <div class="sidebar-brand-text mx-3">BUMDes<sup>KM</sup></div>
          </a>

          <!-- Divider -->
          <hr class="sidebar-divider my-0">

          <!-- Nav Item - Dashboard -->
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('dashboard/pengelolaan_atk') ?>">
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
                      <h6 class="collapse-header">Manajemen Produk ATK</h6>
                      <a class="collapse-item  <?= $uri->getSegment(2) == 'data' ? 'active' : ''; ?>" href="<?= base_url('produk/data') ?>">Produk</a>
                      <a class="collapse-item  <?= $uri->getSegment(2) == 'kategori' ? 'active' : ''; ?>" href="<?= base_url('produk/kategori') ?>">Kategori</a>
                      <a class="collapse-item  <?= $uri->getSegment(2) == 'satuan' ? 'active' : ''; ?>" href="<?= base_url('produk/satuan') ?>">Satuan</a>
                      <a class="collapse-item  <?= $uri->getSegment(2) == 'supplier' ? 'active' : ''; ?>" href="<?= base_url('produk/supplier') ?>">Supplier</a>
                      <a class="collapse-item  <?= $uri->getSegment(1) == 'customer_atk' ? 'active' : ''; ?>" href="<?= base_url('customer_atk/index') ?>">Pelanggan</a>
                  </div>
              </div>
          </li>
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">

          <div class="sidebar-heading">
              Pengelolaan ATK
          </div>
          <?php if (in_groups(['bendahara', 'atk'])) : ?>
              <li class="nav-item  <?= $uri->getSegment(1) == 'penjualan' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('penjualan') ?>">
                      <i class="fas fa-fw fa-shopping-basket"></i>
                      <span>Penjualan</span></a>
              </li>
              <!-- Nav Item - Retribusi -->
              <li class=" nav-item  <?= $uri->getSegment(1) == 'pembelian' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('pembelian') ?>">
                      <i class="fas fa-fw fa-cart-plus"></i>
                      <span>Pembelian</span></a>
              </li>
          <?php endif ?>
          <li class=" nav-item  <?= $uri->getSegment(2) == 'index' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('Produk/index') ?>">
                  <i class="fas fa-fw fa-coins"></i>
                  <span>Produk</span></a>
          </li>
          <li class=" nav-item  <?= $uri->getSegment(2) == 'stok' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('Produk/stok') ?>">
                  <i class="fas fa-fw fa-sync-alt"></i>
                  <span>Stok Produk</span></a>
          </li>
          <?php if (in_groups(['bendahara', 'atk'])) : ?>
              <li class=" nav-item  <?= $uri->getSegment(1) == 'piutang_penjualan_atk' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('piutang_penjualan_atk') ?>">
                      <i class="fas fa-fw fa-sign-in-alt"></i>
                      <span>Piutang Penjualan</span></a>
              </li>
              <li class=" nav-item <?= $uri->getSegment(1) == 'hutang_pembelian_atk' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('hutang_pembelian_atk') ?>">
                      <i class="fas fa-fw fa-sign-out-alt"></i>
                      <span>Hutang Pembelian</span></a>
              </li>
          <?php endif ?>
          <li class=" nav-item <?= $uri->getSegment(2) == 'riwayat_penjualan' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('penjualan/riwayat_penjualan') ?>">
                  <i class="fas fa-fw fa-sign-in-alt"></i>
                  <span>Riwayat Penjualan</span></a>
          </li>
          <li class=" nav-item <?= $uri->getSegment(2) == 'list_pembelian' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('pembelian/list_pembelian') ?>">
                  <i class="fas fa-fw fa-sign-in-alt"></i>
                  <span>Riwayat Pembelian</span></a>
          </li>
          <?php if (in_groups('admin')) : ?>
              <li class="nav-item <?= $uri->getSegment(2) == 'printer' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('profil/printer') ?>">
                      <i class="fas fa-fw fa-print"></i>
                      <span>printer Thermal ATK</span></a>
              </li>
          <?php endif ?>
          <?php if (in_groups(['bendahara', 'atk'])) : ?>
              <hr class="sidebar-divider d-none d-md-block">
              <div class="sidebar-heading">
                  Laporan
              </div>
              <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('laporan/penjualan') ?>">
                      <i class="fas fa-fw fa-file-export"></i>
                      <span>Laporan</span></a>
              </li>
          <?php endif ?>
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
              <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>

      </ul>
      <!-- End of Sidebar -->