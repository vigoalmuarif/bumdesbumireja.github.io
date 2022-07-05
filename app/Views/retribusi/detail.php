<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<a href="<?= base_url('Periode/retribusi') ?>" class="btn btn-primary btn-sm mb-4 mt-0"><span class="fas fa-angle-left"></span> Kembali</a>
<h1 class="h3 mb-2 text-gray-800">Tagihan Retribusi</h1>
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

                <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Tagihan Retribusi <?= longdate_indo(date('Y-m-d', strtotime($periode['tanggal']))); ?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Retribusi</th>
                                <th>Petugas</th>
                                <th>Bayar</th>
                                <th>keterangan</th>

                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $no = 1; ?>
                            <?php foreach ($retribusi as $key) :   ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $key['nama_retribusi']; ?></td>
                                    <td><?= $key['nama_petugas']; ?></td>
                                    <td>Rp <?= number_format($key['bayar'], 0, ".", "."); ?></td>
                                    <td><?= $key['keterangan']; ?></td>
                                    <td>
                                        <?php if ($key['bayar'] == null) : ?>
                                            <a href="" class="btn btn-danger btn-sm">Bayar</a>
                                        <?php else : ?>
                                            <a href="" class="btn btn-warning btn-sm">Ubah</a>
                                        <?php endif  ?>


                                    </td>

                                </tr>

                            <?php endforeach ?>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total</th>
                                <th colspan="">Rp <?= number_format($key['bayar'], 0, ".", "."); ?></th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>