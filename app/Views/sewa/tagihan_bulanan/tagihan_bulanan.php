<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<a href="<?= base_url('Periode/tagihanbulanan') ?>" class="btn btn-primary btn-sm mb-4 mt-0"><span class="fas fa-angle-left"></span> Kembali</a>
<h1 class="h3 mb-2 text-gray-800">Tagihan Bulanan</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('sukses') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Tagihan Periode Bulan <?= bulan_indo(date('Y-m-d', strtotime($periode['periode']))) . ' ' . date('Y', strtotime($periode['periode'])); ?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kode Property</th>
                                <th>Tarif</th>
                                <th>Terbayar</th>
                                <th>Status</th>

                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $no = 1; ?>
                            <?php foreach ($bulanan as $key) :   ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $key['nama']; ?></td>
                                    <td><?= $key['kode_property']; ?></td>
                                    <td>Rp. <?= number_format($key['tarif'], 0, '.', '.'); ?></td>
                                    <td>Rp. <?= number_format($key['bayar'], 0, '.', '.'); ?></td>
                                    <td>
                                        <span class="badge badge-<?= $key['bulanan_status'] == 0 ? 'warning' : 'success' ?>"><?= $key['bulanan_status'] == 0 ? 'Menunggu' : 'Lunas' ?></span>
                                    </td>
                                    <td style="width: 120px;">
                                        <a href="<?= base_url('Pembayaran/bayarTagihanBulanan/' . $key['tagihanBulanan_id']) ?>" class="btn btn-sm btn-danger m-0  <?= $key['bulanan_status'] == 1 ? 'disabled' : '' ?>">Bayar</a>
                                        <a href="" class="btn btn-sm btn-info m-0">Cetak</a>
                                    </td>

                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>