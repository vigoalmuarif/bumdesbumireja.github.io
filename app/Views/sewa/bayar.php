<?= $this->extend('templates/index_sewa'); ?>

<?= $this->section('content'); ?>

<h1 class="h3 mb-2 text-gray-800">Pembayaran</h1>
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
                                        <td>No. Transaksi</td>
                                        <td>:</td>
                                        <td><?= $get['no_transaksi']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Penyewa</td>
                                        <td>:</td>
                                        <td><?= $get['nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td>:</td>
                                        <td><?= $get['nik']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?= $get['address']; ?></td>
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
                                        <td>Harga</td>
                                        <td>:</td>
                                        <td>Rp. <?= number_format($get['harga'], 0, ".", ".") . " / " . $get['jangka'] . " Tahun" ?></td>
                                    </tr>
                                    <tr>
                                        <td>Terbayar</td>
                                        <td>:</td>
                                        <td>Rp. <?= number_format($get['bayar'], 0, ".", ".") ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kekurangan</td>
                                        <td>:</td>
                                        <td>Rp. <?= number_format($get['harga'] - $get['bayar'], 0, ".", ".") ?></td>
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
                        <form action="<?= base_url('pembayaran/prosesPembayaranSewa/' . $get['sewa_id']) ?>" method="post">
                            <?php csrf_field() ?>
                            <input type="hidden" name="sewa_id" value="<?= $get['sewa_id']; ?>" id="">
                            <input type="hidden" name="kekurangan" value="<?= $get['harga'] - $get['bayar'] ?>" id="">
                            <input type="hidden" name="harga" value="<?= $get['harga'] ?>" id="">
                            <input type="hidden" name="pedagang" value="<?= $get['pedagang_id'] ?>" id="">
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
                                    <option value="Tunai" <?= set_value('metode') == "Tunai" ? 'selected="selected"' : '' ?>>Tunai</option>
                                    <option value="Transfer" <?= set_value('metode') == "Transfer" ? 'selected="selected"' : '' ?>>Transfer</option>

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