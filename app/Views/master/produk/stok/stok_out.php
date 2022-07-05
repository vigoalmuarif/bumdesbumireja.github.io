<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Stok Keluar Produk ATK</h1>
<hr class="sidebar-divider d-none d-md-block">
<a href="<?= base_url('produk/stok') ?>" class="btn btn-primary btn-sm mb-2"><i class="fi-rr-arrow-left"> </i>Kembali</a>
<!-- DataTales Example -->
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="<?= base_url('produk/less_stok/' . $prodak['produk_id']) ?>" class="btn btn-primary float-right btn-sm">
            Kurangi Stok Produk
        </a>
        <h6 class="m-0 font-weight-bold text-primary mt-2">Riwayat Stok Keluar "<?= $prodak['produk']; ?>"</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th>Tanggal</th>
                        <th>SKU</th>
                        <th>Nama</th>
                        <th>Keluar</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($produk as $products) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="width: 170px;"><?= date('d-m-Y H:i:s', strtotime($products['date_in'])) ?></td>
                            <td><?= $products['sku']; ?></td>
                            <td><?= $products['produk']; ?></td>
                            <td><?= number_format($products['qty'], 0, ".", "."); ?></td>
                            <td><?= $products['desc']; ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


<?php $this->endSection() ?>