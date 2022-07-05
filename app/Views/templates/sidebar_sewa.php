  <?php $uri = service('uri') ?>
  <!-- Page Wrapper -->
  <div id="wrapper">

      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

          <!-- Sidebar - Brand -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard/persewaan') ?>">
              <div class="sidebar-brand-icon rotate-n-15">
                  <i class="fas fa-laugh-wink"></i>
              </div>
              <div class="sidebar-brand-text mx-3">BUMDes<sup>KM</sup></div>
          </a>

          <!-- Divider -->
          <hr class="sidebar-divider my-0">

          <!-- Nav Item - Dashboard -->
          <li class="nav-item <?= $uri->getSegment(1) == 'dashboard' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('dashboard/persewaan') ?>">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
          </li>

          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Heading -->
          <div class="sidebar-heading">
              Master Data
          </div>
          <li class="nav-item <?= $uri->getSegment(1) == 'property' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('property/type/semua') ?>">
                  <i class="fas fa-fw fa-house-user"></i>
                  <span>Property</span></a>
          </li>
          <li class="nav-item <?= $uri->getSegment(1) == 'pedagang' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('pedagang/index') ?>">
                  <i class="fas fa-fw fa-male"></i>
                  <span>Pedagang</span></a>
          </li>
          <li class="nav-item <?= $uri->getSegment(2) == 'periode_bulanan' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('persewaan/periode_bulanan') ?>">
                  <i class="fas fa-fw fa-calendar-check"></i>
                  <span>Periode Bulanan</span></a>
          </li>
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
          <!-- Heading -->
          <div class="sidebar-heading">
              Persewaan & Tagihan Bulanan
          </div>
          <?php if (in_groups(['bendahara', 'admin'])) : ?>
              <!-- Nav Item - Utilities Collapse Menu -->
              <li class="nav-item <?= $uri->getSegment(2) == 'pedagang' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('persewaan/pedagang') ?>">
                      <i class="fas fa-fw fa-money-bill-alt"></i>
                      <span>Transaksi</span></a>
              </li>
          <?php endif ?>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sewa" aria-expanded="true" aria-controls="">
                  <i class="fas fa-fw fa-store"></i>
                  <span>Persewaan</span>
              </a>
              <div id="sewa" class="collapse" aria-labelledby="" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Persewaan</h6>
                      <a class="collapse-item <?= $uri->getSegment(2) == 'index' ? 'active' : ''; ?>" href="<?= base_url('persewaan/index') ?>">Daftar Persewaan</a>
                      <a class="collapse-item <?= $uri->getSegment(2) == 'sewa_aktif' ? 'active' : ''; ?>" href="<?= base_url('persewaan/sewa_aktif') ?>">Persewaan Aktif</a>
                      <a class="collapse-item <?= $uri->getSegment(2) == 'sewa_belum_lunas' ? 'active' : ''; ?>" href="<?= base_url('persewaan/sewa_belum_lunas') ?>">Persewaan Belum Lunas</a>
                      <a class="collapse-item <?= $uri->getSegment(2) == 'sewa_selesai' ? 'active' : ''; ?>" href="<?= base_url('persewaan/sewa_selesai') ?>">Persewaan Selesai</a>
                  </div>
              </div>
          </li>

          <li class="nav-item <?= $uri->getSegment(2) == 'tagihan_bulanan_belum_lunas' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('persewaan/tagihan_bulanan_belum_lunas') ?>">
                  <i class="fas fa-fw fa-clipboard"></i>
                  <span>Tagihan Bulanan</span></a>
          </li>
          <?php if (in_groups(['bendahara'])) : ?>
              <hr class="sidebar-divider d-none d-md-block">
              <div class="sidebar-heading">
                  Laporan
              </div>
              <!-- Nav Item - Retribusi -->
              <li class="nav-item ">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan" aria-expanded="true" aria-controls="">
                      <i class="fas fa-fw fa-file-export"></i>
                      <span>laporan</span>
                  </a>
                  <div id="laporan" class="collapse" aria-labelledby="" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                          <h6 class="collapse-header">Persewaan</h6>
                          <a class="collapse-item <?= $uri->getSegment(2) == 'sewa' ? 'active' : ''; ?>" href="<?= base_url('laporan/sewa') ?>">Laporan Sewa</a>
                          <a class="collapse-item <?= $uri->getSegment(3) == 'pajak_bulanan' ? 'active' : ''; ?>" href="<?= base_url('laporan/sewa/pajak_bulanan') ?>">Laporan Pajak Bulanan</a>
                      </div>
                  </div>
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