  <?php $uri = \config\Services::uri() ?>
  <!-- Page Wrapper -->
  <div id="wrapper">

      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

          <!-- Sidebar - Brand -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
              <div class="sidebar-brand-icon rotate-n-15">
                  <i class="fas fa-laugh-wink"></i>
              </div>
              <div class="sidebar-brand-text mx-3">BUMDes</div>
          </a>

          <!-- Divider -->
          <hr class="sidebar-divider my-0">

          <!-- Nav Item - Dashboard -->
          <li class="nav-item <?= $uri->getSegment(1) == 'index' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('index/') ?>">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
          </li>

          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
          <!-- Heading -->
          <div class="sidebar-heading">
              Usaha
          </div>
          <!-- Nav Item - Utilities Collapse Menu -->
          <li class="nav-item">
              <a class="nav-link" target="_blank" href="<?= base_url('dashboard/persewaan') ?>">
                  <i class="fas fa-fw fa-house-user"></i>
                  <span>Sewa Kios & Los Pasar</span></a>
          </li>

          <li class="nav-item">
              <a class="nav-link" target="_blank" href="<?= base_url('dashboard/retribusi') ?>">
                  <i class="fas fa-fw fa-calendar-alt"></i>
                  <span>Retribusi Pasar & Parkir</span></a>
          </li>

          <li class="nav-item">
              <a class="nav-link" target="_blank" href="<?= base_url('dashboard/pengelolaan_atk') ?>">
                  <i class="fas fa-fw fa-barcode"></i>
                  <span>Pengelolaan ATK</span></a>
          </li>


          <?php if (in_groups('bendahara')) : ?>

              <!-- Divider -->
              <hr class="sidebar-divider d-none d-md-block">
              <!-- Heading -->
              <div class="sidebar-heading">
                  Keuangan
              </div>

              <li class="nav-item <?= $uri->getSegment(1) == 'pemasukan' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('pemasukan/semua') ?>">
                      <i class="fas fa-fw fa-share"></i>
                      <span>Pemasukan Lainnya</span></a>
              </li>
              <li class="nav-item <?= $uri->getSegment(1) == 'pengeluaran' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('pengeluaran/semua') ?>">
                      <i class="fas fa-fw fa-reply"></i>
                      <span>Pengeluaran Lainnya</span></a>
              </li>

          <?php endif ?>

          <?php if (in_groups('admin')) : ?>
              <!-- Divider -->
              <hr class="sidebar-divider d-none d-md-block">
              <div class="sidebar-heading">
                  Pengguna
              </div>

              <li class="nav-item <?= $uri->getSegment(1) == 'petugas' ? "active" : "" ?>">
                  <a class="nav-link" href="<?= base_url('petugas') ?>">
                      <i class="fas fa-fw fa-id-card"></i>
                      <span>Pegawai</span></a>
              </li>

              <li class="nav-item <?= $uri->getSegment(1) == 'users' ? 'active' : '' ?>">
                  <a class="nav-link" href="<?= base_url('users') ?>">
                      <i class="fas fa-fw fa-users"></i>
                      <span>Pengguna</span></a>
              </li>

              <li class="nav-item <?= $uri->getSegment(1) == "jabatan" ? "active" : '' ?>">
                  <a class="nav-link" href="<?= base_url('jabatan') ?>">
                      <i class="fas fa-fw fa-user-tie"></i>
                      <span>Jabatan</span></a>
              </li>
          <?php endif ?>

          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
          <div class="sidebar-heading">
              Lainnya
          </div>

          <?php if (in_groups(['admin', 'bendahara'])) : ?>
              <li class="nav-item <?= $uri->getSegment(1) == 'profil' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('profil/index') ?>">
                      <i class="fas fa-fw fa-cog"></i>
                      <span>Pengaturan</span></a>
              </li>

          <?php endif ?>
          <?php if (in_groups('bendahara')) : ?>

              <li class="nav-item <?= $uri->getTotalSegments() == 2 && $uri->getSegment(2) == 'in_out' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('laporan/in_out/') ?>">
                      <i class="fas fa-fw fa-calendar-alt"></i>
                      <span>Laporan Operasional</span></a>
              </li>
              <li class="nav-item <?= $uri->getTotalSegments() == 2 && $uri->getSegment(2) == 'laba' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('laporan/laba') ?>">
                      <i class="fas fa-fw fa-calendar-alt"></i>
                      <span>Laporan Laba</span></a>
              </li>
              <li class="nav-item <?= $uri->getTotalSegments() == 2 && $uri->getSegment(2) == 'saldo' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('laporan/saldo') ?>">
                      <i class="fas fa-fw fa-calendar-alt"></i>
                      <span>Laporan Saldo</span></a>
              </li>
              <li class="nav-item <?= $uri->getTotalSegments() == 2 && $uri->getSegment(2) == 'keuangan' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('laporan/keuangan') ?>">
                      <i class="fas fa-fw fa-calendar-alt"></i>
                      <span>Laporan Keuangan</span></a>
              </li>
          <?php endif ?>
          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
              <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>

      </ul>
      <!-- End of Sidebar -->