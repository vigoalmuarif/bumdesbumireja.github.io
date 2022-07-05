  <?php $uri = service('uri') ?>
  <!-- Page Wrapper -->
  <div id="wrapper">

      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

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
          <li class="nav-item <?= $uri->getSegment(1) == 'dashboard' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('dashboard/retribusi') ?>">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
          </li>

          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
          <!-- Heading -->
          <div class="sidebar-heading">
              Persewaan & Tagihan Bulanan
          </div>
          <!-- Nav Item - Utilities Collapse Menu -->
          <li class="nav-item <?= $uri->getSegment(2) == 'index' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('retribusi/index') ?>">
                  <i class="fas fa-fw fa-money-bill-alt"></i>
                  <span>Setor</span></a>
          </li>

          <li class="nav-item <?= $uri->getSegment(2) == 'periodeRetribusi' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('retribusi/periodeRetribusi') ?>">
                  <i class="fas fa-fw fa-calendar-check"></i>
                  <span>Periode</span></a>
          </li>

          <li class="nav-item <?= $uri->getSegment(2) == 'list' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('retribusi/list') ?>">
                  <i class="fas fa-fw fa-biking"></i>
                  <span>Retribusi</span></a>
          </li>
          <li class="nav-item <?= $uri->getSegment(2) == 'petugas' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?= base_url('retribusi/petugas') ?>">
                  <i class="fas fa-fw fa-people-carry"></i>
                  <span>Petugas</span></a>
          </li>
          <?php if (in_groups('bendahara')) : ?>
              <div class=" sidebar-heading">
                  Laporan
              </div>
              <!-- Nav Item - Retribusi -->
              <li class="nav-item <?= $uri->getSegment(1) == 'laporan' ? 'active' : ''; ?>">
                  <a class="nav-link" href="<?= base_url('laporan/retribusi') ?>">
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