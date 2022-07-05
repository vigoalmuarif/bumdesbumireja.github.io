<?php $uri = service('uri') ?>
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-warning sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard/ketua') ?>">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">BUMDes<sup>KM</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?= $uri->getSegment(1) == 'ketua' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('dashboard/ketua') ?>">
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
        <li class="nav-item <?= $uri->getSegment(1) == 'Petugas' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('petugas/index') ?>">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Pegawai BUMDes</span></a>
        </li>

        <li class="nav-item <?= $uri->getSegment(2) == 'petugas' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('retribusi/petugas') ?>">
                <i class="fas fa-fw fa-biking"></i>
                <span>Petugas Retribusi</span></a>
        </li>

        <li class="nav-item <?= $uri->getSegment(1) == 'pedagang' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('pedagang/index') ?>">
                <i class="fas fa-fw fa-people-carry"></i>
                <span>Pedagang</span></a>
        </li>
        <li class="nav-item <?= $uri->getSegment(1) == 'property' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('property/type/semua') ?>">
                <i class="fas fa-fw fa-store"></i>
                <span>Property</span></a>
        </li>
        <li class="nav-item <?= $uri->getSegment(1) == 'produk' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('produk/index') ?>">
                <i class="fas fa-fw fa-box"></i>
                <span>Produk ATK</span></a>
        </li>
        <div class=" sidebar-heading">
            Laporan
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Laporan Persewaan</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Persewaan</h6>
                    <a class="collapse-item" href="<?= base_url('laporan/sewa'); ?>">Laporan Sewa</a>
                    <a class=" collapse-item" href="<?= base_url('laporan/sewa/pajak_bulanan'); ?>">Laporan Tagihan Bulanan</a>
                </div>
            </div>
        </li>
        <!-- Nav Item - Retribusi -->
        <li class="nav-item <?= $uri->getSegment(2) == 'penjualan' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('laporan/penjualan') ?>">
                <i class="fas fa-fw fa-file-export"></i>
                <span>Laporan ATK</span>
            </a>
        </li>
        <li class="nav-item <?= $uri->getSegment(2) == 'retribusi' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('laporan/retribusi') ?>">
                <i class="fas fa-fw fa-file-export"></i>
                <span>Laporan Retribusi</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->