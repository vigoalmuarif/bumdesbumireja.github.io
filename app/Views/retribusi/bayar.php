<?= $this->extend('templates/index_retribusi'); ?>

<?= $this->section('content'); ?>
<a href="<?= base_url('periode/retribusi') ?>" class="btn btn-primary btn-sm mb-4">Kembali</a>
<?php if (session()->getFlashdata('pesan2')) : ?>
    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan2') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<h1 class="h3 mb-2 text-gray-800">Pembayaran Tagihan Bulanan</h1>
<hr class="sidebar-divider d-none d-md-block">

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col col-sm-12 col-lg-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm m-0">
                                <thead>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nama Pedagang</td>
                                        <td>:</td>
                                        <td><?= $get['nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kode Property</td>
                                        <td>:</td>
                                        <td><?= $get['kode_property']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Property</td>
                                        <td>:</td>
                                        <td><?= $get['jenis_property']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Usaha</td>
                                        <td>:</td>
                                        <td><?= $get['jenis_usaha'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tarif</td>
                                        <td>:</td>
                                        <td>Rp. <?= number_format($get['tarif'], 0, ".", ".") ?></td>
                                    </tr>
                                    <tr>
                                        <td>Periode</td>
                                        <td>:</td>
                                        <td><?= bulan_indo(date('Y-m-d', strtotime($get['periode']))) . ' ' . date('Y', strtotime($get['periode'])) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-sm-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="<?= base_url('pembayaran/prosesBayarTagihanBulanan/' . $get['tagihanBulanan_id']) ?>" method="post">
                            <?php csrf_field() ?>
                            <input type="hidden" name="periode_id" value="<?= $get['periode_id'] ?>">
                            <input type="hidden" name="tarif" value="<?= $get['tarif'] ?>">
                            <label for="bayar">Bayar</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                </div>
                                <input type="text" class="form-control  <?= $validation->hasError('bayar') ? 'is-invalid' : '' ?>" placeholder="Jumlah yang dibayarkan" name="bayar" value="<?= set_value('bayar') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('bayar') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="metode">Metode</label>
                                <select class="form-control <?= $validation->hasError('metode') ? 'is-invalid' : '' ?>" id="exampleFormControlSelect1" name="metode">
                                    <option value="" disabled selected hidden>--Belum dipilih--</option>
                                    <?php
                                    $payment = ['Transfer', 'Tunai']
                                    ?>
                                    <?php foreach ($payment as $metode) : ?>
                                        <option value="<?= $metode ?>" <?= set_value('metode') == $metode ? 'selected="selected"' : '' ?>><?= $metode ?></option>
                                    <?php endforeach ?>

                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('metode') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukan pesan"><?= set_value('keterangan'); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Bayar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>