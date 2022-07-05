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
                <h6 class="m-0 font-weight-bold text-primary">Detail Property</h6>
                <?php if (in_groups(['admin', 'bendahara'])) : ?>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="<?= base_url('property/edit/' . $property_id['property_id'])  ?>">Ubah</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('property/delete/' . $property_id['property_id'])  ?>" onclick="return confirm('Yakin ingin dihapus?')">Hapus</a>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <!-- Card Body -->
            <div class="card-body detail">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-12 col-xs-12 my-auto">
                        <?php if ($property_id['gambar'] != 'store.png') : ?>
                            <img src="<?= base_url() ?>/img/upload/<?= $property_id['gambar']; ?>" alt="...">
                        <?php else : ?>
                            <img src="<?= base_url() ?>/img/store.png" alt="...">
                        <?php endif ?>
                    </div>
                    <div class="col-lg-6 col-md-12 col-xs-12">

                        <h5 class="card-title"><?= $property_id['kode_property']; ?></h5>
                        <p class="card-text"><?= $property_id['alamat']; ?></p>
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>jenis Property</td>
                                    <td><?= $property_id['jenis_property']; ?></td>
                                </tr>
                                <tr>
                                    <td>Luas Tanah</td>
                                    <td><?= $property_id['luas_tanah']; ?> m2</td>
                                </tr>
                                <tr>
                                    <td>Luas Bangunan</td>
                                    <td><?= $property_id['luas_bangunan']; ?> m2</td>
                                </tr>
                                <tr>
                                    <td>Fasilitas</td>
                                    <td><?= $property_id['fasilitas']; ?></td>
                                </tr>
                                <tr>
                                    <td>Harga</td>
                                    <td>Rp. <?= number_format($property_id['harga'], 0, ".", ".") . ' / ' . $property_id['jangka'] . ' Tahun' ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td><?= $property_id['alamat']; ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td><span class="badge <?= $property_id['status'] == 1 ? 'badge-success' : 'badge-danger' ?>"><?= $property_id['status'] == 1 ? 'Tersedia' : 'Disewa'; ?></span></td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td><?= $property_id['keterangan']; ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <?php if ($property_id['created_at'] == $property_id['updated_at']) : ?>
                    <small class="text-muted">Dibuat <?= date('d-m-Y H:i:s', strtotime($property_id['created_at'])); ?></small>
                <?php elseif ($property_id['updated_at'] !== $property_id['created_at']) : ?>
                    <small class="text-muted">Diubah <?= date('d-m-Y H:i:s', strtotime($property_id['updated_at'])); ?></small>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>