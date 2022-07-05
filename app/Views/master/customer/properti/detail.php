<?php
if (in_groups(['admin', 'bendahara'])) {
    echo $this->extend('templates/index_sewa');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>

<?php $this->section('content') ?>

<div class="row">
    <div class="col">

        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pedagang</h6>
                <?php if (in_groups(['admin', 'bendahara'])) : ?>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="<?= base_url('Pedagang/edit/' . $customer['id'])  ?>">Ubah</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('Pedagang/delete/' . $customer['id'])  ?>" onclick="return confirm('Yakin ingin dihapus?')">Hapus</a>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <!-- Card Body -->
            <div class="card-body detail">
                <div class="row no-gutters">
                    <div class="col col-lg-8 col-md-12 col-xs-12 m-auto">
                        <table class="table table-borderless table-hover">
                            <tbody>
                                <tr>
                                    <td>Nama Lengkap</td>
                                    <td>:</td>
                                    <td><?= $customer['nama']; ?></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td><?= $customer['nik']; ?></td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td><?= $customer['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                </tr>
                                <tr>
                                    <td>Tempat/Tgl. Lahir</td>
                                    <td>:</td>
                                    <td><?= $customer['tempat_lahir'] . ", " . date('d-m-Y', strtotime($customer['tanggal_lahir'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td><?= $customer['alamat']; ?></td>
                                </tr>
                                <tr>
                                    <td>No Telepon</td>
                                    <td>:</td>
                                    <td><?= $customer['no_hp']; ?></td>
                                </tr>
                                <tr>
                                    <td>Jenis Usaha</td>
                                    <td>:</td>
                                    <td><?= $customer['jenis_usaha']; ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td><?= $customer['status'] == 1 ? 'Aktif' : 'Non-Aktif' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <?php if ($customer['created_at'] == $customer['updated_at']) : ?>
                    <small class="text-muted">Dibuat <?= date('d-m-Y H:i:s', strtotime($customer['created_at'])); ?></small>
                <?php elseif ($customer['updated_at'] !== $customer['created_at']) : ?>
                    <small class="text-muted">Diubah <?= date('d-m-Y H:i:s', strtotime($customer['updated_at'])); ?></small>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>