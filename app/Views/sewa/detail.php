<?php $this->Extend('templates/index_sewa') ?>

<?php $this->section('content') ?>
<h1 class="h3 mb-2 text-gray-800">Detail Sewa</h1>
<hr class="sidebar-divider d-none d-md-block">
<a href="<?= base_url('sewa') ?>" class="btn btn-primary btn-sm mb-3">Kembali</a>
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<?php $kurang = $get['harga'] - $get['bayar'] ?>
<?php if ($kurang > 0 && strtotime(date('Y-m-d', strtotime($get['tanggal_batas']))) < strtotime(date('Y-m-d'))) : ?>
    <div class="alert alert-danger mb-5" role="alert">
        <h4 class="alert-heading">Persewaan Selesai</h4>
        <p>Masa sewa <?= $get['kode_property'] ?> telah berakhir. <?= $get['nama'] ?> memiliki kekurangan sebesar Rp <?= number_format($kurang, 0, ".", ".") ?></p>
        <?php if (strtotime(date('Y-m-d', strtotime($get['tanggal_batas']))) < strtotime(date('Y-m-d H:i:s')) && $kurang > 0 && $get['sewa_status'] == 'Aktif') : ?>
            <hr>
            <p class="mb-0"><b>Note :</b> Segera Konfirmasi persewaan selesai agar property <?= $get['kode_property'] ?> bisa disewakan kembali.</p>
        <?php endif ?>
    </div>
<?php endif ?>
<?php if ($kurang <= 0 && strtotime(date('Y-m-d', strtotime($get['tanggal_batas']))) < strtotime(date('Y-m-d')) && $get['sewa_status'] == 'Aktif') : ?>
    <div class="alert alert-warning mb-5" role="alert">
        <h4 class="alert-heading">Persewaan Selesai</h4>
        <p>Masa sewa <?= $get['kode_property'] ?> telah Selesai.</p>
        <?php if (strtotime($get['tanggal_batas']) < strtotime(date('Y-m-d H:i:s')) && $get['sewa_status'] == 'Aktif') : ?>
            <hr>
            <p class="mb-0"> <b>Note:</b> Segera konfirmasi persewaan selesai agar property <?= $get['kode_property'] ?> bisa disewakan kembali.</p>
        <?php endif ?>
    </div>
<?php endif ?>
<?php if ($kurang <= 0 && strtotime(date('Y-m-d', strtotime($get['tanggal_batas']))) < strtotime(date('Y-m-d')) && $get['sewa_status'] == 'Selesai') : ?>
    <div class="alert alert-success mb-5" role="alert">
        <h4 class="alert-heading">Persewaan Selesai</h4>
        <p>Masa sewa <?= $get['kode_property'] ?> telah selesai</p>
        <?php if (strtotime($get['tanggal_batas']) < strtotime(date('Y-m-d H:i:s')) && $get['sewa_status'] == 'Aktif') : ?>
            <hr>
            <p class="mb-0"> <b>Note:</b> Harap segera konfirmasi persewaan selesai</p>
        <?php endif ?>
    </div>
<?php endif ?>
<div class="row">
    <div class="col">
        <div class="btn-group mb-1 float-right" role="group" aria-label="Basic example">

            <?php if (strtotime(date('Y-m-d', strtotime($get['tanggal_batas']))) < strtotime(date('Y-m-d')) && $kurang >= 0 && $get['sewa_status'] == 'Aktif') : ?>
                <form action="<?= base_url('sewa/sewaSelesai/') ?>">
                    <input type="hidden" name="sewa_id" value="<?= $get['sewa_id'] ?>">
                    <input type="hidden" name="pedagang_id" value="<?= $get['pedagang_id'] ?>">
                    <input type="hidden" name="property_id" value="<?= $get['property_id'] ?>">
                    <button type="submit" class="btn-success btn rounded-0 mr-1">Konfirmasi sewa selesai</button>
                </form>
            <?php endif ?>
            <a href="" class="btn btn-info rounded-0  mr-1">Cetak Semua</a>
            <a href="" class="btn btn-warning mr-1 rounded-0">Simpan PDF</a>
        </div>
    </div>
</div>
<div class="row mb-5">
    <div class="col col-md-12 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body m-0">
                <div class="row">
                    <div class="col col-md-12 col-lg-6">
                        <div class="card shadow-sm mb-5">
                            <div class="card-header">
                                Data Penyewa
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless  m-0 table-sm">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>NIK</td>
                                                <td>:</td>
                                                <td><?= $get['nik']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Nama</td>
                                                <td>:</td>
                                                <td><?= $get['nama']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Jenis Kelamin</td>
                                                <td>:</td>
                                                <td><?= $get['jenis_kelamin']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tempat/Tgl. Lahir</td>
                                                <td>:</td>
                                                <td><?= $get['tempat_lahir'] . ", " . date('d-m-Y', strtotime($get['tanggal_lahir'])) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td>:</td>
                                                <td><?= $get['address']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. Telp.</td>
                                                <td>:</td>
                                                <td><?= $get['no_hp']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Jenis Usaha</td>
                                                <td>:</td>
                                                <td><?= $get['jenis_usaha']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-6 col-md-12">
                        <div class="card shadow-sm mb-5">
                            <div class="card-header">
                                Data Property
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless m-0 table-sm">
                                        <thead>

                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td>Kode Property</td>
                                                <td>:</td>
                                                <td><?= $get['kode_property']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Jenis</td>
                                                <td>:</td>
                                                <td><?= $get['jenis_property']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Luas Tanah</td>
                                                <td>:</td>
                                                <td><?= $get['luas_tanah']; ?> m2</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Bangunan</td>
                                                <td>:</td>
                                                <td><?= $get['luas_bangunan']; ?> m2</td>
                                            </tr>
                                            <tr>
                                                <td>Sertifikat</td>
                                                <td>:</td>
                                                <td><?= $get['sertifikat']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Fasilitas</td>
                                                <td>:</td>
                                                <td><?= $get['fasilitas']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td>:</td>
                                                <td><?= $get['address2']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-5">
                    <div class="card-header">
                        Waktu
                    </div>
                    <div class="card-body m-0">
                        <div class="table-responsive">
                            <table class="table table-borderless m-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal Sewa</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= date_indo(date('Y-m-d', strtotime($get['tanggal_sewa']))); ?></td>
                                        <td><?= date_indo(date('Y-m-d', strtotime($get['tanggal_batas']))); ?></td>
                                        <td><?= $get['jangka']; ?> Tahun</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mb-5 shadow-sm">
                    <div class="card-header">
                        Pembayaran
                    </div>
                    <div class="card-body m-0">
                        <div class="table-responsive">
                            <table class="table table-borderless m-0">
                                <thead>
                                    <tr>
                                        <th>Harga</th>
                                        <th>Terbayar</th>
                                        <th>Kekurangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Rp. <?= number_format($get['harga'], 0, ".", ".") ?></td>
                                        <td>Rp. <?= number_format($get['bayar'], 0, ".", ".") ?></td>
                                        <td class="<?= $kurang == 0 ? 'text-success' : 'text-danger' ?>">Rp. <?= number_format(($kurang), 0, ".", ".") ?>
                                        </td>
                                        <td style="max-width: 40px;">
                                            <?php if ($kurang > 0) : ?>
                                                <a href="<?= base_url('pembayaran/sewa/' . $get['sewa_id']) ?>" class="btn btn-danger btn-sm">Bayar</a>
                                            <?php else : ?>
                                                <span class="badge badge-pill badge-success">Lunas</span>
                                            <?php endif ?>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header">
                        Riwayat Pembayaran
                    </div>
                    <div class="card-body m-0">
                        <div class="table-responsive">
                            <table class="table table-borderless  m-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Bayar</th>
                                        <th>Metode</th>
                                        <th>Keterangan</th>
                                        <th>Acc</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0 ?>
                                    <?php foreach ($log as $payment) : ?>
                                        <?php $total += $payment['bayar'] ?>
                                        <tr>
                                            <td><?= date('d-m-Y H:i', strtotime($payment['waktuBayar'])); ?></td>
                                            <td>Rp. <?= number_format($payment['bayar'], 0, ".", ".") ?></td>
                                            <td><?= $payment['metode']; ?></td>
                                            <td><?= $payment['keterangan']; ?></td>
                                            <td><?= $payment['username']; ?></td>
                                            <td>
                                                <a href="" class="btn btn-info btn-sm">Cetak</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>

                                </tbody>
                                <tfoot>
                                    <th>Total</th>
                                    <th colspan="4">Rp. <?= number_format($total, 0, ".", ".")  ?></th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table table-borderless m-0">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td>No. Transaksi</td>
                            <td class="text-right"><?= $get['no_transaksi']; ?></td>
                        </tr>
                        <tr>
                            <td>Dibuat</td>
                            <td class="text-right"><?= $get['username'] . " | " . date('d-m-Y H:i', strtotime($get['dibuat'])); ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php $this->endSection() ?>